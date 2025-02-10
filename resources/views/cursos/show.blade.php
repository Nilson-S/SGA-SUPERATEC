@extends('layouts.layout')

@section('title', 'Detalles del Curso')

@section('content')
    <div class="container py-5">
        <div class="card shadow-lg rounded-3">
            <div class="card-header bg-info text-white">
                <h3 class="mb-0"><i class="fas fa-book"></i> Curso: {{ $curso->nombre }}</h3>
            </div>
            <div class="card-body">
                <!-- Información del Curso -->
                <div class="mb-4">
                    <h5 class="text-primary"><i class="fas fa-info-circle"></i> Información del Curso</h5>
                    <p class="mb-1"><strong>Descripción:</strong> {{ $curso->descripcion ?? 'N/A' }}</p>
                    <p><strong>Duración:</strong> {{ $curso->duracion_horas }} horas</p>
                    <p><strong>Fecha de Inicio:</strong> {{ \Carbon\Carbon::parse($curso->fecha_inicio)->format('d/m/Y') }}
                    </p>
                    <p><strong>Fecha de Fin:</strong> {{ \Carbon\Carbon::parse($curso->fecha_fin)->format('d/m/Y') }}</p>
                    <p><strong>Costo:</strong> ${{ number_format($curso->costo, 2) }}</p>
                </div>

                <!--  Horario del Curso -->
                @if ($curso->horarios->count() > 0)
                    <div class="mb-4">
                        <h5 class="text-primary"><i class="fas fa-clock"></i> Horario del Curso</h5>
                        <div class="table-responsive">
                            <table class="table table-hover text-center">
                                <thead class="bg-info text-white">
                                    <tr>
                                        <th>Días</th>
                                        <th>Hora de Inicio</th>
                                        <th>Hora de Fin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($curso->horarios as $horario)
                                        <tr>
                                            <td>
                                                @php
                                                    // Convertir abreviaturas a nombres completos
                                                    $diasMap = [
                                                        'L' => 'Lunes',
                                                        'M' => 'Martes',
                                                        'MI' => 'Miércoles',
                                                        'J' => 'Jueves',
                                                        'V' => 'Viernes',
                                                        'S' => 'Sábado',
                                                    ];
                                                    $diasArray = explode(',', $horario->dias);
                                                    $diasCompletos = array_map(
                                                        fn($d) => $diasMap[$d] ?? $d,
                                                        $diasArray,
                                                    );
                                                    echo implode(', ', $diasCompletos);
                                                @endphp
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('h:i A') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($horario->hora_fin)->format('h:i A') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <p class="text-muted"><i class="fas fa-exclamation-circle"></i> No hay horarios asignados a este curso.
                    </p>
                @endif

                <!-- Aula Asignada -->
                <div class="mb-4">
                    <h5 class="text-primary"><i class="fas fa-school"></i> Aula Asignada</h5>
                    <p><strong>Aula:</strong> {{ $curso->aula->nombre ?? 'No asignada' }}</p>
                </div>

                <!-- Facilitador -->
                <div class="mb-4">
                    <h5 class="text-primary"><i class="fas fa-chalkboard-teacher"></i> Facilitador</h5>
                    <p><strong>Nombre:</strong> {{ $curso->facilitador->nombres }} {{ $curso->facilitador->apellidos }}</p>
                    <p><strong>Especialidad:</strong> {{ $curso->facilitador->especialidad }}</p>
                </div>

                <!-- 🔹 Alumnos Inscritos -->
                <div class="mb-4">
                    <h5 class="text-primary"><i class="fas fa-users"></i> Alumnos Inscritos</h5>

                    <!-- Muestra el total de alumnos inscritos -->
                    <p class="fw-bold text-secondary">
                        <i class="fas fa-user-graduate"></i> Total de alumnos inscritos:
                        <span class="badge bg-primary">{{ $curso->inscripciones->count() }}</span>
                    </p>

                    @if ($curso->inscripciones->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover text-center">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Cédula</th>
                                        <th>Correo</th>
                                        <th>Teléfono</th>
                                        <th>Estado de Pago</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($curso->inscripciones as $index => $inscripcion)
                                        <tr>
                                            <td class="fw-bold">{{ $index + 1 }}</td>
                                            <td>{{ $inscripcion->alumno->nombres }} {{ $inscripcion->alumno->apellidos }}
                                            </td>
                                            <td>{{ $inscripcion->alumno->cedula }}</td>
                                            <td>{{ $inscripcion->alumno->correo ?? 'No registrado' }}</td>
                                            <td>{{ $inscripcion->alumno->telefono ?? 'No registrado' }}</td>
                                            <td>
                                                @if ($inscripcion->monto_pago >= $curso->costo)
                                                    <span class="badge bg-success"><i class="fas fa-check-circle"></i>
                                                        Pagado</span>
                                                @else
                                                    <span class="badge bg-danger"><i class="fas fa-exclamation-circle"></i>
                                                        Pendiente</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted"><i class="fas fa-exclamation-circle"></i> No hay alumnos inscritos en este
                            curso.</p>
                    @endif
                </div>

                <!-- Botón de regreso -->
                <div class="text-end mt-4">
                    <a href="{{ route('cursos.index') }}" class="btn btn-secondary shadow-sm">
                        <i class="fas fa-arrow-left"></i> Volver a Cursos
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
