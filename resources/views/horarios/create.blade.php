@extends('layouts.layout')

@section('content')
<div class="container">
    <h1>Registrar Nuevo Horario</h1>
    <form action="{{ route('horarios.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="curso_id" class="form-label">Curso (Opcional)</label>
            <select name="curso_id" id="curso_id" class="form-control">
                <option value="">Seleccionar</option>
                @foreach ($cursos as $curso)
                <option value="{{ $curso->id }}">{{ $curso->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="taller_id" class="form-label">Taller (Opcional)</label>
            <select name="taller_id" id="taller_id" class="form-control">
                <option value="">Seleccionar</option>
                @foreach ($talleres as $taller)
                <option value="{{ $taller->id }}">{{ $taller->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="facilitador_id" class="form-label">Facilitador</label>
            <select name="facilitador_id" id="facilitador_id" class="form-control" required>
                <option value="">Seleccionar</option>
                @foreach ($facilitadores as $facilitador)
                <option value="{{ $facilitador->id }}">{{ $facilitador->nombres }} {{ $facilitador->apellidos }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="aula_id" class="form-label">Aula</label>
            <select name="aula_id" id="aula_id" class="form-control" required>
                @foreach ($aulas as $aula)
                <option value="{{ $aula->id }}">{{ $aula->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="hora_inicio" class="form-label">Hora de Inicio</label>
            <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="hora_fin" class="form-label">Hora de Fin</label>
            <input type="time" name="hora_fin" id="hora_fin" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Registrar</button>
        <a href="{{ route('horarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
