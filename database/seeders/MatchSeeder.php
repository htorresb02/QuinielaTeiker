<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FootballMatch;

class MatchSeeder extends Seeder
{
    public function run()
    {

        FootballMatch::create([
            'team_a' => 'América', 
            'team_b' => 'Toluca', 
            'team_a_logo' => 'https://ssl.gstatic.com/onebox/media/sports/logos/QKZVogU66ByvZRqIAIVtmA_96x96.png',
            'team_b_logo' => 'https://ssl.gstatic.com/onebox/media/sports/logos/ycTgfmECsg0S-aVXCOPXcA_96x96.png',
            'phase' => 'Quarters',
            'is_first_leg' => true,
        ]);
        FootballMatch::create([
            'team_a' => 'Tijuana', 
            'team_b' => 'Cruz Azul',
            'team_a_logo' => 'https://ssl.gstatic.com/onebox/media/sports/logos/LH2XadWT8Nk19o6SnbL4JA_96x96.png',
            'team_b_logo' => 'https://ssl.gstatic.com/onebox/media/sports/logos/hwsmDtw_ETdVCS410dye3Q_96x96.png',
            'phase' => 'Quarters',
            'is_first_leg' => true,
        ]);
        FootballMatch::create([
            'team_a' => 'Monterrey', 
            'team_b' => 'Pumas',
            'team_a_logo' => 'https://ssl.gstatic.com/onebox/media/sports/logos/LH2XadWT8Nk19o6SnbL4JA_96x96.png',
            'team_b_logo' => 'https://ssl.gstatic.com/onebox/media/sports/logos/LXZ8fEgzf0_FwSyq15buPw_96x96.png',
            'phase' => 'Quarters',
            'is_first_leg' => true,
        ]);
        FootballMatch::create([
            'team_a' => 'San Luis', 
            'team_b' => 'Tigres',
            'team_a_logo' => 'https://ssl.gstatic.com/onebox/media/sports/logos/ToSdfqXiatX8HuqqVcYgtA_96x96.png',
            'team_b_logo' => 'https://ssl.gstatic.com/onebox/media/sports/logos/SUJAIkxhbnmFXDpJY2gSww_96x96.png',
            'phase' => 'Quarters',
            'is_first_leg' => true,
        ]);

        FootballMatch::create([
            'team_a' => 'Toluca', 
            'team_b' => 'América', 
            'team_a_logo' => 'https://ssl.gstatic.com/onebox/media/sports/logos/ycTgfmECsg0S-aVXCOPXcA_96x96.png',
            'team_b_logo' => 'https://ssl.gstatic.com/onebox/media/sports/logos/QKZVogU66ByvZRqIAIVtmA_96x96.png',
            'phase' => 'Quarters',
            'is_first_leg' => false,
        ]);
        FootballMatch::create([
            'team_a' => 'Cruz Azul',
            'team_b' => 'Tijuana', 
            'team_a_logo' => 'https://ssl.gstatic.com/onebox/media/sports/logos/hwsmDtw_ETdVCS410dye3Q_96x96.png',
            'team_b_logo' => 'https://ssl.gstatic.com/onebox/media/sports/logos/LH2XadWT8Nk19o6SnbL4JA_96x96.png',
            'phase' => 'Quarters',
            'is_first_leg' => false,
        ]);
        FootballMatch::create([
            'team_a' => 'Pumas',
            'team_b' => 'Monterrey', 
            'team_a_logo' => 'https://ssl.gstatic.com/onebox/media/sports/logos/LXZ8fEgzf0_FwSyq15buPw_96x96.png',
            'team_b_logo' => 'https://ssl.gstatic.com/onebox/media/sports/logos/LH2XadWT8Nk19o6SnbL4JA_96x96.png',
            'phase' => 'Quarters',
            'is_first_leg' => false,
        ]);
        FootballMatch::create([
            'team_a' => 'Tigres',
            'team_b' => 'San Luis', 
            'team_a_logo' => 'https://ssl.gstatic.com/onebox/media/sports/logos/SUJAIkxhbnmFXDpJY2gSww_96x96.png',
            'team_b_logo' => 'https://ssl.gstatic.com/onebox/media/sports/logos/ToSdfqXiatX8HuqqVcYgtA_96x96.png',
            'phase' => 'Quarters',
            'is_first_leg' => false,
        ]);
    }
}