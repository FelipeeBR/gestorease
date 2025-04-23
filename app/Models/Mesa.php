<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mesa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'numero',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'status' => 'string' // Opcional, mas útil para enums
    ];

    // Relacionamento com o usuário que criou a mesa
    public function criador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relacionamento com o usuário que atualizou a mesa
    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Escopo para mesas livres
    public function scopeLivres($query)
    {
        return $query->where('status', 'livre');
    }
}
