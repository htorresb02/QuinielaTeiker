@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Dashboard de Quinielas</h2>

    <!-- Estadísticas Generales -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Usuarios Totales</h5>
                    <p class="card-text display-4">{{ $generalStats['total_users'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Partidos Totales</h5>
                    <p class="card-text display-4">{{ $generalStats['total_matches'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Predicciones Totales</h5>
                    <p class="card-text display-4">{{ $generalStats['total_predictions'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Promedio de Puntos</h5>
                    <p class="card-text display-4">{{ number_format($generalStats['average_points'], 1) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficas -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Puntos por Fase</h5>
                    <canvas id="pointsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Predicciones Perfectas por Fase</h5>
                    <canvas id="perfectPredictionsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Top 5 Usuarios -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Top 5 - Predicciones Perfectas</h5>
                    <ul class="list-group">
                        @foreach($topPerfectPredictions as $user)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $user['name'] }}
                                <span class="badge bg-primary rounded-pill">{{ $user['perfect_predictions'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfica de Puntos por Fase
    new Chart(document.getElementById('pointsChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['phases']) !!},
            datasets: [{
                label: 'Puntos Totales',
                data: {!! json_encode(array_values($chartData['pointsPerPhase'])) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Gráfica de Predicciones Perfectas por Fase
    new Chart(document.getElementById('perfectPredictionsChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData['phases']) !!},
            datasets: [{
                label: 'Predicciones Perfectas',
                data: {!! json_encode(array_values($chartData['perfectPredictionsPerPhase'])) !!},
                fill: false,
                borderColor: 'rgba(255, 99, 132, 1)',
                tension: 0.1
            }]
        }
    });
});
</script>
@endpush
@endsection 