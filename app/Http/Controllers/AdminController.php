<?php
namespace App\Http\Controllers;

use App\Models\FootballMatch;
use App\Models\Ranking;
use App\Models\Prediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        Auth::loginUsingId(1);
        return redirect()->route('admin.results');
    }

    // Mostrar formulario para capturar resultados
    public function showResultsForm()
    {
    	$matches = FootballMatch::where('activo', 1)->get()->groupBy('phase'); // Agrupar partidos por fase
    	return view('admin.results', compact('matches'));

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

    public function activeAllQuinielas()
    {

        Prediction::join('matches', 'predictions.match_id', '=', 'matches.id')
            ->where('matches.activo', 1)
            ->update(['predictions.activo' => '1']);

        return redirect()->back()->with('success', 'Se activaron las quinielas.');
    }

    public function showAllQuinielas()
    {
        // Obtener todos los usuarios con sus predicciones
        $result = DB::table('users')
            ->leftJoin('predictions', 'users.id', '=', 'predictions.user_id')
            ->leftJoin('matches', 'predictions.match_id', '=', 'matches.id')
            ->select(
                'users.id', 
                'users.name', 
                DB::raw('COUNT(CASE WHEN matches.activo = 1 OR matches.id IS NULL THEN predictions.id END) as total_predicciones'),
                DB::raw('CASE WHEN COUNT(CASE WHEN matches.activo = 1 OR matches.id IS NULL THEN predictions.id END) = 0 THEN true ELSE false END as falta_capturar')
            )
            ->groupBy('users.id', 'users.name')
            ->get();

        // Separar usuarios en dos grupos
        $usuariosCompletos = $result->where('total_predicciones', '>', 0);
        $usuariosFaltantes = $result->where('falta_capturar', true);

        return view('admin.quiniela-capturadas', compact('usuariosCompletos', 'usuariosFaltantes'));
    }

    public function showMatchForm()
    {
        $phases = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17, 'Quarters', 'Semifinals', 'Final'];
        $teams = DB::table('rankings')->select('club', 'logo')->get();
        $matches = FootballMatch::orderBy('phase')->orderBy('is_first_leg')->get()->groupBy('phase');
        
        return view('admin.matches', compact('phases', 'teams', 'matches'));
    }

    public function activatePhaseMatches(Request $request)
    {
        $request->validate([
            'phase' => 'required'
        ]);

        FootballMatch::where('phase', $request->phase)
            ->update(['activo' => 1]);

        return redirect()->route('admin.matches')
            ->with('success', "Partidos de la fase {$request->phase} activados correctamente");
    }

    public function deactivatePhaseMatches(Request $request)
    {
        $request->validate([
            'phase' => 'required'
        ]);

        FootballMatch::where('phase', $request->phase)
            ->update(['activo' => 0]);

        return redirect()->route('admin.matches')
            ->with('success', "Partidos de la fase {$request->phase} desactivados correctamente");
    }

    public function createMatch(Request $request)
    {

        $request->validate([
            'team_a' => 'required|string',
            'team_b' => 'required|string|different:team_a',
            'phase' => 'required|string',
            'team_a_logo' => 'required|string',
            'team_b_logo' => 'required|string',
        ]);

        // Crear partido de ida
        FootballMatch::create([
            'team_a' => $request->team_a,
            'team_b' => $request->team_b,
            'team_a_logo' => $request->team_a_logo,
            'team_b_logo' => $request->team_b_logo,
            'phase' => $request->phase,
            'is_first_leg' => true,
            'activo' => 0
        ]);

        // Crear partido de vuelta
        if(in_array($request->phase, ['Quarters', 'Semifinals', 'Final'])){
            FootballMatch::create([
                'team_a' => $request->team_b,
                'team_b' => $request->team_a,
                'team_a_logo' => $request->team_b_logo,
                'team_b_logo' => $request->team_a_logo,
                'phase' => $request->phase,
                'is_first_leg' => true,
                'activo' => 0
            ]);
        }

        return redirect()->route('admin.matches')->with('success', 'Partidos creados correctamente');
    }
}
