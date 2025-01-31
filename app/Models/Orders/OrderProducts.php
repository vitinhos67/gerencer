<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProducts extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "order_product";

    protected $fillable = [
        'order_id',
        'product_id'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime', 
            'updated_at' => 'datetime', 
            'deleted_at' => 'datetime',
        ];
    }

}
