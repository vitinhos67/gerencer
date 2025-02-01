<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{   
    use SoftDeletes;

    protected $table = 'user_addresses';
    protected $fillable = ['user_id', 'street', 'number', 'complement', 'neighborhood', 'city', 'state', 'zip_code'];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime', 
            'updated_at' => 'datetime', 
            'deleted_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
