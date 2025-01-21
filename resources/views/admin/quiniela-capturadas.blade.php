@extends('layouts.app')
@section('title', 'Quinielas capturadas')
@section('content')
<div class="container my-5">
    <!-- Instrucciones de la Quiniela -->
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title text-center">¡Importante! Cada usuario debe de tener 9 capturas</h2>
            <p class="card-text">
                
            </p>
        </div>
    </div>
    <table class="table table-bordered table-striped text-center mt-4">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Usuario</th>
                    <th>Total de Predicciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($result as $index => $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->total_predicciones }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection 