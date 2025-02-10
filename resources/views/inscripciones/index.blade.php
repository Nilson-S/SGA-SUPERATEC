@extends('layouts.layout')

@section('title', 'Inscripciones')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3"><i class="fas fa-file-alt"></i> Gestión de Inscripciones</h1>
            <a href="{{ route('inscripciones.create') }}" class="btn btn-primary shadow">
                <i class="fas fa-plus"></i> Nueva Inscripción
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success shadow">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger shadow">{{ session('error') }}</div>
        @endif

        <!--  Filtros Avanzados -->
        <div class="mb-4 p-3 bg-white rounded shadow-sm border">
            <h5 class="mb-3 text-info"><i class="fas fa-filter"></i> Filtros de Búsqueda</h5>
            <form action="{{ route('inscripciones.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Alumno o cédula"
                            value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="fas fa-book"></i></span>
                        <select name="curso_id" class="form-control">
                            <option value="">-- Curso --</option>
                            @foreach ($cursos as $curso)
                                <option value="{{ $curso->id }}"
                                    {{ request('curso_id') == $curso->id ? 'selected' : '' }}>
                                    {{ $curso->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                        <select name="metodo_pago" class="form-control">
                            <option value="">-- Método de Pago --</option>
                            <option value="Transferencia Bancaria"
                                {{ request('metodo_pago') == 'Transferencia Bancaria' ? 'selected' : '' }}>
                                Transferencia Bancaria
                            </option>
                            <option value="Efectivo Bs" {{ request('metodo_pago') == 'Efectivo Bs' ? 'selected' : '' }}>
                                Efectivo Bs
                            </option>
                            <option value="Efectivo USD" {{ request('metodo_pago') == 'Efectivo USD' ? 'selected' : '' }}>
                                Efectivo USD
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-info btn-sm text-white me-2">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                    <a href="{{ route('inscripciones.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-eraser"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>

        <!-- Tabla de Inscripciones -->
        <div class="table-responsive">
            <table class="table table-hover shadow rounded-3 text-center align-middle">
                <thead class="bg-info text-white">
                    <tr>    
                        <th>#</th>
                        <th>Alumno</th>
                        <th>Curso</th>
                        <th>Fecha de Inscripción</th>
                        <th>Monto Pagado</th>
                        <th>Estado de Pago</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($inscripciones as $inscripcion)
                        <tr class="{{ $loop->even ? 'table-light' : 'table-secondary' }}">
                            <td class="fw-bold">{{ $loop->iteration }}</td>
                            <td>{{ $inscripcion->alumno->nombres }} {{ $inscripcion->alumno->apellidos }}</td>
                            <td>{{ $inscripcion->curso->nombre }}</td>
                            <td>{{ $inscripcion->fecha_inscripcion }}</td>
                            <td>${{ $inscripcion->monto_pago ?? '0.00' }}</td>
                            <td>
                                @if ($inscripcion->monto_pago >= $inscripcion->curso->costo)
                                    <span class="badge bg-success"><i class="fas fa-check-circle"></i> Pagado</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-exclamation-circle"></i> Pendiente</span>
                                    <form action="{{ route('inscripciones.marcarPagado', $inscripcion->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-success ms-2"
                                            onclick="return confirm('¿Confirmar que esta inscripción ha sido pagada?')">
                                            <i class="fas fa-money-check-alt"></i> Marcar como Pagado
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                    data-bs-target="#detailsModal{{ $inscripcion->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $inscripcion->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('inscripciones.destroy', $inscripcion) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Eliminar esta inscripción?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                <a href="{{ route('inscripciones.historial', $inscripcion->alumno->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-history"></i> Ver Historial
                                </a>
                            </td>
                        </tr>

                        <!-- Modal para Ver Detalles -->
                        <div class="modal fade" id="detailsModal{{ $inscripcion->id }}" tabindex="-1"
                            aria-labelledby="detailsModalLabel{{ $inscripcion->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <div class="modal-header bg-info text-white rounded-top">
                                        <h5 class="modal-title">
                                            <i class="fas fa-info-circle"></i> Detalles de la Inscripción
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body bg-light">
                                        <p><strong><i class="fas fa-user"></i> Alumno:</strong>
                                            {{ $inscripcion->alumno->nombres }} {{ $inscripcion->alumno->apellidos }}
                                        </p>
                                        <p><strong><i class="fas fa-id-card"></i> Cédula:</strong>
                                            {{ $inscripcion->alumno->cedula }}
                                        </p>
                                        <p><strong><i class="fas fa-book"></i> Curso:</strong>
                                            {{ $inscripcion->curso->nombre }}
                                        </p>
                                        <p><strong><i class="fas fa-calendar-alt"></i> Fecha de Inscripción:</strong>
                                            {{ $inscripcion->fecha_inscripcion }}
                                        </p>
                                        <p><strong><i class="fas fa-dollar-sign"></i> Monto Pagado:</strong>
                                            ${{ $inscripcion->monto_pago ?? '0.00' }}
                                        </p>
                                        <p><strong><i class="fas fa-credit-card"></i> Método de Pago:</strong>
                                            {{ $inscripcion->metodo_pago ?? 'No registrado' }}
                                        </p>
                                        <p><strong><i class="fas fa-calendar-check"></i> Fecha de Pago:</strong>
                                            {{ $inscripcion->fecha_pago ?? 'No registrado' }}
                                        </p>
                                    </div>
                                    <div class="modal-footer bg-light rounded-bottom">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times"></i> Cerrar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para Editar Inscripción -->
                        <div class="modal fade" id="editModal{{ $inscripcion->id }}" tabindex="-1"
                            aria-labelledby="editModalLabel{{ $inscripcion->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <div class="modal-header bg-warning text-dark rounded-top">
                                        <h5 class="modal-title">
                                            <i class="fas fa-edit"></i> Editar Inscripción
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('inscripciones.update', $inscripcion) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body bg-light">
                                            <div class="row">
                                                <!-- Columna 1 -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-user"></i>
                                                            Alumno</label>
                                                        <select name="alumno_id" class="form-control" required>
                                                            @foreach ($alumnos as $alumno)
                                                                <option value="{{ $alumno->id }}"
                                                                    {{ $inscripcion->alumno_id == $alumno->id ? 'selected' : '' }}>
                                                                    {{ $alumno->nombres }} {{ $alumno->apellidos }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-book"></i>
                                                            Curso</label>
                                                        <select name="curso_id" class="form-control" required>
                                                            @foreach ($cursos as $curso)
                                                                <option value="{{ $curso->id }}"
                                                                    {{ $inscripcion->curso_id == $curso->id ? 'selected' : '' }}>
                                                                    {{ $curso->nombre }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-calendar-alt"></i>
                                                            Fecha de Inscripción</label>
                                                        <input type="date" name="fecha_inscripcion"
                                                            class="form-control"
                                                            value="{{ $inscripcion->fecha_inscripcion }}" required>
                                                    </div>
                                                </div>

                                                <!-- Columna 2 -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-dollar-sign"></i> Monto
                                                            Pagado</label>
                                                        <input type="number" name="monto_pago" class="form-control"
                                                            value="{{ $inscripcion->monto_pago }}" step="0.01">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-credit-card"></i>
                                                            Método de Pago</label>
                                                        <select name="metodo_pago" class="form-control">
                                                            <option value="Transferencia Bancaria"
                                                                {{ $inscripcion->metodo_pago == 'Transferencia Bancaria' ? 'selected' : '' }}>
                                                                Transferencia Bancaria
                                                            </option>
                                                            <option value="Efectivo Bs"
                                                                {{ $inscripcion->metodo_pago == 'Efectivo Bs' ? 'selected' : '' }}>
                                                                Efectivo Bs
                                                            </option>
                                                            <option value="Efectivo USD"
                                                                {{ $inscripcion->metodo_pago == 'Efectivo USD' ? 'selected' : '' }}>
                                                                Efectivo USD
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-calendar-check"></i>
                                                            Fecha de Pago</label>
                                                        <input type="date" name="fecha_pago" class="form-control"
                                                            value="{{ $inscripcion->fecha_pago }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light rounded-bottom">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save"></i> Guardar Cambios
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="fas fa-times"></i> Cancelar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="7" class="text-muted"><i class="fas fa-exclamation-circle"></i> No se
                                encontraron inscripciones con los criterios de búsqueda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
