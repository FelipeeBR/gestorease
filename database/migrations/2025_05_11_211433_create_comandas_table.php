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
        Schema::create('comandas', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['mesa', 'delivery', 'balcao']);
            $table->string('numero_mesa')->nullable();
            $table->string('cliente')->nullable();
            $table->text('endereco')->nullable();
            $table->string('telefone')->nullable();
            $table->enum('status', ['aberta', 'fechada', 'cancelada']);
            $table->enum('forma_pagamento', ['dinheiro', 'credito', 'debito', 'pix', 'outro']);
            $table->decimal('total', 10, 2);
            $table->foreignId('caixa_id')->references('id')->on('caixas');
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comandas');
    }
};
