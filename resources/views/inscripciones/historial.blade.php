@extends('layouts.layout')

@section('title', 'Historial de Inscripciones')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3"><i class="fas fa-history"></i> Historial de Inscripciones</h1>
            <a href="{{ route('inscripciones.index') }}" class="btn btn-secondary shadow">
                <i class="fas fa-arrow-left"></i> Volver a Inscripciones
            </a>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="fas fa-user"></i> Historial de {{ $alumno->nombres }} {{ $alumno->apellidos }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover text-center align-middle">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th>#</th>
                                <th>Curso</th>
                                <th>Facilitador</th>
                                <th>Fecha de Inicio</th>
                                <th>Fecha de Fin</th>
                                <th>Monto Pagado</th>
                                <th>Método de Pago</th>
                                <th>Estado de Pago</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($inscripciones as $index => $inscripcion)
                                <tr>
                                    <td class="fw-bold">{{ $index + 1 }}</td>
                                    <td>{{ $inscripcion->curso->nombre }}</td>
                                    <td>{{ $inscripcion->curso->facilitador->nombres }} {{ $inscripcion->curso->facilitador->apellidos }}</td>
                                    <td>{{ \Carbon\Carbon::parse($inscripcion->curso->fecha_inicio)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($inscripcion->curso->fecha_fin)->format('d/m/Y') }}</td>
                                    <td>${{ number_format($inscripcion->monto_pago ?? 0, 2) }}</td>
                                    <td>{{ $inscripcion->metodo_pago ?? 'No registrado' }}</td>
                                    <td>
                                        @if ($inscripcion->monto_pago >= $inscripcion->curso->costo)
                                            <span class="badge bg-success"><i class="fas fa-check-circle"></i> Pagado</span>
                                        @else
                                            <span class="badge bg-danger"><i class="fas fa-exclamation-circle"></i> Pendiente</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-muted"><i class="fas fa-exclamation-circle"></i> No hay inscripciones registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
