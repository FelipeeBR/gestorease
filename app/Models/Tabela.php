<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tabela extends Model
{
    protected $fillable = [
        'name',
        'description',
        'table',
    ];
}
