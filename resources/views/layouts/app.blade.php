<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quinielas - @yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="icon" type="image/x-icon" href="{{ asset('logo-liga_mx.png') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            /* Agregamos padding-top para compensar la altura del navbar fijo */
            padding-top: 4.5rem;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('quiniela.welcome') }}">Quinielas</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('quiniela.welcome') ? 'active' : '' }}" 
                           href="{{ route('quiniela.welcome') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('quiniela/ranking') ? 'active' : '' }}" 
                           href="/quiniela/ranking">Puntuaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('quiniela/quinielas-capturadas') ? 'active' : '' }}" 
                           href="/quiniela/quinielas-capturadas">Quinielas</a>
                    </li>
                    @if(Auth::id() == 1)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->is('admin/*') ? 'active' : '' }}" 
                               href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Administración
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                                <li>
                                    <a class="dropdown-item {{ request()->is('admin/results') ? 'active' : '' }}" 
                                       href="/admin/results">Resultados</a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->is('admin/admin/ver-quinielas') ? 'active' : '' }}" 
                                       href="/admin/ver-quinielas">Ver Quinielas capturadas</a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->is('admin/activar-quinielas') ? 'active' : '' }}" 
                                       href="/admin/activar-quinielas">Activar Quinielas</a>
                                </li><li>
                                    <li><a class="dropdown-item" href="{{ route('admin.matches') }}">Gestionar Partidos</a></li>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 