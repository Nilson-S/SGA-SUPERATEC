@extends('layouts.layout')

@section('title', 'Agregar Calificación')

@section('content')
<h1 class="h3">Registrar Nueva Calificación</h1>

<form action="{{ route('calificaciones.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="alumno_id" class="form-label">Alumno</label>
        <select name="alumno_id" id="alumno_id" class="form-control" required>
            <option value="">Selecciona un alumno</option>
            @foreach($alumnos as $alumno)
            <option value="{{ $alumno->id }}">{{ $alumno->nombres }} {{ $alumno->apellidos }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="curso_id" class="form-label">Curso</label>
        <select name="curso_id" id="curso_id" class="form-control" required>
            <option value="">Selecciona un curso</option>
            @foreach($cursos as $curso)
            <option value="{{ $curso->id }}">{{ $curso->nombre }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="nota" class="form-label">Nota</label>
        <input type="number" name="nota" id="nota" class="form-control" required min="0" max="20">
    </div>

    <button type="submit" class="btn btn-success">Registrar</button>
    <a href="{{ route('calificaciones.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
