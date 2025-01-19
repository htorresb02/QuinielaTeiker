@extends('layouts.app')

@section('title', 'Resultados Capturados')

@section('content')

<style>
    .team-logo {
        width: 40px;
        height: 40px;
        object-fit: contain;
        border-radius: 50%;
    }
</style>

<div class="container my-5">
    {{-- <div class="text-left mt-3">
        <a href="{{ route('quiniela.form') }}" class="btn btn-secondary"><- Regresar</a>
    </div> --}}
    <h1 class="text-center">Resultados Capturados</h1>
    
    <div class="row">
        @foreach ($matches as $match)
            @if($match->activo == 1)
	     <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Título del partido con imágenes -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ $match->team_a_logo }}" alt="{{ $match->team_a }}" class="team-logo me-2">
                                <span>{{ $match->team_a }}</span>
                            </div>
                            <span class="text-muted">VS</span>
                            <div class="d-flex align-items-center">
                                <span>{{ $match->team_b }}</span>
                                <img src="{{ $match->team_b_logo }}" alt="{{ $match->team_b }}" class="team-logo ms-2">
                            </div>
                        </div>
                        
                        <p class="text-center text-muted mt-3">
                            Resultado oficial: {{ $match->score_a ?? '-' }} - {{ $match->score_b ?? '-' }}
                        </p>

                        <!-- Pronósticos de los usuarios -->
                        <h5>Pronósticos de los usuarios:</h5>
                        @if ($match->predictions->isEmpty())
                            <p class="text-muted">No hay pronósticos capturados.</p>
                        @else
                            <ul class="list-group">
                                @foreach ($match->predictions as $prediction)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ $prediction->user->name ?? 'Usuario desconocido' }}</span>
                                        <span>{{ $prediction->predicted_score_a }} - {{ $prediction->predicted_score_b }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
	   @endif
        @endforeach
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection 
