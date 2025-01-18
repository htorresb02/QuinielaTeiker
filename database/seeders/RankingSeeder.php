<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ranking;

class RankingSeeder extends Seeder
{
    public function run()
    {
        $rankings = [
            ['club' => 'Cruz Azul', 'rank' => 1],
            ['club' => 'Toluca', 'rank' => 2],
            ['club' => 'Tigres', 'rank' => 3],
            ['club' => 'Pumas', 'rank' => 4],
            ['club' => 'Monterrey', 'rank' => 5],
            ['club' => 'San Luis', 'rank' => 6],
            ['club' => 'Tijuana', 'rank' => 7],
            ['club' => 'América', 'rank' => 8],
        ];

        foreach ($rankings as $ranking) {
            Ranking::create($ranking);
        }
    }
}