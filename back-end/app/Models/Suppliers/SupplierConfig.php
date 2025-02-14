<?php

namespace App\Models\Suppliers;

use Illuminate\Database\Eloquent\Model;

class SupplierConfig extends Model
{
    protected $table = 'supplier_config';

    protected $fillable = [
        'id',
        'is_active',
        'average_time',
        'delivery_fee',
        'supplier_id',
        'coverage_area',
        'type',
        'average_rating',
        'order_limit',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function supplier()
    {
        return $this->belongsTo(Suppliers::class, 'supplier_id');
    }

}
