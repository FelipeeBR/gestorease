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
        Schema::create('caixas', function (Blueprint $table) {
            $table->id();
            $table->dateTime('data_abertura'); // Abrir o caixa
            $table->dateTime('data_fechamento')->nullable(); // Fechar o caixa
            $table->decimal('saldo_inicial', 10, 2); // Definir o saldo inicial
            $table->decimal('saldo_final', 10, 2)->nullable(); // saldo apos fechar o caixa
            $table->decimal('total_vendas', 10, 2)->nullable(); // total de vendas no caixa
            //$table->decimal('total_suprimentos', 10, 2)->nullable(); // 
            $table->foreignId('user_id')->references('id')->on('users');
            $table->text('observacoes')->nullable(); // Observações para anotar alguma coisa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caixas');
    }
};
