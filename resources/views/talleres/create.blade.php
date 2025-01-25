@extends('layouts.layout')

@section('title', 'Agregar Taller')

@section('content')
<h1 class="h3">Registrar Nuevo Taller</h1>

<form action="{{ route('talleres.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label for="costo" class="form-label">Costo ($)</label>
        <input type="number" name="costo" id="costo" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="duracion_horas" class="form-label">Duración (Horas)</label>
        <input type="number" name="duracion_horas" id="duracion_horas" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="fecha_fin" class="form-label">Fecha de Fin</label>
        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="aula_id" class="form-label">Aula</label>
        <select name="aula_id" id="aula_id" class="form-control" required>
            <option value="">Seleccionar Aula</option>
            @foreach($aulas as $aula)
            <option value="{{ $aula->id }}">{{ $aula->nombre }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-success">Registrar</button>
    <a href="{{ route('talleres.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
