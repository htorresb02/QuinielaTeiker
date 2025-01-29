<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
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
            transition: background-color 0.3s ease;
        }

        /* Estilos para el switch de modo oscuro */
        .theme-switch-wrapper {
            display: flex;
            align-items: center;
            margin-left: 1rem;
        }

        .theme-switch {
            display: inline-block;
            position: relative;
            width: 60px;
            height: 34px;
        }

        .theme-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
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
                <div class="theme-switch-wrapper ms-auto">
                    <span class="text-light me-2">
                        <i class="fas fa-sun"></i>
                    </span>
                    <label class="theme-switch">
                        <input type="checkbox" id="themeSwitch">
                        <span class="slider"></span>
                    </label>
                    <span class="text-light ms-2">
                        <i class="fas fa-moon"></i>
                    </span>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Función para manejar el cambio de tema
        document.addEventListener('DOMContentLoaded', function() {
            const themeSwitch = document.getElementById('themeSwitch');
            
            // Verificar si hay una preferencia guardada
            const currentTheme = localStorage.getItem('theme');
            if (currentTheme) {
                document.documentElement.setAttribute('data-bs-theme', currentTheme);
                themeSwitch.checked = currentTheme === 'dark';
            }

            // Manejar el cambio de tema
            themeSwitch.addEventListener('change', function() {
                if (this.checked) {
                    document.documentElement.setAttribute('data-bs-theme', 'dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.documentElement.setAttribute('data-bs-theme', 'light');
                    localStorage.setItem('theme', 'light');
                }
            });
        });
    </script>
</body>
</html> 