<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin' => [
                'description' => 'Administrador com acesso total ao sistema',
                'permissions' => Permission::all()->pluck('name')->toArray()
            ],
            'gerente' => [
                'description' => 'Gerente do estabelecimento',
                'permissions' => [
                    'gerenciar_mesas', // Permissão para gerenciar as mesas
                    'gerenciar_produtos',
                    'gerenciar_usuarios', // Permissão para gerenciar os usuários
                    'gerenciar_funcionarios',// Permissão para gerenciar os funcionários
                    'fechar_comanda', // Permissão para fechar a comanda
                    'abrir_comanda', // Permissão para abrir a comanda
                    'registrar_pedidos',
                    'modificar_pedidos',
                    'gerar_relatorios',
                    'gerenciar_estoque',
                    'emitir_comprovante'
                ]
            ],
            'garcom' => [
                'description' => 'Garçom/Garçonete',
                'permissions' => [
                    'abrir_comanda',
                    'registrar_pedidos',
                    'gerenciar_mesas',
                    'emitir_comprovante',
                    'fechar_comanda',
                ]
            ],
            'caixa' => [
                'description' => 'Operador de caixa',
                'permissions' => [
                    'fechar_comanda',
                    'emitir_comprovante'
                ]
            ]
        ];

        foreach ($roles as $name => $data) {
            $role = Role::firstOrCreate(
                ['name' => $name],
                ['description' => $data['description']]
            );

            $permissions = Permission::whereIn('name', $data['permissions'])->pluck('id');
            $role->permissions()->sync($permissions);
        }
    }
}
