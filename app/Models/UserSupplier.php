<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSupplier extends Model
{   
    use SoftDeletes;
    protected $table = 'supplier_user';
    protected $fillable = ['user_id', 'supplier_id'];
}
