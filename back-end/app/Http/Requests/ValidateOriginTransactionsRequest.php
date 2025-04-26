<?php

namespace App\Http\Requests;

use App\Models\Transactions\Transactions;
use App\Services\MercadoPago\MPAccess;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class ValidateOriginTransactionsRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (env('APP_ENV') == 'local') {
            return true;
        } else {
            $transactionId = $this->input('data.id');
            $transactions = Transactions::where('external_id', $transactionId)
                ->leftJoin('orders', 'orders.id', '=', 'transactions.order_id')
                ->leftJoin('suppliers', 'suppliers.id', '=', 'orders.supplier_id')
                ->leftJoin('payment_integrations', function (JoinClause $join) {
                    $join->on('payment_integrations.supplier_id', '=', 'suppliers.id')
                        ->where('payment_integrations.active', true);
                })
                ->select(
                    'transactions.*',
                    'suppliers.id as supplier_id',
                    'payment_integrations.secret_key',
                    'payment_integrations.access_token',
                )
                ->first();

            if (!$transactions) {
                return false;
            }

            $secret = Crypt::decryptString($transactions->secret_key);
            return MPAccess::confirmOrigin($secret);
        }
    }

    public function rules(): array
    {
        return [
            'action' => 'required|string',
            'data' => 'required|array',
            'data.id' => 'required|integer|min:1',
            'type' => 'required|string',
        ];
    }
}
