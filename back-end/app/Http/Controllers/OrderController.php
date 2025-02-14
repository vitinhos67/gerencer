<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Services\Order\OrderService;

class OrderController extends Controller
{
    public function create(CreateOrderRequest $request)
    {
        $validatedData = $request->validated();
        $service = new OrderService;
        $order = $service->create($validatedData, $request->user());;
        if(!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Contém produtos que não pertence ao fornecedor.'
            ], 401);
        }
        
        return response()->json($order, 201);
    }

}
