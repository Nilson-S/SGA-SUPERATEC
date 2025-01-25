@extends('layouts.layout')

@section('title', 'Inscripciones')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Inscripciones</h1>
    <a href="{{ route('inscripciones.create') }}" class="btn btn-primary">+ Nueva Inscripción</a>
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
            <th>Fecha de Inscripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($inscripciones as $inscripcion)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $inscripcion->alumno->nombres }} {{ $inscripcion->alumno->apellidos }}</td>
            <td>{{ $inscripcion->curso->nombre }}</td>
            <td>{{ $inscripcion->fecha_inscripcion }}</td>
            <td>
                <form action="{{ route('inscripciones.destroy', $inscripcion) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta inscripción?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
