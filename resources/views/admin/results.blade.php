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
        <h1 class="text-center">Captura de Resultados</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form method="POST" action="{{ route('admin.results.submit') }}">
            @csrf
<<<<<<< HEAD
	    @foreach (['Quarters', 'Semifinals', 'Final', 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18] as $phase)
                @if (isset($matches[$phase]))
		    <h2 class="text-center mt-5">
=======
            @foreach (['Quarters', 'Semifinals', 'Final', 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18] as $phase)
                @if (isset($matches[$phase]))
                    <h2 class="text-center mt-5">
>>>>>>> d2933f6797b016b248c63e88fe57bcd23cfd941e
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
<<<<<<< HEAD

=======
>>>>>>> d2933f6797b016b248c63e88fe57bcd23cfd941e
                    <div class="row">
                        @foreach ($matches[$phase] as $match)
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-body text-center">
                                        <h4>{{ $match->team_a }} VS {{ $match->team_b }}</h4>
                                        <div class="row mt-3">
                                            <div class="col-5">
                                                <label>{{ $match->team_a }}</label>
                                                <input type="number" class="form-control" name="results[{{ $match->id }}][score_a]" value="{{ $match->score_a ?? '' }}">
                                            </div>
                                            <div class="col-2 text-center align-self-center">VS</div>
                                            <div class="col-5">
                                                <label>{{ $match->team_b }}</label>
                                                <input type="number" class="form-control" name="results[{{ $match->id }}][score_b]" value="{{ $match->score_b ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
            <button type="submit" class="btn btn-success">Guardar Resultados</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html
