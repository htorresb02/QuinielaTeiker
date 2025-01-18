<?php
namespace App\Http\Controllers;

use App\Models\FootballMatch;
use App\Models\Ranking;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $accessCode = 'ADMIN123'; // Cambia este código según lo que necesites

    // Mostrar formulario para ingresar clave de acceso
    public function showAccessForm()
    {
        return view('admin.access');
    }

    // Validar clave de acceso
    public function validateAccess(Request $request)
    {
        $request->validate([
            'access_code' => 'required',
        ]);

        if ($request->access_code !== $this->accessCode) {
            return redirect()->route('admin.access')->with('error', 'Clave incorrecta.');
        }

        return redirect()->route('admin.results');
    }

    // Mostrar formulario para capturar resultados
    public function showResultsForm()
    {
<<<<<<< HEAD
	$matches = FootballMatch::where('activo', 1)->get()->groupBy('phase'); // Agrupar partidos por fase
	return view('admin.results', compact('matches'));
=======
        $matches = FootballMatch::where('activo', 1)->get()->groupBy('phase'); // Agrupar partidos por fase
        return view('admin.results', compact('matches'));
>>>>>>> d2933f6797b016b248c63e88fe57bcd23cfd941e
    }

    // Capturar resultados y avanzar equipos
    public function submitResults(Request $request)
    {
        $results = $request->input('results', []);

        foreach ($results as $matchId => $scores) {
            $match = FootballMatch::find($matchId);

            // Validar que los datos del partido existan antes de guardarlos
            if (isset($scores['score_a']) && isset($scores['score_b'])) {
                $match->score_a = $scores['score_a'];
                $match->score_b = $scores['score_b'];
                $match->save();
            }
        }

        // Avanzar equipos automáticamente
        // $this->advanceTeams();

        return redirect()->route('admin.results')->with('success', 'Resultados guardados y equipos avanzados.');
    }

    // Lógica para avanzar equipos
    public function advanceTeams()
    {
        // Determinar la fase actual y la siguiente
        $currentPhase = 'Quarters';
        $nextPhase = 'Semifinals';

        // Si ya estamos en semifinales, pasar a la final
        if (FootballMatch::where('phase', 'Semifinals')->exists()) {
            $currentPhase = 'Semifinals';
            $nextPhase = 'Final';
        }

        // Obtener partidos de la fase actual
        $matches = FootballMatch::where('phase', $currentPhase)->get();

        // Verificar si todos los partidos tienen resultados completos
        foreach ($matches as $match) {
            if (is_null($match->score_a) || is_null($match->score_b)) {
                return "No se puede avanzar, aún hay partidos pendientes en la fase {$currentPhase}";
            }
        }

        // Obtener tabla de posiciones
        $rankings = Ranking::pluck('rank', 'club')->toArray();

        $qualifiedTeams = [];

        // Determinar ganadores de cada llave
        // Determinar ganadores de cada llave
        foreach ($matches->groupBy(fn($match) => [$match->team_a, $match->team_b]) as $groupedMatches) {
            $firstLeg = $groupedMatches->where('is_first_leg', true)->first();
            $secondLeg = $groupedMatches->where('is_first_leg', false)->first();

            if ($firstLeg && $secondLeg) {
                // Calcular resultados globales
                $totalA = $firstLeg->score_a + $secondLeg->score_b;
                $totalB = $firstLeg->score_b + $secondLeg->score_a;

                if ($totalA > $totalB) {
                    $winner = $firstLeg->team_a;
                    $winnerLogo = $firstLeg->team_a_logo;
                } elseif ($totalB > $totalA) {
                    $winner = $firstLeg->team_b;
                    $winnerLogo = $firstLeg->team_b_logo;
                } else {
                    // Empate global, usar ranking
                    $rankA = $rankings[$firstLeg->team_a] ?? PHP_INT_MAX;
                    $rankB = $rankings[$firstLeg->team_b] ?? PHP_INT_MAX;

                    if ($rankA < $rankB) {
                        $winner = $firstLeg->team_a;
                        $winnerLogo = $firstLeg->team_a_logo;
                    } else {
                        $winner = $firstLeg->team_b;
                        $winnerLogo = $firstLeg->team_b_logo;
                    }
                }

                // Añadir al array de clasificados si no está duplicado
                $qualifiedTeams[$winner] = [
                    'team' => $winner,
                    'logo' => $winnerLogo,
                    'rank' => $rankings[$winner] ?? PHP_INT_MAX,
                ];
            }
        }

        // Convertir los valores del array en una lista ordenada de equipos únicos
        $qualifiedTeams = array_values($qualifiedTeams);

        // Ordenar equipos clasificados por ranking ascendente
        usort($qualifiedTeams, fn($a, $b) => $a['rank'] <=> $b['rank']);

        // Crear partidos para la siguiente fase
        $numTeams = count($qualifiedTeams);
        // dd($qualifiedTeams, $nextPhase);
        for ($i = 0; $i < $numTeams / 2; $i++) {
            $teamA = $qualifiedTeams[$i];
            $teamB = $qualifiedTeams[$numTeams - 1 - $i];

            // Validar que ambos equipos están definidos
            if (!isset($teamA['team']) || !isset($teamB['team'])) {
                continue;
            }

            // Validar si ya existe el partido de ida
            $existsFirstLeg = FootballMatch::where('team_a', $teamA['team'])
                ->where('team_b', $teamB['team'])
                ->where('phase', $nextPhase)
                ->where('is_first_leg', true)
                ->exists();

            if (!$existsFirstLeg) {
                // Crear partido de ida
                $firstLegTeams =[
                    'team_a' => $teamA['team'],
                    'team_b' => $teamB['team'],
                    'team_a_logo' => $teamA['logo'],
                    'team_b_logo' => $teamB['logo'],
                    'phase' => $nextPhase,
                    'is_first_leg' => true,
                ];

                FootballMatch::create($firstLegTeams);
            }

            // Validar si ya existe el partido de vuelta
            $existsSecondLeg = FootballMatch::where('team_a', $teamB['team'])
                ->where('team_b', $teamA['team'])
                ->where('phase', $nextPhase)
                ->where('is_first_leg', false)
                ->exists();

            if (!$existsSecondLeg) {
                // Crear partido de vuelta
                $secondLegTeams =[
                    'team_a' => $teamB['team'],
                    'team_b' => $teamA['team'],
                    'team_a_logo' => $teamB['logo'],
                    'team_b_logo' => $teamA['logo'],
                    'phase' => $nextPhase,
                    'is_first_leg' => false,
                ];
                FootballMatch::create($secondLegTeams);
            }
        }

        return "Partidos de {$nextPhase} generados correctamente";
    }
}
