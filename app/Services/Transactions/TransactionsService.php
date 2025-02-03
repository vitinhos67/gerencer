<?php

namespace App\Services\Transactions;

use App\Models\PaymentIntegrations;
use App\Models\Transactions\Transactions;
use App\Services\MercadoPago\MPAccess;

class TransactionsService
{
    public function receiving(array $data)
    {
        if ($data['type'] != 'payment') {
            return true;
        }

        $transactions = Transactions::where('external_id', $data['data']['id'])
        ->leftJoin('orders', 'orders.id', '=', 'transactions.order_id')
        ->leftJoin('suppliers', 'suppliers.id', '=', 'orders.supplier_id')
        ->select(
            'transactions.*', 
            'suppliers.id as supplier_id'
        )
        ->first();

        switch ($data['action']) {
            case 'payment.created':
                break;
            case 'payment.updated':
                return $this->searchPayment($transactions);
                break;

        }

        return true;
    }

    public function searchPayment($transactions)
    {
        $paymentIntegration = PaymentIntegrations::where('supplier_id', $transactions->supplier_id)->first();
        $mp = new MPAccess;
        return $mp->confirmPayment($paymentIntegration, $transactions);
    }
}
