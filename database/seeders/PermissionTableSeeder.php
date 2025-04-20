<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            [
                'name' => 'users.index',
                'description' => 'Exibir Usuários',
                'table_id' => 2,
            ],
            [
                'name' => 'users.create',
                'description' => 'Criar Usuários',
                'table_id' => 2,
            ],
            [
                'name' => 'users.store',
                'description' => 'Gravar Usuários',
                'table_id' => 2,
            ],
            [
                'name' => 'users.edit',
                'description' => 'Editar Usuários',
                'table_id' => 2,
            ],
            [
                'name' => 'users.update',
                'description' => 'Atualizar Usuários',
                'table_id' => 2,
            ],
            [
                'name' => 'users.show',
                'description' => 'Exibir um Usuário',
                'table_id' => 2,
            ],
            [
                'name' => 'users.destroy',
                'description' => 'Excluir Usuário',
                'table_id' => 2,
            ],
        ]);
    }
}
