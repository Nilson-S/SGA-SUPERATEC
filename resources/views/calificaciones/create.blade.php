@extends('layouts.layout')

@section('title', 'Agregar Calificación')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-success text-white text-center rounded-top">
            <h2 class="mb-0"><i class="fas fa-plus-circle"></i> Registrar Nueva Calificación</h2>
        </div>
        <div class="card-body bg-light p-4">
            <form action="{{ route('calificaciones.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!--  Alumno -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="alumno_id" class="form-label"><i class="fas fa-user-graduate"></i> Alumno</label>
                            <select name="alumno_id" id="alumno_id" class="form-select shadow-sm" required>
                                <option value="" selected disabled>Selecciona un alumno</option>
                                @foreach($alumnos as $alumno)
                                    <option value="{{ $alumno->id }}">{{ $alumno->nombres }} {{ $alumno->apellidos }} C.I. {{ $alumno->cedula }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!--  Curso (Se actualizará con AJAX) -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="curso_id" class="form-label"><i class="fas fa-book"></i> Curso</label>
                            <select name="curso_id" id="curso_id" class="form-select shadow-sm" required>
                                <option value="" selected disabled>Selecciona un curso</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!--  Calificación -->
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <div class="mb-3">
                            <label for="calificacion" class="form-label"><i class="fas fa-star"></i> Calificación</label>
                            <input type="number" name="calificacion" id="calificacion" class="form-control shadow-sm text-center" 
                                required min="0" max="20" step="0.1" placeholder="Ingrese la calificación">
                        </div>
                    </div>
                </div>

                <!--  Botones de acción -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg shadow-sm me-2">
                        <i class="fas fa-save"></i> Registrar
                    </button>
                    <a href="{{ route('calificaciones.index') }}" class="btn btn-secondary btn-lg shadow-sm">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!--  Script para actualizar los cursos con AJAX -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('alumno_id').addEventListener('change', function () {
            let alumnoId = this.value;
            let cursoSelect = document.getElementById('curso_id');

            // Limpiar opciones anteriores
            cursoSelect.innerHTML = '<option value="" selected disabled>Cargando cursos...</option>';

            // Verificar si hay un alumno seleccionado
            if (alumnoId) {
                fetch(`/calificaciones/cursos/${alumnoId}`)
                    .then(response => response.json())
                    .then(data => {
                        cursoSelect.innerHTML = '<option value="" selected disabled>Selecciona un curso</option>';
                        data.forEach(curso => {
                            let option = document.createElement('option');
                            option.value = curso.id;
                            option.textContent = curso.nombre;
                            cursoSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error al cargar cursos:', error));
            } else {
                cursoSelect.innerHTML = '<option value="" selected disabled>Selecciona un curso</option>';
            }
        });
    });
</script>
@endsection
