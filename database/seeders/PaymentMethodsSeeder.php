<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payment_methods')->insert([
            [
                'name' => 'Cartão de Crédito',
                'active' => true,
                'code' => 'credit_card',
                'icon' => null,
                'fee' => 0.0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pix',
                'active' => true,
                'code' => 'pix',
                'icon' => null,
                'fee' => 0.0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}