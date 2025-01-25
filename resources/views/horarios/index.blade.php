@extends('layouts.layout')

@section('content')
<div class="container">
    <h1>Gestión de Horarios</h1>
    <a href="{{ route('horarios.create') }}" class="btn btn-primary mb-3">+ Agregar Horario</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Curso/Taller</th>
                <th>Facilitador</th>
                <th>Aula</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($horarios as $horario)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $horario->curso->nombre ?? $horario->taller->nombre ?? 'N/A' }}</td>
                <td>{{ $horario->facilitador->nombres }} {{ $horario->facilitador->apellidos }}</td>
                <td>{{ $horario->aula->nombre }}</td>
                <td>{{ $horario->hora_inicio }}</td>
                <td>{{ $horario->hora_fin }}</td>
                <td>
                    <form action="{{ route('horarios.destroy', $horario) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este horario?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
