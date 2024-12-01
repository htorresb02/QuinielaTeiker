<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Posiciones</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('logo-liga_mx.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
</head>
<body>
<div class="container my-5">
     <!-- Botón para ver el ranking -->
    <div class="text-left mt-3">
        <a href="{{ route('quiniela.form') }}" class="btn btn-secondary"><- Regresar</a>
    </div>
    <h1 class="text-center">Tabla de Posiciones</h1>

    <!-- Rankings -->
    <table class="table table-bordered table-striped text-center mt-4">
        <thead>
            <tr>
                <th>Posición</th>
                <th>Usuario</th>
                <th>Puntos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rankings as $index => $ranking)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $ranking['name'] }}</td>
                    <td>{{ $ranking['points'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Partidos por fase -->
    @foreach (['Quarters', 'Semifinals', 'Final'] as $phase)
        <h2 class="text-center mt-5">
            @if ($phase == 'Quarters') Cuartos de Final
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