<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $statuses = [
            ['status' => 'pending', 'created_at', now(), 'updated_at', now()],
            ['status' => 'under_review', 'created_at', now(), 'updated_at', now()],
            ['status' => 'approved', 'created_at', now(), 'updated_at', now()],
            ['status' => 'processing', 'created_at', now(), 'updated_at', now()],
            ['status' => 'on_hold', 'created_at', now(), 'updated_at', now()],
        ];

        DB::table('order_statuses')->insert($statuses);
    }
}
