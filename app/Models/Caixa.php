<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caixa extends Model
{
    use HasFactory;

    protected $table = 'caixas';

    protected $fillable = [
        'data_abertura',
        'data_fechamento',
        'saldo_inicial',
        'saldo_final',
        'total_vendas',
        'user_id',
        'observacoes'
    ];

    protected $casts = [
        'data_abertura' => 'datetime',
        'data_fechamento' => 'datetime',
        'saldo_inicial' => 'decimal:2',
        'saldo_final' => 'decimal:2',
        'total_vendas' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Verifica se o caixa está aberto
    public function isAberto()
    {
        return is_null($this->data_fechamento);
    }
}