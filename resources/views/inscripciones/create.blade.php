@extends('layouts.layout')

@section('title', 'Nueva Inscripción')

@section('content')
<h1 class="h3">Registrar Nueva Inscripción</h1>

<form action="{{ route('inscripciones.store') }}" method="POST">
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
        <label for="fecha_inscripcion" class="form-label">Fecha de Inscripción</label>
        <input type="date" name="fecha_inscripcion" id="fecha_inscripcion" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Registrar</button>
    <a href="{{ route('inscripciones.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
