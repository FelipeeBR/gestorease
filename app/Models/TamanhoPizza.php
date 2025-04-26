<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\VariacaoPizza;

class TamanhoPizza extends Model
{
    protected $fillable = ['nome'];
    public function variacoes_pizza()
    {
        return $this->hasMany(VariacaoPizza::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($tamanho) {
            if ($tamanho->variacoes_pizza()->count() > 0) {
                throw new \Exception("Não pode deletar tamanho com produtos vinculados");
            }
        });
    }
}
