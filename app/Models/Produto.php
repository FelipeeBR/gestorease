<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;

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
}
