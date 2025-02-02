<?php

namespace App\Models\Orders;

use App\Models\User\UserAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    use SoftDeletes;

    protected $fillable = ['user_id', 'user_address_id', 'status', 'delivery_type', 'payment_method_id', 'paid', 'supplier_id'];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class, 'user_address_id');
    }

    public function ScopeGetUser($query)
    {
        return $query->leftJoin('users as u', 'u.id', 'orders.user_id');
    }

    public function ScopeGetPaymentMethod($query)
    {
        return $query->leftJoin('payment_methods as pm', 'orders.payment_method_id', 'pm.id');
    }

}
