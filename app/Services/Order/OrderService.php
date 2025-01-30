<?php

namespace App\Services\Order;

use App\Models\OrderProducts;
use App\Models\Orders\Order;
use App\Services\User\UserAddressService;

class OrderService
{
    public function create(array $data)
    {
        if (!data_get($data, 'user_address_id') && $data['delivery_type'] == 'delivery') {
            $data['address']['user_id'] = $data['user_id'];
            $address = UserAddressService::create($data['address']);
            $data['user_address_id'] = $address->id;
        }

        $order = new Order();
        $order->user_id = $data['user_id'];
        $order->user_address_id = $data['user_address_id'];
        $order->status = $data['status'];
        $order->delivery_type = $data['delivery_type'];
        $order->save();
        
        $orderProducts = new OrderProductsService();
        $orderProducts->create($data['products'], $order->id);

        return $order;
    }
}
