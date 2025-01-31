@extends('layouts.app')
@section('title', 'Tabla de Posiciones')
@section('content')
    <style>
        .match-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 15px;
        }
        .match-logo {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }
        .team-name {
            font-size: 14px;
            margin: 0;
        }
    </style>
<div class="container my-5">
     <!-- Botón para ver el ranking -->
    {{-- <div class="text-left mt-3">
        <a href="{{ route('quiniela.form') }}" class="btn btn-secondary"><- Regresar</a>
    </div> --}}
    <h1 class="text-center">Tabla de Posiciones</h1>

    {{-- Puntos por Jornada/Fase --}}
    @if ($phase)
        <h2 class="text-center">Ranking - {{ is_numeric($phase) ? 'Jornada ' . $phase : ucfirst($phase) }}</h2>
        <table class="table table-bordered table-striped text-center mt-4">
            <thead>
                <tr>
                    <th>Posición</th>
                    <th>Usuario</th>
                    <th>Puntos</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rankings as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        @if($user['name'] == 'Ramiro')
                            <td> {{ $user['name'] }}<img src="/images/ramiro.png" style="width: 25px; height: 25px;"></td>
                        @elseif($user['name'] == 'Lugo')
                            <td> {{ $user['name'] ." 🎱"}}</td>
                        @else
                            <td>{{ $user['name'] }}</td>
                        @endif
                        <td>{{ $user['points'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Rankings -->
    <h2 class="text-center">Puntos Acumulados</h2>
    <table class="table table-bordered table-striped text-center mt-4">
        <thead>
            <tr>
                <th></th>
                <th>Posición</th>
                <th>Usuario</th>
                <th>Puntos Totales</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($overallRankings as $index => $user)
                @php
                    // Determinar el color según la posición
                    $borderColor = '';
                    if ($index < 4) {
                        $borderColor = 'border-bottom: 4px solid #007bff;'; // Azul
                    } elseif ($index < 7) {
                        $borderColor = 'border-bottom: 4px solid #ffc107;'; // Naranja
                    } elseif ($index < 9) {
                        $borderColor = 'border-bottom: 4px solid #28a745;'; // Verde
                    } elseif ($index >= count($overallRankings) - 2) {
                        $borderColor = 'border-bottom: 4px solid #dc3545;'; // Rojo
                    }
                @endphp
                <tr >
                    <td style="width: 10px; height: 100%;" ><div style="width: 10px; height: 100%; {{ $borderColor }} border-radius: 2px;"></div></td>
                    <td>{{ $index + 1 }}</td>
                    @if($user['name'] == 'Ramiro')
                        <td> {{ $user['name'] }}<img src="/images/ramiro.png" style="width: 25px; height: 25px;"></td>
                    @elseif($user['name'] == 'Lugo')
                        <td> {{ $user['name'] ." 🎱"}}</td>
                    @else
                        <td>{{ $user['name'] }}</td>
                    @endif
                    <td>{{ $user['total_points'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Partidos por fase -->
    @foreach ([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18, 'Quarters', 'Semifinals', 'Final'] as $phase)
        <h2 class="text-center mt-5">
        @if ($phase == 1 ) Jornada 1
        @elseif ($phase == 2 ) Jornada 2
        @elseif ($phase == 3 ) Jornada 3
        @elseif ($phase == 4 ) Jornada 4
        @elseif ($phase == 5 ) Jornada 5
        @elseif ($phase == 6 ) Jornada 6
        @elseif ($phase == 7 ) Jornada 7
        @elseif ($phase == 8 ) Jornada 8
        @elseif ($phase == 9 ) Jornada 9
        @elseif ($phase == 10 ) Jornada 10
        @elseif ($phase == 11 ) Jornada 11
        @elseif ($phase == 12 ) Jornada 12
        @elseif ($phase == 13 ) Jornada 13
        @elseif ($phase == 14 ) Jornada 14
        @elseif ($phase == 15 ) Jornada 15
        @elseif ($phase == 16 ) Jornada 16
        @elseif ($phase == 17 ) Jornada 17
        @elseif ($phase == 'Quarters') Cuartos de Final
        @elseif ($phase == 'Semifinals') Semifinales
        @elseif ($phase == 'Final') Final
        @endif
        </h2>
        <div class="row">
            @foreach ($matches[$phase] ?? [] as $match)
                <div class="col-md-6">
                    <div class="match-card d-flex align-items-center justify-content-between">
                        <div class="team d-flex align-items-center">
                            <img src="{{ $match->team_a_logo }}" alt="{{ $match->team_a }}" class="match-logo me-2">
                            <div>
                                <p class="team-name">{{ $match->team_a }}</p>
                            </div>
                        </div>
                        <div class="score">
                            <h5 class="mb-0">{{ $match->score_a ?? '-' }}</h5>
                        </div>
                        <div class="vs text-muted">VS</div>
                        <div class="score">
                            <h5 class="mb-0">{{ $match->score_b ?? '-' }}</h5>
                        </div>
                        <div class="team d-flex align-items-center">
                            <img src="{{ $match->team_b_logo }}" alt="{{ $match->team_b }}" class="match-logo me-2">
                            <div>
                                <p class="team-name">{{ $match->team_b }}</p>
                            </div>
                        </div>
                    </div>
                    @if (!isset($match->score_a) && !isset($match->score_b))
                        <p class="text-muted">Pronósticos aún habilitados</p>
                    @else
                        <p class="text-muted">Pronósticos cerrados</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection 
