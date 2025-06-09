<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TamanhoPizza;

class TamanhoPizzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tamanhos = [
            ['nome' => 'Grande'],
            ['nome' => 'Media'],
            ['nome' => 'Pequena'],
        ];

        if (TamanhoPizza::count() > 0) {
            return;
        }

        foreach ($tamanhos as $tamanho) {
            TamanhoPizza::create($tamanho);
        }
    }
}
