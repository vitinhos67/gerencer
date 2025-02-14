<?php

namespace App\Services\Order;

use App\Models\Orders\OrderProducts;

class OrderProductsService
{
    public function create(array $products, int $order_id)
    {
        $data = [];
        foreach ($products as $product) {
            for ($i = 0; $i < $product['quantity']; $i++) {
                $data[] = [
                    'order_id' => $order_id,
                    'product_id' => $product['product_id'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }
        return OrderProducts::insert($data);
    }
}
