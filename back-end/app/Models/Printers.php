<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Printers extends Model
{
    protected $fillable = [
        'id',
        'ip',
        'name',
        'system_driverinfo',
        'supplier_id'
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
