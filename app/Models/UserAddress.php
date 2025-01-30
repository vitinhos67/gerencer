<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'user_addresses';
    protected $fillable = ['user_id', 'street', 'number', 'complement', 'neighborhood', 'city', 'state', 'zip_code'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
