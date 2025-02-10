@extends('layouts.layout')

@section('title', 'Detalles del Aula')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg rounded-3">
        <div class="card-header bg-info text-white">
            <h3 class="mb-0"><i class="fas fa-school"></i> Aula: {{ $aula->nombre }}</h3>
        </div>
        <div class="card-body">
            <!-- Información del Aula -->
            <div class="mb-4">
                <h5 class="text-primary"><i class="fas fa-info-circle"></i> Información del Aula</h5>
                <p class="mb-1"><strong>Nombre:</strong> {{ $aula->nombre }}</p>
                <p><strong>Descripción:</strong> {{ $aula->descripcion ?? 'N/A' }}</p>
            </div>

            <!-- Cursos en el Aula -->
            <h5 class="text-primary"><i class="fas fa-book"></i> Cursos en esta Aula</h5>
            @if($aula->cursos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mt-3 shadow-sm text-center">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>#</th>
                                <th>Nombre del Curso</th>
                                <th>Fecha de Inicio</th>
                                <th>Fecha de Fin</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aula->cursos as $index => $curso)
                                <tr class="{{ $loop->even ? 'table-light' : 'table-secondary' }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $curso->nombre }}</td>
                                    <td>{{ \Carbon\Carbon::parse($curso->fecha_inicio)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($curso->fecha_fin)->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye"></i> Ver Curso
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mt-3"><i class="fas fa-exclamation-circle"></i> No hay cursos asignados a esta aula.</p>
            @endif

            <!-- Botón de regreso -->
            <div class="text-end mt-4">
                <a href="{{ route('aulas.index') }}" class="btn btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left"></i> Volver a Aulas
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
