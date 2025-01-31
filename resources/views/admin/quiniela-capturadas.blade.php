@extends('layouts.app')
@section('title', 'Quinielas capturadas')
@section('content')
<div class="container my-5">
    <!-- Instrucciones de la Quiniela -->
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title text-center">¡Importante! Cada usuario debe de tener 9 capturas</h2>
        </div>
    </div>

    <!-- Usuarios que ya han capturado -->
    <h3 class="mb-3">Usuarios que ya han capturado pronósticos</h3>
    <table class="table table-bordered table-striped text-center mt-4">
        <thead>
            <tr>
                <th>Id</th>
                <th>Usuario</th>
                <th>Total de Predicciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuariosCompletos as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->total_predicciones }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Usuarios que faltan por capturar -->
    <h3 class="mt-5 mb-3 text-danger">Usuarios que faltan por capturar pronósticos</h3>
    <table class="table table-bordered table-striped text-center mt-4">
        <thead>
            <tr>
                <th>Id</th>
                <th>Usuario</th>
            </tr>
        </thead>
        <tbody>
            @if($usuariosFaltantes->count() > 0)
                @foreach ($usuariosFaltantes as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2">¡Todos los usuarios han capturado sus pronósticos!</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection 