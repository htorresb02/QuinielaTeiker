@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Crear Nuevos Partidos</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.matches.create') }}">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="phase">Fase</label>
                            <select name="phase" class="form-control" required>
                                @foreach($phases as $phase)
                                    <option value="{{ $phase }}">{{ $phase }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="team_a">Equipo Local</label>
                                    <select name="team_a" id="team_a" class="form-control" required data-live-search="true">
                                        <option value="">Seleccionar equipo</option>
                                        @foreach($teams as $team)
                                            <option value="{{ $team->club }}" data-logo="{{ $team->logo }}">
                                                {{ $team->club }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="team_a_logo" id="team_a_logo">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="team_b">Equipo Visitante</label>
                                    <select name="team_b" id="team_b" class="form-control" required data-live-search="true">
                                        <option value="">Seleccionar equipo</option>
                                        @foreach($teams as $team)
                                            <option value="{{ $team->club }}" data-logo="{{ $team->logo }}">
                                                {{ $team->club }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="team_b_logo" id="team_b_logo">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Crear Partidos</button>
                    </form>

                    <hr>

                    <h4 class="mt-4">Partidos Actuales</h4>
                    @foreach($matches as $phase => $phaseMatches)
                        <div class="card mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Jornada {{ $phase }}</h5>
                                <div>
                                    <form action="{{ route('admin.matches.activate') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="phase" value="{{ $phase }}">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            Activar Jornada
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.matches.deactivate') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="phase" value="{{ $phase }}">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Desactivar Jornada
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Local</th>
                                                <th>Visitante</th>
                                                <th>Ida/Vuelta</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($phaseMatches as $match)
                                                <tr>
                                                    <td>{{ $match->team_a }}</td>
                                                    <td>{{ $match->team_b }}</td>
                                                    <td>{{ $match->is_first_leg ? 'Ida' : 'Vuelta' }}</td>
                                                    <td>
                                                        @if($match->activo)
                                                            <span class="badge bg-success">Activo</span>
                                                        @else
                                                            <span class="badge bg-danger">Inactivo</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const teamASelect = document.getElementById('team_a');
        const teamBSelect = document.getElementById('team_b');
        const teamALogoInput = document.getElementById('team_a_logo');
        const teamBLogoInput = document.getElementById('team_b_logo');
        
        teamASelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            teamALogoInput.value = selectedOption.dataset.logo;
        });

        teamBSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            teamBLogoInput.value = selectedOption.dataset.logo;
        });
});
</script>

@endsection 