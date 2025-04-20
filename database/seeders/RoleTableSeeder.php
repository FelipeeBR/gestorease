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
                    'gerenciar_mesas',
                    'fechar_comanda',
                    'modificar_pedidos',
                    'gerar_relatorios',
                    'consultar_estoque'
                ]
            ],
            'garcom' => [
                'description' => 'Garçom/Garçonete',
                'permissions' => [
                    'abrir_comanda',
                    'registrar_pedidos',
                    'gerenciar_mesas'
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
