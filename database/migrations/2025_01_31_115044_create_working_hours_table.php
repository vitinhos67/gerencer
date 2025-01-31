<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('working_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade'); // Relacionamento com o fornecedor
            $table->enum('day_of_week', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])->nullable(); // Dia da semana
            $table->time('opening_time')->nullable(); // Horário de abertura
            $table->time('closing_time')->nullable(); // Horário de fechamento
            $table->boolean('is_closed')->nullable(); // Indica se o estabelecimento estará fechado no proximo dia
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('working_hours');
    }
};