@extends('layouts.layout')

@section('title', 'Registrar Horario')

@section('content')
    <div class="container py-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white text-center rounded-top">
                <h2 class="mb-0"><i class="fas fa-clock"></i> Registrar Nuevo Horario</h2>
            </div>
            <div class="card-body bg-light p-4">
                <form action="{{ route('horarios.store') }}" method="POST">
                    @csrf

                    <!-- Selección de Curso -->
                    <div class="mb-3">
                        <label for="curso_id" class="form-label"><i class="fas fa-book"></i> Curso</label>
                        <select name="curso_id" id="curso_id" class="form-select shadow-sm" required>
                            <option value="">-- Seleccionar Curso --</option>
                            @foreach ($cursos as $curso)
                                <option value="{{ $curso->id }}" {{ old('curso_id') == $curso->id ? 'selected' : '' }}>
                                    {{ $curso->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Facilitador (Automático) -->
                    <div class="mb-3">
                        <label for="facilitador_nombre" class="form-label"><i class="fas fa-user-tie"></i>
                            Facilitador</label>
                        <input type="text" id="facilitador_nombre" class="form-control shadow-sm" readonly
                            value="{{ old('facilitador_nombre', session('facilitador_nombre')) }}">
                        <input type="hidden" name="facilitador_id" id="facilitador_id"
                            value="{{ old('facilitador_id', session('facilitador_id')) }}">
                    </div>

                    <!-- Aula (Automático) -->
                    <div class="mb-3">
                        <label for="aula_nombre" class="form-label"><i class="fas fa-school"></i> Aula</label>
                        <input type="text" id="aula_nombre" class="form-control shadow-sm" readonly
                            value="{{ old('aula_nombre', session('aula_nombre')) }}">
                        <input type="hidden" name="aula_id" id="aula_id"
                            value="{{ old('aula_id', session('aula_id')) }}">
                    </div>

                    <!-- Selección de Días -->
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-calendar-day"></i> Días</label>
                        <div class="d-flex flex-wrap">
                            @php
                                $diasSeleccionados = old('dias', []);
                            @endphp
                            @foreach (['L' => 'Lunes', 'M' => 'Martes', 'MI' => 'Miércoles', 'J' => 'Jueves', 'V' => 'Viernes', 'S' => 'Sábado'] as $valor => $dia)
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="checkbox" name="dias[]"
                                        value="{{ $valor }}" id="dia{{ $valor }}"
                                        {{ in_array($valor, $diasSeleccionados) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="dia{{ $valor }}">{{ $dia }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Selección de Horarios -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="hora_inicio" class="form-label"><i class="fas fa-clock"></i> Hora Inicio</label>
                            <select name="hora_inicio" id="hora_inicio" class="form-select shadow-sm" required>
                                <option value="">-- Seleccionar Hora --</option>
                                <option value="08:00" {{ old('hora_inicio') == '08:00' ? 'selected' : '' }}>08:00 AM
                                </option>
                                <option value="13:00" {{ old('hora_inicio') == '13:00' ? 'selected' : '' }}>01:00 PM
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="hora_fin" class="form-label"><i class="fas fa-clock"></i> Hora Fin</label>
                            <select name="hora_fin" id="hora_fin" class="form-select shadow-sm" required>
                                <option value="">-- Seleccionar Hora --</option>
                                <option value="12:00" {{ old('hora_fin') == '12:00' ? 'selected' : '' }}>12:00 PM</option>
                                <option value="17:00" {{ old('hora_fin') == '17:00' ? 'selected' : '' }}>05:00 PM</option>
                            </select>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success shadow-sm me-2">
                            <i class="fas fa-save"></i> Registrar Horario
                        </button>
                        <a href="{{ route('horarios.index') }}" class="btn btn-secondary shadow-sm">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if ($errors->has('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <i class="fas fa-exclamation-triangle"></i> {{ $errors->first('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif




    <!-- Script para actualizar facilitador y aula automáticamente -->
    <script>
        document.getElementById('curso_id').addEventListener('change', function() {
            var cursoId = this.value;
            if (cursoId) {
                fetch('/horarios/detalles-curso/' + cursoId)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('facilitador_nombre').value = data.facilitador.nombre;
                        document.getElementById('facilitador_id').value = data.facilitador.id;
                        document.getElementById('aula_nombre').value = data.aula.nombre;
                        document.getElementById('aula_id').value = data.aula.id;
                    })
                    .catch(error => console.error('Error obteniendo datos:', error));
            }
        });

        document.getElementById('hora_inicio').addEventListener('change', function() {
            let horaInicio = this.value;
            let horaFin = document.getElementById('hora_fin');
            horaFin.innerHTML = '';

            if (horaInicio === '08:00') {
                horaFin.innerHTML += '<option value="12:00">12:00 PM</option>';
            } else if (horaInicio === '13:00') {
                horaFin.innerHTML += '<option value="17:00">05:00 PM</option>';
            }
        });
    </script>
@endsection
