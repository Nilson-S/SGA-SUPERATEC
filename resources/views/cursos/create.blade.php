@extends('layouts.layout')

@section('title', 'Agregar Curso')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3"><i class="fas fa-plus-circle"></i> Registrar Nuevo Curso</h1>
        <a href="{{ route('cursos.index') }}" class="btn btn-secondary shadow">
            <i class="fas fa-arrow-left"></i> Volver a Cursos
        </a>
    </div>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('cursos.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!--  Primera columna -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nombre" class="form-label"><i class="fas fa-book"></i> Nombre del Curso</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ejemplo: Programación en Python" required>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label"><i class="fas fa-align-left"></i> Descripción</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" rows="3" placeholder="Breve descripción del curso..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="costo" class="form-label"><i class="fas fa-dollar-sign"></i> Costo ($)</label>
                            <input type="number" name="costo" id="costo" class="form-control" step="0.01" required>
                        </div>

                        <div class="mb-3">
                            <label for="duracion_horas" class="form-label"><i class="fas fa-clock"></i> Duración (Horas)</label>
                            <input type="number" name="duracion_horas" id="duracion_horas" class="form-control" required>
                        </div>
                    </div>

                    <!--  Segunda columna -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label"><i class="fas fa-calendar-alt"></i> Fecha de Inicio</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="fecha_fin" class="form-label"><i class="fas fa-calendar-check"></i> Fecha de Fin</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="aula_id" class="form-label"><i class="fas fa-school"></i> Aula</label>
                            <select name="aula_id" id="aula_id" class="form-control" required>
                                <option value="" disabled selected>Seleccionar Aula</option>
                                @foreach ($aulas as $aula)
                                    <option value="{{ $aula->id }}">{{ $aula->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="facilitador_id" class="form-label"><i class="fas fa-user-tie"></i> Facilitador</label>
                            <select name="facilitador_id" id="facilitador_id" class="form-control" required>
                                <option value="" disabled selected>Seleccionar Facilitador</option>
                                @foreach ($facilitadores as $facilitador)
                                    <option value="{{ $facilitador->id }}">{{ $facilitador->nombres }} {{ $facilitador->apellidos }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!--  Botones -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg shadow-sm me-2">
                        <i class="fas fa-save"></i> Registrar
                    </button>
                    <a href="{{ route('cursos.index') }}" class="btn btn-secondary btn-lg shadow-sm">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
