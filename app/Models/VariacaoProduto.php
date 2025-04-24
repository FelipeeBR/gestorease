<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Produto;

class VariacaoProduto extends Model
{
    protected $fillable = ['nome', 'valor', 'preco_adicional'];
    
    public function produto() {
        return $this->belongsTo(Produto::class);
    }
}
