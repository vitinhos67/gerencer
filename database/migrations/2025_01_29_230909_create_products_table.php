<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255); 
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->integer('stock_quantity')->default(0);
            $table->string('sku', 100)->unique();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('image_url', 255)->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->json('additional')->nullable();
            $table->string('status', 50)->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
