@extends('layouts.layout')

@section('content')
    <div class="container py-5">
        <h1 class="text-center mb-4">Sistema de Gestión Académica - SuperaTec</h1>
        <p class="text-center mb-5">
            Bienvenido al Sistema, {{ Auth::user()->name }}. Utiliza los accesos rápidos para gestionar cada módulo.
        </p>

        <div class="row row-cols-1 row-cols-md-4 g-4">
            <!-- Usuarios Administradores -->
            <div class="col">
                <div class="card h-100 text-white bg-danger shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-user-shield fa-3x mb-3"></i>
                        <h5 class="card-title fw-bold">Usuarios Administradores</h5>
                        <a href="{{ route('users.index') }}" class="btn btn-light btn-sm mt-2">Ver</a>
                    </div>
                </div>
            </div>
            <!-- Alumnos -->
            <div class="col">
                <div class="card h-100 text-white bg-primary shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-3x mb-3"></i>
                        <h5 class="card-title fw-bold">Gestión de Alumnos</h5>
                        <a href="{{ route('alumnos.index') }}" class="btn btn-light btn-sm mt-2">Ver</a>
                    </div>
                </div>
            </div>

            <!-- Facilitadores -->
            <div class="col">
                <div class="card h-100 text-white bg-success shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-chalkboard-teacher fa-3x mb-3"></i>
                        <h5 class="card-title fw-bold">Gestión de Facilitadores</h5>
                        <a href="{{ route('facilitadores.index') }}" class="btn btn-light btn-sm mt-2">Ver</a>
                    </div>
                </div>
            </div>

            <!-- Cursos -->
            <div class="col">
                <div class="card h-100 text-white bg-warning shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-book-open fa-3x mb-3"></i>
                        <h5 class="card-title fw-bold">Gestión de Cursos</h5>
                        <a href="{{ route('cursos.index') }}" class="btn btn-light btn-sm mt-2">Ver</a>
                    </div>
                </div>
            </div>

            <!-- Talleres -->
            <div class="col">
                <div class="card h-100 text-white bg-info shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-tools fa-3x mb-3"></i>
                        <h5 class="card-title fw-bold">Gestión de Talleres</h5>
                        <a href="{{ route('talleres.index') }}" class="btn btn-light btn-sm mt-2">Ver</a>
                    </div>
                </div>
            </div>

            <!-- Calificaciones -->
            <div class="col">
                <div class="card h-100 text-white bg-danger shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-graduation-cap fa-3x mb-3"></i>
                        <h5 class="card-title fw-bold">Calificaciones</h5>
                        <a href="{{ route('calificaciones.index') }}" class="btn btn-light btn-sm mt-2">Ver</a>
                    </div>
                </div>
            </div>

            <!-- Inscripciones -->
            <div class="col">
                <div class="card h-100 text-white bg-secondary shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                        <h5 class="card-title fw-bold">Gestión de Inscripciones</h5>
                        <a href="{{ route('inscripciones.index') }}" class="btn btn-light btn-sm mt-2">Ver</a>
                    </div>
                </div>
            </div>

            <!-- Pagos -->
            <div class="col">
                <div class="card h-100 text-white bg-dark shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-money-bill-wave fa-3x mb-3"></i>
                        <h5 class="card-title fw-bold">Gestión de Pagos</h5>
                        <a href="{{ route('pagos.index') }}" class="btn btn-light btn-sm mt-2">Ver</a>
                    </div>
                </div>
            </div>

            <!-- Horarios -->
            <div class="col">
                <div class="card h-100 text-white bg-primary shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-clock fa-3x mb-3"></i>
                        <h5 class="card-title fw-bold">Gestión de Horarios</h5>
                        <a href="{{ route('horarios.index') }}" class="btn btn-light btn-sm mt-2">Ver</a>
                    </div>
                </div>
            </div>

            <!-- Aulas -->
            <div class="col">
                <div class="card h-100 text-white bg-success shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-school fa-3x mb-3"></i>
                        <h5 class="card-title fw-bold">Gestión de Aulas</h5>
                        <a href="{{ route('aulas.index') }}" class="btn btn-light btn-sm mt-2">Ver</a>
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="col">
                <div class="card h-100 text-white bg-success shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-line fa-3x mb-3"></i>
                        <h5 class="card-title fw-bold">Estadísticas</h5>
                        <a href="{{ route('estadisticas.index') }}" class="btn btn-light btn-sm mt-2">Ver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
