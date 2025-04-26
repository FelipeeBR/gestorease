<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\VariacaoPizza;

class TamanhoPizza extends Model
{
    protected $table = 'tamanho_pizza';

    protected $fillable = ['nome'];

    public function pizza_variacao()
    {
        return $this->hasMany(VariacaoPizza::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($tamanho) {
            if ($tamanho->pizza_variacao()->count() > 0) {
                throw new \Exception("Não pode deletar tamanho com produtos vinculados");
            }
        });
    }
}
