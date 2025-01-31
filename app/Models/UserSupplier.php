<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSupplier extends Model
{  
    protected $table = 'supplier_user';
    protected $fillable = ['user_id', 'supplier_id'];
}
