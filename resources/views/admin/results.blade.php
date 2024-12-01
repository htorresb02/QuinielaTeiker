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
            @foreach (['Quarters', 'Semifinals', 'Final'] as $phase)
                @if (isset($matches[$phase]))
                    <h2 class="text-center mt-5">{{ $phase }}</h2>
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