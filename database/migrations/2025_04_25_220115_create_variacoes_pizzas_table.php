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
        Schema::create('variacoes_pizzas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');
            $table->foreignId('tamanho_pizza_id')->constrained('tamanho_pizzas')->onDelete('cascade');
            $table->decimal('preco', 10, 2);
            $table->integer('estoque')->default(0);
            $table->enum('tipo', ['salgada', 'doce'])->default('salgada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variacoes_pizzas');
    }
};
