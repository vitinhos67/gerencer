<?php

namespace App\Models\Transactions;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MercadoPago\Resources\Customer\PaymentMethod;

class Transactions extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'id',
        'user_id',
        'order_id',
        'reference',
        'status',
        'amount',
        'currency',
        'payment_method_id',
        'metadata',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending'  => 'Pendente',
            'paid'     => 'Pago',
            'failed'   => 'Falhou',
            'refunded' => 'Reembolsado',
            default    => 'Desconhecido',
        };
    }
}
