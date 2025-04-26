<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TamanhoPizza;
use App\Models\Produto;

class VariacaoPizza extends Model
{
    protected $table = 'variacao_pizza';

    protected $fillable = [
        'produto_id',
        'tamanho_pizza_id',
        'preco',
        'estoque',
        'tipo'
    ];

    protected $casts = [
        'preco' => 'decimal:2'
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function tamanhoPizza()
    {
        return $this->belongsTo(TamanhoPizza::class, 'tamanho_pizza_id');
    }

    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}
