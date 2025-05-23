<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'description',
        'table_id',
    ];

    public function role()
    {
        return $this->belongsToMany(Role::class);
    }
}
