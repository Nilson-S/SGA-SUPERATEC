@extends('layouts.layout')

@section('title', 'Gestión de Horarios')

@section('content')
    <div class="container py-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white text-center rounded-top">
                <h2 class="mb-0">Gestión de Horarios</h2>
            </div>
            <div class="card-body bg-light p-4">
                <!-- Botón para agregar nuevo horario -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-secondary">Lista de Horarios</h5>
                    <a href="{{ route('horarios.create') }}" class="btn btn-success shadow-sm">
                        <i class="fas fa-plus"></i> Agregar Horario
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
                @endif

                @if ($errors->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $errors->first('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- 🔹 FILTRO AVANZADO -->
                <div class="mb-4 p-3 bg-white rounded shadow-sm border">
                    <h5 class="mb-3 text-info"><i class="fas fa-filter"></i> Filtrar Horarios</h5>
                    <form action="{{ route('horarios.index') }}" method="GET" class="row g-2 align-items-center">

                        <!-- 🔹 Filtrar por Curso -->
                        <div class="col-md-3">

                            <select name="curso_id" class="form-select">
                                <option value="">-- Todos los Cursos --</option>
                                @foreach ($cursos as $curso)
                                    <option value="{{ $curso->id }}"
                                        {{ request('curso_id') == $curso->id ? 'selected' : '' }}>
                                        {{ $curso->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 🔹 Filtrar por Facilitador -->
                        <div class="col-md-3">
                            <select name="facilitador_id" class="form-select">
                                <option value="">-- Todos los Facilitadores --</option>
                                @foreach ($facilitadores as $facilitador)
                                    <option value="{{ $facilitador->id }}"
                                        {{ request('facilitador_id') == $facilitador->id ? 'selected' : '' }}>
                                        {{ $facilitador->nombres }} {{ $facilitador->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 🔹 Filtrar por Aula -->
                        <div class="col-md-3">
                            <select name="aula_id" class="form-select">
                                <option value="">-- Todas las Aulas --</option>
                                @foreach ($aulas as $aula)
                                    <option value="{{ $aula->id }}"
                                        {{ request('aula_id') == $aula->id ? 'selected' : '' }}>
                                        {{ $aula->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 🔹 Filtrar por Día -->
                        <div class="col-md-3">

                            <select name="dia" class="form-select">
                                <option value="">-- Todos los Días --</option>
                                @foreach (['L' => 'Lunes', 'M' => 'Martes', 'MI' => 'Miércoles', 'J' => 'Jueves', 'V' => 'Viernes', 'S' => 'Sábado'] as $key => $dia)
                                    <option value="{{ $key }}" {{ request('dia') == $key ? 'selected' : '' }}>
                                        {{ $dia }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 🔹 Botones de acción -->
                        <div class="col-md-12 d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-info text-white me-2">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                            <a href="{{ route('horarios.index') }}" class="btn btn-secondary">
                                <i class="fas fa-eraser"></i> Limpiar Filtros
                            </a>
                        </div>
                    </form>
                </div>


                <!-- Tabla de horarios -->
                <div class="table-responsive">
                    <table class="table table-hover text-center shadow-sm">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>#</th>
                                <th>Curso</th>
                                <th>Facilitador</th>
                                <th>Aula</th>
                                <th>Días</th>
                                <th>Hora Inicio/Fin</th>

                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($horarios as $horario)
                                <tr class="{{ $loop->even ? 'table-light' : 'table-secondary' }}">
                                    <td class="fw-bold">{{ $loop->iteration }}</td>
                                    <td>{{ $horario->curso->nombre ?? 'N/A' }}</td>
                                    <td>{{ $horario->facilitador->nombres }} {{ $horario->facilitador->apellidos }}</td>
                                    <td>{{ $horario->aula->nombre }}</td>
                                    <td>
                                        {{ implode(
                                            ', ',
                                            array_map(
                                                fn($dia) => $dia == 'L'
                                                    ? 'Lunes'
                                                    : ($dia == 'M'
                                                        ? 'Martes'
                                                        : ($dia == 'MI'
                                                            ? 'Miércoles'
                                                            : ($dia == 'J'
                                                                ? 'Jueves'
                                                                : ($dia == 'V'
                                                                    ? 'Viernes'
                                                                    : ($dia == 'S'
                                                                        ? 'Sábado'
                                                                        : ''))))),
                                                explode(',', $horario->dias),
                                            ),
                                        ) }}
                                    </td>
                                    <td>{{ date('h:i A', strtotime($horario->hora_inicio)) }} -
                                        {{ date('h:i A', strtotime($horario->hora_fin)) }}</td>

                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <!-- Botón para abrir el modal de edición -->
                                            <button type="button" class="btn btn-sm btn-outline-warning me-1"
                                                data-bs-toggle="modal" data-bs-target="#editModal{{ $horario->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <!-- Botón para Eliminar -->
                                            <form action="{{ route('horarios.destroy', $horario->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('¿Eliminar este horario?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- MODAL PARA EDITAR HORARIO -->
                                <div class="modal fade" id="editModal{{ $horario->id }}" tabindex="-1"
                                    aria-labelledby="editModalLabel{{ $horario->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content border-0 shadow-lg rounded-4">
                                            <div class="modal-header bg-warning text-dark rounded-top">
                                                <h5 class="modal-title"><i class="fas fa-edit"></i> Editar Horario</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('horarios.update', $horario->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body bg-light">

                                                    <!-- Curso -->
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-book"></i> Curso</label>
                                                        <select name="curso_id" class="form-select shadow-sm" required>
                                                            @foreach ($cursos as $curso)
                                                                <option value="{{ $curso->id }}"
                                                                    {{ $horario->curso_id == $curso->id ? 'selected' : '' }}>
                                                                    {{ $curso->nombre }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Facilitador -->
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-user-tie"></i>
                                                            Facilitador</label>
                                                        <input type="text" class="form-control shadow-sm"
                                                            value="{{ $horario->facilitador->nombres }} {{ $horario->facilitador->apellidos }}"
                                                            readonly>
                                                    </div>

                                                    <!-- Aula -->
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-school"></i> Aula</label>
                                                        <select name="aula_id" class="form-select shadow-sm" required>
                                                            @foreach ($aulas as $aula)
                                                                <option value="{{ $aula->id }}"
                                                                    {{ $horario->aula_id == $aula->id ? 'selected' : '' }}>
                                                                    {{ $aula->nombre }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Días -->
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-calendar-day"></i>
                                                            Días</label>
                                                        <div class="d-flex flex-wrap">
                                                            @php
                                                                $diasSeleccionados = explode(',', $horario->dias);
                                                            @endphp
                                                            @foreach (['L' => 'Lunes', 'M' => 'Martes', 'MI' => 'Miércoles', 'J' => 'Jueves', 'V' => 'Viernes', 'S' => 'Sábado'] as $valor => $dia)
                                                                <div class="form-check me-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="dias[]" value="{{ $valor }}"
                                                                        {{ in_array($valor, $diasSeleccionados) ? 'checked' : '' }}>
                                                                    <label
                                                                        class="form-check-label">{{ $dia }}</label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    <!-- Horarios -->
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="form-label"><i class="fas fa-clock"></i> Hora
                                                                Inicio</label>
                                                            <select name="hora_inicio" class="form-select shadow-sm"
                                                                required>
                                                                <option value="08:00"
                                                                    {{ $horario->hora_inicio == '08:00' ? 'selected' : '' }}>
                                                                    08:00 AM</option>
                                                                <option value="13:00"
                                                                    {{ $horario->hora_inicio == '13:00' ? 'selected' : '' }}>
                                                                    01:00 PM</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label"><i class="fas fa-clock"></i> Hora
                                                                Fin</label>
                                                            <select name="hora_fin" class="form-select shadow-sm"
                                                                required>
                                                                <option value="12:00"
                                                                    {{ $horario->hora_fin == '12:00' ? 'selected' : '' }}>
                                                                    12:00 PM</option>
                                                                <option value="17:00"
                                                                    {{ $horario->hora_fin == '17:00' ? 'selected' : '' }}>
                                                                    05:00 PM</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Botones de Acción -->
                                                <div class="modal-footer bg-light rounded-bottom">
                                                    <button type="submit" class="btn btn-warning shadow-sm"><i
                                                            class="fas fa-save"></i> Guardar Cambios</button>
                                                    <button type="button" class="btn btn-secondary shadow-sm"
                                                        data-bs-dismiss="modal"><i class="fas fa-times"></i>
                                                        Cancelar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- FIN DEL MODAL -->

                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        No hay horarios registrados.
                                    </td>
                                </tr>

                            @endforelse
                        </tbody>


                    </table>
                </div>
                <!-- 🔹 PAGINACIÓN CENTRADA -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $horarios->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
