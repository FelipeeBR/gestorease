<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comanda extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'numero_mesa',
        'cliente',
        'endereco',
        'telefone',
        'status',
        'total',
        'caixa_id',
        'observacoes',
    ];

    // Relacionamento com Caixa
    public function caixa()
    {
        return $this->belongsTo(Caixa::class);
    }

    // Relacionamento com os itens da comanda
    public function itens()
    {
        return $this->hasMany(ItemComanda::class);
    }
}
