<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_integrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->string('provider');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->longText('secret_key')->nullable();
            $table->longText('public_key')->nullable();
            $table->longText('access_token')->nullable();
            $table->longText('user')->nullable();
            $table->boolean('active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_integrations');
    }
};
