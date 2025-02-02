<?php

namespace App\Services\MercadoPago;

use App\Models\PaymentIntegrations;
use App\Models\Transactions\Transactions;
use App\Utils\Utils;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;

class MPAccess
{

    private $base_url = 'https://api.mercadopago.com';

    public function makePayment(Transactions $transactions, array $data, PaymentIntegrations $integration)
    {
        try {
            $accessToken = $this->getAcessToken($integration);
            MercadoPagoConfig::setAccessToken($accessToken);
            $client = new PaymentClient();
            $request_options = new RequestOptions();
            $uuid = Utils::uuid();
            $request_options->setCustomHeaders(["X-Idempotency-Key: $uuid"]);

            $paymentOptions = [
                "transaction_amount" => 1.00,
                "description" => $data['description'] ?? null,
                "payment_method_id" => $data['payment_method_id'],
                "payer" => [
                    "first_name" => $data['first_name'],
                    "last_name" => $data['last_name'],
                    "email" => $data['email'],
                ],
                "external_reference" => $transactions->reference,
            ];

            if (env('APP_ENV') == 'PROD') {
                $paymentOptions['notification_url'] = env('APP_URL') . "/notification/$transactions->reference";
            }

            $payment = $client->create($paymentOptions, $request_options);
            if (!($payment->getResponse()->getStatusCode() == 201)) {
                return [
                    'success' => false,
                ];
            }
            $content = $payment->getResponse()->getContent();

            return [
                'success' => true,
                'qr_code' => $content['point_of_interaction']['transaction_data']['qr_code'],
                'qr_code_base64' => $content['point_of_interaction']['transaction_data']['qr_code_base64'],
            ];
        } catch (MPApiException $e) {
            return [
                'success' => false,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
            ];
        }
    }

    private function getAcessToken($integration)
    {
        return $this->fetchAccess(Crypt::decryptString($integration->secret_key), Crypt::decryptString($integration->user));
    }

    private function paymentMethods($accessToken)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get($this->base_url . '/v1/payment_methods');

        if ($response->successful()) {
            return $response->json();
        } else {
            return false;
        }
    }

    private function fetchAccess($secret, $user)
    {
        $response = Http::post($this->base_url . '/oauth/token', [
            'client_secret' => $secret,
            'client_id' => $user,
            'grant_type' => 'client_credentials',
        ]);
        if ($response->successful()) {
            $body = $response->json();
            return data_get($body, 'access_token');
        } else {
            false;
        }
    }
}
