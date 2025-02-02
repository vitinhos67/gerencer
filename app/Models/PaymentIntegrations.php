<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentIntegrations extends Model
{

    protected $fillable = [
        'id',
        'provider',
        'supplier_id',
        'public_key',
        'secret_key',
        'access_token',
        'user',
        'active',
    ];

    protected $hidden = [
        'public_key',
        'secret_key',
        'access_token',
        'user',
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
