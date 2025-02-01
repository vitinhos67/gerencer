<?php

namespace App\Services\Payment;

use App\Models\Orders\Order;
use App\Models\Orders\OrderProducts;
use App\Models\Transactions\Transactions;
use App\Services\MercadoPago\MPAccess;
use App\Utils\Utils;

class PaymentService
{
    public function make(array $data)
    {
        $order = Order::getPaymentMethod()
            ->getUser()
            ->where('orders.id', $data['order_id'])
            ->select('orders.*', 'pm.id as payment_method_id', 'pm.code', 'u.name as user_name', 'u.email as user_email', 'u.id as user_id')
            ->first();

        $products = OrderProducts::where('order_id', $order->id)->getProducts()->select('p.price')->get();

        $amount = $products->sum(function ($product) {
            return $product->price;
        });

        $fee = floatval($order->fee);
        $totalAmount = $amount + ($amount * ($fee / 100));
        list($firstName, $lastName) = array_pad(explode(' ', $order->user_name, 2), 2, '');

        $transaction = $this->createTransaction([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'status' => 'pending',
            'amount' => $totalAmount,
            'payment_method_id' => $order->payment_method_id,
            'transaction' => null,
            'metadata' => null,
        ]);

        $data = [
            'amount' => $totalAmount,
            'payment_method_id' => $order->code,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $order->user_email,
        ];

        $mpAccess = new MPAccess();
        return $mpAccess->makePayment($transaction, $data);
    }

    public static function createTransaction(array $data): Transactions
    {
        $payment = new Transactions();
        $payment->user_id = $data['user_id'];
        $payment->order_id = $data['order_id'];
        $payment->reference = Utils::uuid();
        $payment->status = $data['status'];
        $payment->amount = $data['amount'];
        $payment->payment_method_id = $data['payment_method_id'];
        $payment->metadata = $data['metadata'];
        $payment->save();
        return $payment;
    }

}
