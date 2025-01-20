<?php

namespace App\Http\Controllers;

use App\Models\FootballMatch;
use App\Models\Prediction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuinielaController extends Controller
{
    public function showForm(Request $request)
    {
        // Validar clave única del usuario
        $uniqueKey = $request->input('unique_key');
        $user = $uniqueKey ? User::where('unique_key', $uniqueKey)->first() : null;

        // Si no hay usuario, regresar sin datos de predicciones
        if (!$user) {
            return view('quiniela.form', [
                'matches' => FootballMatch::where('activo', 1)->get()->groupBy('phase'),
                'userPredictions' => [],
                'user' => null,
                'pendingMatches' => [],
            ]);
        }

        // Cargar predicciones existentes del usuario
        $userPredictions = Prediction::where('user_id', $user->id)
            ->get()
            ->keyBy('match_id'); // Organizar por match_id

        // Determinar partidos pendientes (que no tienen predicción)
        $pendingMatches = FootballMatch::whereNotIn('id', $userPredictions->keys()->toArray())
            ->get()
            ->groupBy('phase');

        // Cargar todos los partidos agrupados por fase
    	$matches = FootballMatch::all()->where('activo', 1)->groupBy('phase');
    	return view('quiniela.form', compact('matches', 'userPredictions', 'user', 'pendingMatches'));

    }

    public function submitForm(Request $request)
    {
        date_default_timezone_set('America/Costa_Rica');
        $request->validate([
            'unique_key' => 'required|exists:users,unique_key',
            'predictions' => 'required|array',
        ]);

        $user = User::where('unique_key', $request->input('unique_key'))->first();

        foreach ($request->input('predictions') as $matchId => $scores) {
            // Verificar si ya existe un pronóstico para este partido
            $existingPrediction = Prediction::where('user_id', $user->id)
                ->where('match_id', $matchId)
                ->first();

            if (!$existingPrediction) {
                // Crear un nuevo pronóstico si no existe
                Prediction::create([
                    'user_id' => $user->id,
                    'match_id' => $matchId,
                    'predicted_score_a' => $scores['score_a'],
                    'predicted_score_b' => $scores['score_b'],
                ]);
            }else{
                // Redirigir al usuario con un mensaje de error
                return redirect()->back()->with('error', 'Ya has enviado tus predicciones. No puedes volver a capturar.');
            }
        }

        return redirect()->back()->with('success', 'Tus predicciones han sido guardadas.');

    }

    public function ranking($phase = null)
    {

	    // Obtener usuarios con predicciones
        $users = User::with(['predictions.match'])->get();
        $phase = FootballMatch::where('activo', 1)->latest('id')->pluck('phase')->first();
        // Filtrar partidos activos y, si se especifica, de una jornada/fase específica
        $query = FootballMatch::where('activo', 1);
        if ($phase) {
            $query->where('phase', $phase);
        }
        $matches = $query->get()->groupBy('phase');

        // Calcular puntos por usuario para la jornada/fase especificada
        $rankings = $users->map(function ($user) use ($phase) {
            $points = 0;

            foreach ($user->predictions as $prediction) {
                $match = $prediction->match;

                // Ignorar partidos fuera de la jornada/fase especificada
                if ($phase && $match->phase !== $phase) {
                    continue;
                }

                if (isset($match->score_a, $match->score_b)) {
                    // Regla 1: Marcador exacto
                    if (
                        $match->score_a == $prediction->predicted_score_a &&
                        $match->score_b == $prediction->predicted_score_b
                    ) {
                        $points += 3;
                    }
                    // Regla 2: Empate predicho correctamente (sin importar el marcador exacto)
                    elseif (
                        $match->score_a == $match->score_b && // Resultado oficial es empate
                        $prediction->predicted_score_a == $prediction->predicted_score_b // Usuario predijo empate
                    ) {
                        $points += 1;
                    }
                    // Regla 3: Ganador correcto (sin marcador exacto)
                    elseif (
                        ($match->score_a > $match->score_b && $prediction->predicted_score_a > $prediction->predicted_score_b) || // Usuario acertó que ganó el equipo A
                        ($match->score_a < $match->score_b && $prediction->predicted_score_a < $prediction->predicted_score_b)    // Usuario acertó que ganó el equipo B
                    ) {
                        $points += 1;
                    }
                }
            }

            return [
                'name' => $user->name,
                'points' => $points,
            ];
        })->sortByDesc('points')->values();

        // Calcular puntos acumulados
        $overallRankings = $users->map(function ($user) {
            $totalPoints = 0;

            foreach ($user->predictions as $prediction) {
                $match = $prediction->match;

                if (isset($match->score_a, $match->score_b)) {
                    // Regla 1: Marcador exacto
                    if (
                        $match->score_a == $prediction->predicted_score_a &&
                        $match->score_b == $prediction->predicted_score_b
                    ) {
                        $totalPoints += 3;
                    }
                    // Regla 2: Empate predicho correctamente (sin importar el marcador exacto)
                    elseif (
                        $match->score_a == $match->score_b && // Resultado oficial es empate
                        $prediction->predicted_score_a == $prediction->predicted_score_b // Usuario predijo empate
                    ) {
                        $totalPoints += 1;
                    }
                    // Regla 3: Ganador correcto (sin marcador exacto)
                    elseif (
                        ($match->score_a > $match->score_b && $prediction->predicted_score_a > $prediction->predicted_score_b) || // Usuario acertó que ganó el equipo A
                        ($match->score_a < $match->score_b && $prediction->predicted_score_a < $prediction->predicted_score_b)    // Usuario acertó que ganó el equipo B
                    ) {
                        $totalPoints += 1;
                    }
                }
            }

            return [
                'name' => $user->name,
                'total_points' => $totalPoints,
            ];
        })->sortByDesc('total_points')->values();

        return view('quiniela.ranking', compact('rankings', 'overallRankings', 'matches', 'phase'));
    }
    public function capturedResults()
    {
        // Recuperar partidos con predicciones y usuarios
	   $matches = FootballMatch::with(['predictions' => function ($query) {
            $query->where('activo', 1); // Solo predicciones activas
        }])->get();

        return view('quiniela.captured-results', compact('matches'));
    }

    public function dashboard()
    {
        // Obtener usuarios con predicciones
        $users = User::with(['predictions.match'])->get();
        
        // Obtener todas las fases disponibles
        $phases = FootballMatch::where('activo', 1)
            ->distinct()
            ->pluck('phase');
        
        // Estadísticas por fase
        $phaseStats = [];
        foreach ($phases as $phase) {
            $phaseStats[$phase] = $this->calculatePhaseStats($users, $phase);
        }
        
        // Top 5 usuarios con más predicciones exactas
        $topPerfectPredictions = $this->getTopPerfectPredictions($users);
        
        // Estadísticas generales
        $generalStats = [
            'total_users' => $users->count(),
            'total_matches' => FootballMatch::where('activo', 1)->count(),
            'total_predictions' => Prediction::count(),
            'average_points' => $users->avg('total_points'),
        ];
        
        // Datos para gráficas
        $chartData = [
            'phases' => $phases->toArray(),
            'pointsPerPhase' => $this->getPointsPerPhase($users, $phases),
            'perfectPredictionsPerPhase' => $this->getPerfectPredictionsPerPhase($users, $phases),
        ];
        
        return view('quiniela.dashboard', compact(
            'phaseStats', 
            'topPerfectPredictions', 
            'generalStats', 
            'chartData'
        ));
    }

    private function calculatePhaseStats($users, $phase)
    {
        $stats = [
            'total_points' => 0,
            'perfect_predictions' => 0,
            'participants' => 0,
        ];
        
        foreach ($users as $user) {
            $userPhasePoints = 0;
            $userPerfectPredictions = 0;
            $hasParticipated = false;
            
            foreach ($user->predictions as $prediction) {
                if ($prediction->match->phase === $phase) {
                    $hasParticipated = true;
                    
                    if (isset($prediction->match->score_a, $prediction->match->score_b)) {
                        // Contar predicciones perfectas
                        if ($prediction->match->score_a == $prediction->predicted_score_a &&
                            $prediction->match->score_b == $prediction->predicted_score_b) {
                            $userPerfectPredictions++;
                            $userPhasePoints += 3;
                        }
                        // Contar otros aciertos
                        elseif ($this->isCorrectResult($prediction)) {
                            $userPhasePoints += 1;
                        }
                    }
                }
            }
            
            if ($hasParticipated) {
                $stats['participants']++;
                $stats['total_points'] += $userPhasePoints;
                $stats['perfect_predictions'] += $userPerfectPredictions;
            }
        }
        
        return $stats;
    }

    private function getTopPerfectPredictions($users)
    {
        return $users->map(function ($user) {
            $perfectPredictions = $user->predictions->filter(function ($prediction) {
                return isset($prediction->match->score_a, $prediction->match->score_b) &&
                       $prediction->match->score_a == $prediction->predicted_score_a &&
                       $prediction->match->score_b == $prediction->predicted_score_b;
            })->count();
            
            return [
                'name' => $user->name,
                'perfect_predictions' => $perfectPredictions
            ];
        })->sortByDesc('perfect_predictions')
          ->take(5)
          ->values();
    }

    private function isCorrectResult($prediction)
    {
        $match = $prediction->match;
        
        // Empate predicho correctamente
        if ($match->score_a == $match->score_b && 
            $prediction->predicted_score_a == $prediction->predicted_score_b) {
            return true;
        }
        
        // Ganador correcto
        return ($match->score_a > $match->score_b && $prediction->predicted_score_a > $prediction->predicted_score_b) ||
               ($match->score_a < $match->score_b && $prediction->predicted_score_a < $prediction->predicted_score_b);
    }

    private function getPointsPerPhase($users, $phases)
    {
        $pointsPerPhase = [];
        
        foreach ($phases as $phase) {
            $pointsPerPhase[$phase] = $users->sum(function ($user) use ($phase) {
                return $user->predictions
                    ->where('match.phase', $phase)
                    ->sum(function ($prediction) {
                        return $this->calculatePredictionPoints($prediction);
                    });
            });
        }
        
        return $pointsPerPhase;
    }

    private function getPerfectPredictionsPerPhase($users, $phases)
    {
        $perfectPredictions = [];
        
        foreach ($phases as $phase) {
            $perfectPredictions[$phase] = $users->sum(function ($user) use ($phase) {
                return $user->predictions
                    ->where('match.phase', $phase)
                    ->filter(function ($prediction) {
                        return isset($prediction->match->score_a, $prediction->match->score_b) &&
                               $prediction->match->score_a == $prediction->predicted_score_a &&
                               $prediction->match->score_b == $prediction->predicted_score_b;
                    })->count();
            });
        }
        
        return $perfectPredictions;
    }

    private function calculatePredictionPoints($prediction)
    {
        if (!isset($prediction->match->score_a, $prediction->match->score_b)) {
            return 0;
        }
        
        if ($prediction->match->score_a == $prediction->predicted_score_a &&
            $prediction->match->score_b == $prediction->predicted_score_b) {
            return 3;
        }
        
        return $this->isCorrectResult($prediction) ? 1 : 0;
    }
}
