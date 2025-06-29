<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Models\Orders\Order;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;

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

    public function getProducts(Request $request)
    {
        $orders  = Order::where('supplier_id', $request->user()->userSupplier()->first()->supplier_id)->get();
        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }
}
