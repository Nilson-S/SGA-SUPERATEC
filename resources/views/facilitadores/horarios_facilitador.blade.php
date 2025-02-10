@extends('layouts.layout')

@section('title', 'Horarios del Facilitador')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-info text-white text-center rounded-top">
            <h2 class="mb-0">Horarios de {{ $facilitador->nombres }} {{ $facilitador->apellidos }}</h2>
        </div>
        <div class="card-body bg-light p-4">
            <!-- Verificación si hay horarios -->
            @if ($horarios->isEmpty())
                <div class="alert alert-warning text-center">No hay horarios asignados a este facilitador.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover text-center shadow-sm">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>#</th>
                                <th>Curso</th>
                                <th>Aula</th>
                                <th>Días</th>
                                <th>Hora Inicio</th>
                                <th>Hora Fin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($horarios as $index => $horario)
                                <tr class="{{ $loop->even ? 'table-light' : 'table-secondary' }}">
                                    <td class="fw-bold">{{ $index + 1 }}</td>
                                    <td>{{ $horario->curso->nombre }}</td>
                                    <td>{{ $horario->aula->nombre }}</td>
                                    <td>
                                        {{ implode(', ', array_map(fn($dia) => $dia == 'L' ? 'Lunes' :
                                                                      ($dia == 'M' ? 'Martes' :
                                                                      ($dia == 'MI' ? 'Miércoles' :
                                                                      ($dia == 'J' ? 'Jueves' :
                                                                      ($dia == 'V' ? 'Viernes' :
                                                                      ($dia == 'S' ? 'Sábado' : ''))))), 
                                                                      explode(',', $horario->dias))) }}
                                    </td>
                                    <td>{{ date('h:i A', strtotime($horario->hora_inicio)) }}</td>
                                    <td>{{ date('h:i A', strtotime($horario->hora_fin)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- Botón de regreso -->
            <div class="text-end mt-4">
                <a href="{{ route('facilitadores.index') }}" class="btn btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left"></i> Volver a Facilitadores
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
