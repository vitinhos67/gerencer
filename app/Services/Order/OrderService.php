<?php

namespace App\Services\Order;

use App\Models\Orders\Order;
use App\Models\User\User;
use App\Services\User\UserAddressService;

class OrderService
{
    public function create(array $data, User $user)
    {
        if (!data_get($data, 'user_address_id') && $data['delivery_type'] == 'delivery') {
            $data['address']['user_id'] = $user->id;
            $address = UserAddressService::create($data['address']);
            $data['user_address_id'] = $address->id;
        }
        $order = $this->saveOrder($data, $user);

        $orderProducts = new OrderProductsService();
        $orderProducts->create($data['products'], $order->id);

        return $order;
    }

    private function saveOrder($data, $user)
    {
        $order = new Order($data);
        $order->user_id = $user->id;
        $order->status_id = $data['status_id'];

        $order->save();
        return $order;
    }
}
