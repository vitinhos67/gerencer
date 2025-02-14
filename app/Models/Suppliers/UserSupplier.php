<?php

namespace App\Models\Suppliers;

use Illuminate\Database\Eloquent\Model;

class UserSupplier extends Model
{  
    protected $table = 'supplier_user';
    protected $fillable = ['user_id', 'supplier_id'];


    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}
