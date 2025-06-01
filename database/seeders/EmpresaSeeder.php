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
        $empresa->nome = 'N/A';
        $empresa->cnpj = 'N/A';
        $empresa->telefone = 'N/A';
        $empresa->email = 'N/A';
        $empresa->endereco = 'N/A';
        $empresa->numero = 'N/A';
        $empresa->bairro = 'N/A';
        $empresa->cidade = 'N/A';
        $empresa->uf = 'NA';
        $empresa->cep = 'N/A';
        $empresa->save();
    }
}
