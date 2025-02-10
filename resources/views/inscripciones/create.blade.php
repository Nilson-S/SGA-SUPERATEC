@extends('layouts.layout')

@section('title', 'Nueva Inscripción')

@section('content')
    <div class="container py-5">
        <h1 class="h3 text-center mb-4">Registrar Nueva Inscripción</h1>
        <form action="{{ route('inscripciones.store') }}" method="POST" class="shadow p-4 rounded bg-light">
            @csrf
            <div class="row">
                <!-- Primera columna -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="alumno_id" class="form-label"><i class="fas fa-user"></i> Alumno</label>
                        <select name="alumno_id" id="alumno_id" class="form-control" required>
                            <option value="">Selecciona un alumno</option>
                            @foreach ($alumnos as $alumno)
                                <option value="{{ $alumno->id }}">{{ $alumno->nombres }} {{ $alumno->apellidos }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="curso_id" class="form-label"><i class="fas fa-book"></i> Curso</label>
                        <select name="curso_id" id="curso_id" class="form-control" required>
                            <option value="">Selecciona un curso</option>
                            @foreach ($cursos as $curso)
                                <option value="{{ $curso->id }}">{{ $curso->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

        

                    <div class="mb-3">
                        <label for="fecha_inscripcion" class="form-label"><i class="fas fa-calendar"></i> Fecha de
                            Inscripción</label>
                        <input type="date" name="fecha_inscripcion" id="fecha_inscripcion" class="form-control" required>
                    </div>
                </div>

                <!-- Segunda columna (Pago) -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="monto_pago" class="form-label"><i class="fas fa-dollar-sign"></i> Monto de Pago
                            ($)</label>
                        <input type="number" name="monto_pago" id="monto_pago" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="metodo_pago" class="form-label"><i class="fas fa-credit-card"></i> Método de
                            Pago</label>
                        <select name="metodo_pago" id="metodo_pago" class="form-control">
                            <option value="">Selecciona un método de pago</option>
                            <option value="Transferencia Bancaria">Transferencia Bancaria</option>
                            <option value="Efectivo Bs">Efectivo Bs</option>
                            <option value="Efectivo USD">Efectivo USD</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_pago" class="form-label"><i class="fas fa-calendar-check"></i> Fecha de
                            Pago</label>
                        <input type="date" name="fecha_pago" id="fecha_pago" class="form-control">
                    </div>
                </div>
            </div>

            <!--  Sección de Horarios (Se Actualiza Automáticamente) -->
            <div id="horario-section" class="mb-4 d-none">
                <h5 class="text-info"><i class="fas fa-clock"></i> Horarios Disponibles</h5>
                <div class="table-responsive">
                    <table class="table table-hover text-center shadow-sm">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>Días</th>
                                <th>Hora Inicio</th>
                                <th>Hora Fin</th>
                                <th>Aula</th>
                            </tr>
                        </thead>
                        <tbody id="horario-table-body">
                            <!-- Horarios se cargarán dinámicamente aquí -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Botones -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success btn-lg shadow-sm me-2">
                    <i class="fas fa-save"></i> Registrar
                </button>
                <a href="{{ route('inscripciones.index') }}" class="btn btn-secondary btn-lg shadow-sm">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>

    <!-- Script para obtener horarios al seleccionar un curso -->
    <script>
        document.getElementById('curso_id').addEventListener('change', function() {
            let cursoId = this.value;
            let horarioSection = document.getElementById('horario-section');
            let horarioTableBody = document.getElementById('horario-table-body');

            if (cursoId) {
                fetch(`/inscripciones/horarios-curso/${cursoId}`)
                    .then(response => response.json())
                    .then(data => {
                        horarioTableBody.innerHTML = '';

                        if (data.length > 0) {
                            horarioSection.classList.remove('d-none');
                            data.forEach(horario => {
                                let row = `<tr>
                                        <td>${horario.dias}</td>
                                        <td>${horario.hora_inicio}</td>
                                        <td>${horario.hora_fin}</td>
                                        <td>${horario.aula}</td>
                                    </tr>`;
                                horarioTableBody.innerHTML += row;
                            });
                        } else {
                            horarioSection.classList.add('d-none');
                        }
                    })
                    .catch(error => console.error('Error obteniendo los horarios:', error));
            } else {
                horarioSection.classList.add('d-none');
            }
        });
    </script>
@endsection
