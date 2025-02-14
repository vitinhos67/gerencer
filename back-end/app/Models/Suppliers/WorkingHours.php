<?php

namespace App\Models\Suppliers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkingHours extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'working_hours';
    protected $fillable = ['supplier_id', 'day_of_week', 'is_closed', 'opening_time', 'closing_time'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'opening_time' => 'datetime',
        'closing_time' => 'datetime',
    ];

}
