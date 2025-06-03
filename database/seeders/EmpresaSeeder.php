<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Empresa;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empresa = new Empresa();
        $empresa->nome = 'Gestor EASE';
        $empresa->cnpj = '00000000000100';
        $empresa->telefone = '00000000000';
        $empresa->email = 'N/A';
        $empresa->endereco = 'N/A';
        $empresa->numero = 'N/A';
        $empresa->bairro = 'N/A';
        $empresa->cidade = 'N/A';
        $empresa->uf = 'MG';
        $empresa->cep = '00000000';
        $empresa->save();
    }
}
