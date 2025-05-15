<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemComanda extends Model
{
    use HasFactory;

    protected $table = 'itens_comanda';

    protected $fillable = [
        'comanda_id',
        'produto_id',
        'borda_id',
        'quantidade',
        'preco_unitario',
        'subtotal',
    ];

    // Relacionamento com Comanda
    public function comanda()
    {
        return $this->belongsTo(Comanda::class);
    }

    // Relacionamento com Produto
    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
