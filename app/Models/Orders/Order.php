<?php

namespace App\Models\Orders;

use App\Models\User;
use App\Models\User\UserAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    use SoftDeletes;

    protected $fillable = ['user_id', 'user_address_id', 'status', 'delivery_type'];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime', 
            'updated_at' => 'datetime', 
            'deleted_at' => 'datetime',
        ];
    }

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
