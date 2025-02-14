<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_config', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->boolean('is_active')->default(true);
            $table->integer('average_time')->nullable();
            $table->decimal('delivery_fee', 8, 2)->nullable();
            $table->string('coverage_area')->nullable();
            $table->string('type')->nullable();
            $table->decimal('average_rating', 3, 2)->nullable();
            $table->integer('order_limit')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_config');
    }
};
