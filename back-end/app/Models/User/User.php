<?php

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\User\UserAddress;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function userSupplier()
    {
        return $this->hasOne('App\Models\Suppliers\UserSupplier');
    }
    public function getSupplierAttribute()
    {
        return $this->userSupplier ? $this->userSupplier->supplier : null;
    }
    public function getIsAdminAttribute()
    {
        return $this->hasRole('admin');
    }
    public function getIsSupplierAttribute()
    {
        return $this->hasRole('supplier');
    }
    public function getIsClientAttribute()
    {
        return $this->hasRole('client');
    }
    public function getIsSuperAdminAttribute()
    {
        return $this->hasRole('super-admin');
    }           
}
