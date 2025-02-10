@extends('layouts.layout')

@section('title', 'Estadísticas')

@section('content')
    <div class="container py-4">
        <h1 class="text-center mb-5"><i class="fas fa-chart-bar"></i> Estadísticas del Sistema</h1>



        
           <!-- Estadísticas en Tiempo Real -->
           <div class="row g-3 mb-4">
            @foreach ([
                ['title' => 'Total Inscripciones', 'value' => $totalInscripciones, 'bg' => 'bg-primary'],
                ['title' => 'Inscripciones Hoy', 'value' => $inscripcionesHoy, 'bg' => 'bg-success'],
                ['title' => 'Total Alumnos', 'value' => $totalAlumnos, 'bg' => 'bg-info'],
                ['title' => 'Total de Ingresos', 'value' => '$' . number_format($totalIngresos, 2), 'bg' => 'bg-danger']
            ] as $stat)
                <div class="col-md-3">
                    <div class="card {{ $stat['bg'] }} text-white shadow-sm h-100">
                        <div class="card-body text-center">
                            <h6 class="mb-2">{{ $stat['title'] }}</h6>
                            <h3 class="fw-bold">{{ $stat['value'] }}</h3>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Gráficos -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">Inscripciones por Curso</div>
                    <div class="card-body">
                        <canvas id="inscripcionesPorCurso"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">Inscripciones por Mes (Últimos 12 Meses)</div>
                    <div class="card-body">
                        <canvas id="inscripcionesPorMes"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">Distribución de Alumnos por Género</div>
                    <div class="card-body">
                        <canvas id="distribucionGenero"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-white">Rendimiento de Calificaciones</div>
                    <div class="card-body">
                        <canvas id="calificacionesPorCurso"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4 shadow-sm">
            <div class="card-header bg-secondary text-white">Ingresos por Curso</div>
            <div class="card-body">
                <canvas id="ingresosPorCurso"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Inscripciones por Curso
        const inscripcionesPorCurso = new Chart(document.getElementById('inscripcionesPorCurso'), {
            type: 'bar',
            data: {
                labels: @json($inscripcionesPorCurso->pluck('curso.nombre')),
                datasets: [{
                    label: 'Total Inscripciones',
                    data: @json($inscripcionesPorCurso->pluck('total')),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Inscripciones por Mes
        const inscripcionesPorMes = new Chart(document.getElementById('inscripcionesPorMes'), {
            type: 'line',
            data: {
                labels: @json($inscripcionesPorMes->pluck('mes')),
                datasets: [{
                    label: 'Inscripciones',
                    data: @json($inscripcionesPorMes->pluck('total')),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Distribución de Alumnos por Género
        const distribucionGenero = new Chart(document.getElementById('distribucionGenero'), {
            type: 'doughnut',
            data: {
                labels: @json($distribucionGenero->keys()),
                datasets: [{
                    data: @json($distribucionGenero->values()),
                    backgroundColor: ['#36A2EB', '#FF6384'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Gráfico de Ingresos por Curso
        new Chart(document.getElementById('ingresosPorCurso'), {
            type: 'bar',
            data: {
                labels: @json($ingresosPorCurso->pluck('curso.nombre')),
                datasets: [{
                    label: 'Ingresos Totales ($)',
                    data: @json($ingresosPorCurso->pluck('total_ingresos')),
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Rendimiento de Calificaciones: Aprobados vs Reprobados por Curso
        const calificacionesPorCurso = new Chart(document.getElementById('calificacionesPorCurso'), {
            type: 'bar',
            data: {
                labels: @json($calificacionesPorCurso->pluck('curso.nombre')),
                datasets: [{
                        label: 'Aprobados',
                        data: @json($calificacionesPorCurso->pluck('aprobados')),
                        backgroundColor: 'rgba(75, 192, 192, 0.6)'
                    },
                    {
                        label: 'Reprobados',
                        data: @json($calificacionesPorCurso->pluck('reprobados')),
                        backgroundColor: 'rgba(255, 99, 132, 0.6)'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true
                    }
                }
            }
        });
    </script>
@endsection
