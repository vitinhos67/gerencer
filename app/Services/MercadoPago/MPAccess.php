<?php

namespace App\Services\MercadoPago;

use App\Models\Orders\Order;
use App\Models\PaymentIntegrations;
use App\Models\Transactions\Transactions;
use App\Utils\Utils;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;

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
                "transaction_amount" => $data['amount'],
                "description" => $data['description'] ?? null,
                "payment_method_id" => $data['payment_method_id'],
                "payer" => [
                    "first_name" => $data['first_name'],
                    "last_name" => $data['last_name'],
                    "email" => $data['email'],
                ],
                "external_reference" => $transactions->reference,
            ];

            /*             if (env('APP_ENV') == 'PROD') {
            $paymentOptions['notification_url'] = env('APP_URL') . "/transactions/notification/$transactions->reference";
            } */

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
                'external_id' => $content['id'],
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

    public function confirmPayment(PaymentIntegrations $integration, Transactions $transactions)
    {
        try {
            $accessToken = $this->getAcessToken($integration);
            $getPayment = $this->fetchConfirmPayment($transactions->external_id, $accessToken);

            switch ($getPayment['status']) {
                case 'approved':
                    $transactions->status = 'paid';
                    $transactions->paid_at = now();
                    $transactions->update();

                    $order = Order::where('id', $transactions->order_id)->first();
                    $order->status = 3; // Aproved
                    break;
                case 'pending':
                    //
            }

            return true;
        } catch (\Throwable $th) {
            return false;
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
        try {
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
        } catch (\Throwable $th) {
            return false;
        }

    }

    private function fetchConfirmPayment($id, $access)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $access,
            ])->get($this->base_url . "/v1/payments/$id");
            if ($response->successful()) {
                return $response->json();
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function confirmOrigin(string $secret): bool
    {
        $xSignature = $_SERVER['HTTP_X_SIGNATURE'] ?? null;
        $xRequestId = $_SERVER['HTTP_X_REQUEST_ID'] ?? null;
        $queryParams = $_GET;
        $dataID = $queryParams['data_id'] ?? null;

        if (!$dataID) {
            return false;
        }
        $parts = explode(',', $xSignature);

        $ts = null;
        $hash = null;

        foreach ($parts as $part) {
            $keyValue = explode('=', $part, 2);
            if (count($keyValue) == 2) {
                $key = trim($keyValue[0]);
                $value = trim($keyValue[1]);

                if ($key === "ts") {
                    $ts = $value;
                } elseif ($key === "v1") {
                    $hash = $value;
                }
            }
        }
        if (!$ts || !$hash) {
            return false;
        }

        $manifest = "id:$dataID;request-id:$xRequestId;ts:$ts;";
        $sha = hash_hmac('sha256', $manifest, $secret);
        return hash_equals($sha, $hash);
    }
}
