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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->decimal('preco_venda', 10, 2);
            $table->text('descricao')->nullable();
            $table->integer('quantidade_estoque')->default(0);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->foreignId('categoria_id')->constrained('categorias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
