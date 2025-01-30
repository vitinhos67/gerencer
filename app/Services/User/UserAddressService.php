<?php

namespace App\Services\User;

use App\Models\UserAddress;

class UserAddressService
{
    public static function create(array $data)
    {
        $userAddress = new UserAddress();
        $userAddress->user_id = $data['user_id'];
        $userAddress->street = $data['street'];
        $userAddress->number = $data['number'];
        $userAddress->neighborhood = $data['neighborhood'];
        $userAddress->complement = $data['complement'];
        $userAddress->city = $data['city'];
        $userAddress->state = $data['state'];
        $userAddress->zip_code = $data['zip_code'];
        $userAddress->save();
        return $userAddress;
    }
}