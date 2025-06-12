<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            ['nome' => 'Bebidas'],
            ['nome' => 'Petiscos'],
            ['nome' => 'Pizza'],
            ['nome' => 'Prato'],
            ['nome' => 'Lanche']
        ];
        if(Categoria::count() > 0) {
            return;
        }
        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
