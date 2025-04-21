<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Produto;

class Categoria extends Model
{
    protected $fillable = ['nome'];

    // Relacionamento com Produtos
    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($categoria) {
            if ($categoria->produtos()->count() > 0) {
                throw new \Exception("Não pode deletar categoria com produtos vinculados");
            }
        });
    }
}
