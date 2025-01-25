@extends('layouts.layout')

@section('title', 'Calificaciones')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Calificaciones</h1>
    <a href="{{ route('calificaciones.create') }}" class="btn btn-primary">+ Agregar Calificación</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Alumno</th>
            <th>Curso</th>
            <th>Nota</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($calificaciones as $calificacion)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $calificacion->alumno->nombres }} {{ $calificacion->alumno->apellidos }}</td>
            <td>{{ $calificacion->curso->nombre }}</td>
            <td>{{ $calificacion->nota }}</td>
            <td>
                <a href="{{ route('calificaciones.edit', $calificacion) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('calificaciones.destroy', $calificacion) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta calificación?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
