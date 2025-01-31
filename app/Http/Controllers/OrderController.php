<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_address_id' => 'nullable|integer|exists:user_addresses,id',
            'delivery_type' => 'required|string|max:255|in:pickup,delivery',
            'status_id' => 'required|integer|exists:order_statuses,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        
            // 'address' é obrigatório se 'user_address_id' não for enviado e 'delivery_type' for 'delivery'
            'address' => 'required_if:delivery_type,delivery|required_without:user_address_id|array',
            'address.street' => 'required_with:address|string',
            'address.number' => 'required_with:address|string',
            'address.complement' => 'nullable|string',
            'address.neighborhood' => 'required_with:address|string',
            'address.city' => 'required_with:address|string',
            'address.state' => 'required_with:address|string',
            'address.zip_code' => 'required_with:address|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        $validatedData = $validator->validated();
        $service = new OrderService;
        $order = $service->create($validatedData, $request->user());

        return response()->json($order, 201);

    }

}
