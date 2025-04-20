<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TabelaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tabelas')->insert([
            [
                'name' => 'Tabelas',
                'description' => 'Tabelas com tables',
                'table' => 'tabelas',
            ],
            [
                'name' => 'Usuário',
                'description' => 'Tabelas de Usuário',
                'table' => 'users',
            ],
            [
                'name' => 'Funções',
                'description' => 'Tabelas de funçoes',
                'table' => 'roles',
            ],
            [
                'name' => 'Permissões',
                'description' => 'Tabelas de permissões',
                'table' => 'permissions',
            ],
        ]);
    }
}
