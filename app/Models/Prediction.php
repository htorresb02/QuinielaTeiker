<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    use HasFactory;

    // Permitir asignación masiva
    protected $fillable = [
        'user_id',
        'match_id',
        'predicted_score_a',
        'predicted_score_b',
    ];

    protected $guarded = ['id']; // Protege solo el campo "id"

    public function match()
    {
        return $this->belongsTo(FootballMatch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function predictions()
    {
        return $this->hasMany(Prediction::class, 'match_id');
    }
}
