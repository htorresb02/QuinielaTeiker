<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Predicciones</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('logo-liga_mx.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <!-- Instrucciones de la Quiniela -->
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title text-center">Instrucciones de la Quiniela</h2>
            <p class="card-text">
                Bienvenido a la quiniela Teiker de la Liga MX. Aquí encontrarás las reglas y detalles para participar:
            </p>
            <ul>
                <li><strong>Costo de participación:</strong> $50 MXN Por Semana. $10 al acumulado.</li>
                <li><strong>Reglas de puntuación:</strong></li>
                <ul>
                    <li>3 puntos por acertar el marcador exacto.</li>
                    <li>1 punto por acertar que el partido termina en empate (aunque no sea el marcador exacto).</li>
                    <li>1 punto por acertar al equipo ganador (sin importar el marcador exacto).</li>
                </ul>
                <li><strong>Acumulado:</strong> En cada jornada, de los $50 MXN aportados por cada participante:</li>
                <ul>
                    <li><strong>$40 MXN</strong> se destinan al premio de la jornada.</li>
                    <li><strong>$10 MXN</strong> se reservan para un acumulado global que se distribuirá al final del torneo.</li>
                    <li>Al finalizar todas las jornadas, el acumulado global se premiará entre los tres participantes con mayor puntuación total de la siguiente manera:</li>
                    <ul>
                        <li><strong>Primer Lugar:</strong> Recibirá el <strong>65%</strong> del acumulado global.</li>
                        <li><strong>Segundo Lugar:</strong> Recibirá el <strong>20%</strong> del acumulado global.</li>
                        <li><strong>Tercer Lugar:</strong> Recibirá el <strong>15%</strong> del acumulado global.</li>
                    </ul>
                </ul>

                <li><strong>Importante:</strong> Una vez que hayas ingresado tus predicciones, no podrás editarlas.</li>
            </ul>
            <p class="card-text text-center text-muted">
                ¡Buena suerte y que gane el mejor!
            </p>
        </div>
    </div>

    <!-- Formulario de Predicciones -->
    <form id="uniqueKeyForm" method="GET" action="{{ route('quiniela.form') }}">
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="mb-3">
            <label for="unique_key" class="form-label">Ingresa tu clave única</label>
            <input type="text" class="form-control" id="unique_key" name="unique_key" placeholder="Ej. ABC123" required>
        </div>
        <button type="submit" class="btn btn-primary">Acceder</button>
    </form>

    <form method="POST" action="{{ route('quiniela.submit') }}">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @csrf
        <!-- <div class="mb-3">
            <label for="unique_key" class="form-label">Tu clave única</label>
            <input type="text" class="form-control" id="unique_key" name="unique_key"
                   value="{{ $user->unique_key ?? '' }}" {{ $user ? 'readonly' : '' }} placeholder="Ej. ABC123" required>
        </div> -->
        <!-- Incluye la clave única como campo oculto -->
        <input type="hidden" name="unique_key" value="{{ request('unique_key') }}">

        @foreach (['Quarters', 'Semifinals', 'Final', 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18] as $phase)
            @if (isset($matches[$phase]))
                <h2 class="text-center mt-5">
                    @if ($phase == 'Quarters') Cuartos de Final
                    @elseif ($phase == 'Semifinals') Semifinales
                    @elseif ($phase == 'Final') Final
                    @elseif ($phase == 1 ) Jornada 1
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
                    @elseif ($phase == 18 ) Jornada 18
                    @endif
                </h2>

                <!-- Partidos de Ida -->
                @if(in_array($phase, ['Quarters', 'Semifinals', 'Final']))
                    <h3 class="mt-4">Ida</h3>
                @endif
                <div class="row">
                    @foreach ($matches[$phase]->where('is_first_leg', true) as $match)
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="row">
                                        <div class="col-5">
                                            <img src="{{ $match->team_a_logo }}" alt="{{ $match->team_a }}" class="img-fluid mb-2">
                                            <p>{{ $match->team_a }}</p>
                                            @php
                                                $prediction = $userPredictions[$match->id] ?? null;
                                            @endphp
                                            @if ($prediction)
                                                <p class="text-muted">Pronóstico enviado</p>
                                                <input type="number" class="form-control mb-2" value="{{ $prediction->predicted_score_a }}" disabled>
                                                <p class="text-muted">Resultado: {{ $match->score_a }}</p>
                                            @elseif (!isset($match->score_a) && !isset($match->score_b))
                                                <input type="number" class="form-control" name="predictions[{{ $match->id }}][score_a]" placeholder="Marcador" required>
                                            @else
                                                <p class="text-muted">Predicción cerrada</p>
                                                <p class="text-muted">Resultado: {{ $match->score_a }}</p>
                                            @endif
                                        </div>
                                        <div class="col-2 align-self-center">
                                            <h4>VS</h4>
                                        </div>
                                        <div class="col-5">
                                            <img src="{{ $match->team_b_logo }}" alt="{{ $match->team_b }}" class="img-fluid mb-2">
                                            <p>{{ $match->team_b }}</p>
                                            @if ($prediction)
                                                <p class="text-muted">Pronóstico enviado</p>
                                                <input type="number" class="form-control mb-2" value="{{ $prediction->predicted_score_b }}" disabled>
                                                <p class="text-muted">Resultado: {{ $match->score_b }}</p>
                                            @elseif (!isset($match->score_a) && !isset($match->score_b))
                                                <input type="number" class="form-control" name="predictions[{{ $match->id }}][score_b]" placeholder="Marcador" required>
                                            @else
                                                <p class="text-muted">Predicción cerrada</p>
                                                <p class="text-muted">Resultado: {{ $match->score_b }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if(in_array($phase, ['Quarters', 'Semifinals', 'Final']))
                    <!-- Partidos de Vuelta -->
                    <h3 class="mt-4">Vuelta</h3>
                    <div class="row">
                        @foreach ($matches[$phase]->where('is_first_leg', false) as $match)
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <div class="row">
                                            <div class="col-5">
                                                <img src="{{ $match->team_a_logo }}" alt="{{ $match->team_a }}" class="img-fluid mb-2">
                                                <p>{{ $match->team_a }}</p>
                                                @php
                                                    $prediction = $userPredictions[$match->id] ?? null;
                                                @endphp
                                                @if ($prediction)
                                                    <p class="text-muted">Pronóstico enviado</p>
                                                    <input type="number" class="form-control mb-2" value="{{ $prediction->predicted_score_a }}" disabled>
                                                    <p class="text-muted">Resultado: {{ $match->score_a }}</p>
                                                @elseif (!isset($match->score_a) && !isset($match->score_b))
                                                    <input type="number" class="form-control" name="predictions[{{ $match->id }}][score_a]" placeholder="Marcador" required>
                                                @else
                                                    <p class="text-muted">Predicción cerrada</p>
                                                    <p class="text-muted">Resultado: {{ $match->score_a }}</p>
                                                @endif
                                            </div>
                                            <div class="col-2 align-self-center">
                                                <h4>VS</h4>
                                            </div>
                                            <div class="col-5">
                                                <img src="{{ $match->team_b_logo }}" alt="{{ $match->team_b }}" class="img-fluid mb-2">
                                                <p>{{ $match->team_b }}</p>
                                                @if ($prediction)
                                                    <p class="text-muted">Pronóstico enviado</p>
                                                    <input type="number" class="form-control mb-2" value="{{ $prediction->predicted_score_b }}" disabled>
                                                    <p class="text-muted">Resultado: {{ $match->score_b }}</p>
                                                @elseif (!isset($match->score_a) && !isset($match->score_b))
                                                    <input type="number" class="form-control" name="predictions[{{ $match->id }}][score_b]" placeholder="Marcador" required>
                                                @else
                                                    <p class="text-muted">Predicción cerrada</p>
                                                    <p class="text-muted">Resultado: {{ $match->score_b }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif
        @endforeach

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Enviar Predicciones</button>
        </div>
    </form>

    <!-- Botón para ver el ranking -->
    <div class="text-center mt-3">
        <a href="{{ route('quiniela.ranking') }}" class="btn btn-secondary">Ver Puntuaciones</a>
        <a href="{{ route('quiniela.quinielas-capturadas') }}" class="btn btn-secondary">Ver Quinielas</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html