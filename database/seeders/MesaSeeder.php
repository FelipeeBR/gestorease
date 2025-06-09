<?php

namespace Database\Seeders;

use App\Models\Mesa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mesas = [
            [
                'numero' => 1,
                'status' => 'livre',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'numero' => 2,
                'status' => 'livre',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'numero' => 3,
                'status' => 'livre',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'numero' => 4,
                'status' => 'livre',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'numero' => 5,
                'status' => 'livre',
                'created_by' => 1,
                'updated_by' => 1
            ]
        ];
        if (Mesa::count() > 0) {
            return;
        }
        foreach ($mesas as $mesa) {
            Mesa::create($mesa);
        }
    }
}
