<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;
use App\Models\VariacaoProduto;

class Produto extends Model
{
    protected $fillable = [
        'nome',
        'preco_venda',
        'categoria_id',
        'descricao',
        'quantidade_estoque',
        'ativo'
    ];
    
    protected $casts = [
        'preco_venda' => 'decimal:2',
        'ativo' => 'boolean'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function variacoes() {
        return $this->hasMany(VariacaoProduto::class);
    }
    
    // Helper para pizzas
    public function tamanhosDisponiveis() {
        return $this->variacoes()
            ->where('nome', 'Tamanho')
            ->pluck('valor', 'id');
    }
}
