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
        Schema::create('itens_comanda', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comanda_id')->constrained();
            $table->foreignId('produto_id')->constrained();
            $table->foreignId('borda_id')->nullable()->constrained()->references('id')->on('borda_pizza');
            $table->foreignId('variacao_pizza_id')->nullable()->references('id')->on('variacao_pizza');
            $table->integer('quantidade');
            $table->decimal('preco_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2); // preco_unitario * quantidade
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itens_comanda');
    }
};
