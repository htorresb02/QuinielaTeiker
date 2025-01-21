<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FootballMatch extends Model
{
    use HasFactory;
    public $table = "matches";
    protected $fillable = ['team_a', 'team_b', 'score_a', 'score_b', 'phase', 'team_a_logo', 'team_b_logo', 'is_first_leg', 'activo'];

    public function predictions()
    {
        return $this->hasMany(Prediction::class, 'match_id');
    }
}