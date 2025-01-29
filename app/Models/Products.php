<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use SoftDeletes;

    protected $casts = [
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
        'stock_quantity',
        'sku',
        'category_id',
        'image_url',
        'weight',
        'additional',
        'status',
        'rating'
    ];


}
