<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Gestión Académica')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background: linear-gradient(120deg, rgba(85, 133, 175, 0.021), rgba(147, 221, 224, 0.158), rgba(95, 243, 144, 0.7));
            background-size: 300% 300%;
            animation: gradientBG 8s ease infinite;
            font-family: 'Arial', sans-serif;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .sidebar {
            background-color: rgba(0, 0, 0, 0.9);
            color: #fff;
            height: 100vh;
            position: fixed;
            width: 250px;
            padding-top: 20px;
        }

        .sidebar .nav-link {
            color: #ffffff !important;
            padding: 10px 15px;
        }

        .sidebar .nav-link:hover {
            color: #ffcc00 !important;
        }

        .sidebar .dropdown-menu {
            background-color: rgba(0, 0, 0, 0.9);
            border: none;
        }

        .sidebar .dropdown-menu .dropdown-item {
            color: #ffffff !important;
        }

        .sidebar .dropdown-menu .dropdown-item:hover {
            background-color: #ffcc00 !important;
            color: #000 !important;
        }

        .container-content {
            margin-left: 250px;
            padding: 20px;
        }

        .container-content .container {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .dropdown-toggle::after {
            color: #ffffff;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Corregimos el enlace para redirigir al Dashboard -->
        <h3 class="text-center mb-4">
            <a href="{{ route('dashboard') }}" class="text-white text-decoration-none">SuperaTec</a>
        </h3>
        <ul class="nav flex-column">
            <!-- Menú desplegable de Personal -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="personalDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-users"></i> Personal
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('users.index') }}">Administradores</a></li>
                    <li><a class="dropdown-item" href="{{ route('facilitadores.index') }}">Facilitadores</a></li>
                    <li><a class="dropdown-item" href="{{ route('alumnos.index') }}">Alumnos</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cursos.index') }}"><i class="fas fa-book"></i> Cursos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('inscripciones.index') }}"><i class="fas fa-clipboard"></i> Inscripciones</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('pagos.index') }}"><i class="fas fa-money-bill"></i> Pagos</a>
            </li>
            @if (Auth::check())
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link text-white p-0 m-0"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</button>
                </form>
            </li>
            @endif
        </ul>
    </div>

    <!-- Contenido principal -->
    <div class="container-content">
        <div class="container mt-4">
            @yield('content')
        </div>
    </div>
</body>

</html>
