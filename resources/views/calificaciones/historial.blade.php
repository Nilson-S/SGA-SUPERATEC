@extends('layouts.layout')

@section('title', 'Historial de Calificaciones')

@section('content')
    <div class="container py-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white text-center rounded-top">
                <h2 class="mb-0"><i class="fas fa-file-alt"></i> Historial de Calificaciones</h2>
            </div>
            <div class="card-body bg-light p-4">
                <!-- Datos del Alumno -->
                <div class="mb-4 text-center">
                    <h5 class="text-dark"><i class="fas fa-user-graduate"></i> Alumno:
                        <span class="fw-bold">{{ $alumno->nombres }} {{ $alumno->apellidos }}</span>
                    </h5>
                    <p class="text-muted"><i class="fas fa-id-card"></i> Cédula: {{ $alumno->cedula }}</p>
                </div>

                <!-- Tabla de Calificaciones -->
                <div class="table-responsive">
                    <table class="table table-hover text-center shadow-sm">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>#</th>
                                <th>Curso</th>
                                <th>Calificación</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($calificaciones as $index => $calificacion)
                                <tr class="{{ $loop->even ? 'table-light' : 'table-secondary' }}">
                                    <td class="fw-bold">{{ $calificaciones->firstItem() + $index }}</td>
                                    <td><i class="fas fa-book"></i> {{ $calificacion->curso->nombre }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $calificacion->calificacion >= 10 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $calificacion->calificacion }}
                                        </span>
                                    </td>
                                    <td>{{ $calificacion->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        <i class="fas fa-exclamation-circle"></i> No hay calificaciones registradas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $calificaciones->links('pagination::bootstrap-5') }}
                </div>

                <!-- Botones de regreso -->
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <a href="{{ route('calificaciones.index') }}" class="btn btn-secondary btn-lg shadow-sm">
                        <i class="fas fa-arrow-left"></i> Ir a Calificaciones
                    </a>
                    <a href="{{ route('alumnos.index') }}" class="btn btn-primary btn-lg shadow-sm">
                        <i class="fas fa-user-graduate"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
