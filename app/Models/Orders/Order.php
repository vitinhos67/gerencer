<?php

namespace App\Models\Orders;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'user_address_id', 'status', 'delivery_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class, 'user_address_id');
    }

    public function products()
    {
        return $this->belongsToMany(OrderProducts::class, 'order_product');
    }
}
