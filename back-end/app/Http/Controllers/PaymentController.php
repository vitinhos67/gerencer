<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Services\Payment\PaymentService;

class PaymentController extends Controller
{
    public function create(PaymentRequest $request)
    {
        $validatedData = $request->validated();
        $service = new PaymentService();
        $payment = $service->create($validatedData);
        if (!data_get($payment, 'success')) {
            return response()->json([
                'success' => false,
                'data' => 'Não foi possivel realizar o pagamento',
            ], 400);
        }

        return response()->json($payment, 201);
    }

}
