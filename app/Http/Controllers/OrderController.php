<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Models\User\UserAddress;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function create(CreateOrderRequest $request)
    {
        $validatedData = $request->validated();
        $service = new OrderService;
        $order = $service->create($validatedData, $request->user());
        return response()->json($order, 201);
    }

}
