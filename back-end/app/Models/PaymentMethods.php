<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethods extends Model
{
    use HasFactory, SoftDeletes;


    protected $table = "payment_methods";

    protected $fillable = [
        'name',
        'code',
        'active',
        'icon',
        'fee'
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
