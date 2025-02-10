@extends('layouts.layout')

@section('title', 'Calificaciones')

@section('content')
    <div class="container py-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header text-dark text-center rounded-top">
                <h2 class="mb-0"><i class="fas fa-graduation-cap"></i> Gestión de Calificaciones</h2>
            </div>
            <div class="card-body bg-light p-4">
                <!-- Contenedor para los botones -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-secondary"><i class="fas fa-list-alt"></i> Lista de Calificaciones</h5>

                    <!-- Contenedor de botones con espacio entre ellos -->
                    <div class="d-flex gap-2">
                        <!-- Botón para agregar nueva calificación -->
                        <a href="{{ route('calificaciones.create') }}" class="btn btn-success btn-sm shadow-sm">
                            <i class="fas fa-plus"></i> Agregar Calificación
                        </a>

                        <!-- Botón de Exportar a Excel -->
                        <a href="{{ route('calificaciones.export') }}" class="btn btn-outline-success btn-sm shadow-sm">
                            <i class="fas fa-file-excel"></i> Exportar a Excel
                        </a>
                    </div>
                </div>

                <!--  FILTROS AVANZADOS -->
                <div class="mb-4 p-3 bg-white rounded shadow-sm border">
                    <h5 class="mb-3 text-info"><i class="fas fa-filter"></i> Filtros de Búsqueda</h5>
                    <form action="{{ route('calificaciones.index') }}" method="GET" class="row g-2 align-items-center">

                        <!--  Buscar por nombre o cédula del alumno -->
                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="search" class="form-control"
                                    placeholder="Buscar alumno o cédula..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <!--  Filtro por curso -->
                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><i class="fas fa-book"></i></span>
                                <select name="curso_id" class="form-control">
                                    <option value="">-- Filtrar por Curso --</option>
                                    @foreach ($cursos as $curso)
                                        <option value="{{ $curso->id }}"
                                            {{ request('curso_id') == $curso->id ? 'selected' : '' }}>
                                            {{ $curso->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--  Filtro por Estado de Aprobación -->
                        <div class="col-md-3">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                <select name="estado" class="form-control">
                                    <option value="">-- Filtrar por Estado --</option>
                                    <option value="aprobado" {{ request('estado') == 'aprobado' ? 'selected' : '' }}>
                                        Aprobados </option>
                                    <option value="reprobado" {{ request('estado') == 'reprobado' ? 'selected' : '' }}>
                                        Reprobados </option>
                                </select>
                            </div>
                        </div>

                        <!--  Botones de acción -->
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-info btn-sm text-white me-2">
                                <i class="fas fa-search"></i> Filtrar
                            </button>
                            <a href="{{ route('calificaciones.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-eraser"></i> Limpiar
                            </a>
                        </div>
                    </form>
                </div>

                @if (session('success'))
                    <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
                @endif

                <!--  Tabla con estilos -->
                <div class="table-responsive">
                    <table class="table table-hover text-center shadow-sm">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>#</th>
                                <th>Alumno</th>
                                <th>Curso</th>
                                <th>Calificación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($calificaciones as $index => $calificacion)
                                <tr class="{{ $loop->even ? 'table-light' : 'table-secondary' }}">
                                    <td class="fw-bold">{{ $calificaciones->firstItem() + $index }}</td>
                                    <td>
                                        <i class="fas fa-user"></i>
                                        {{ $calificacion->alumno->nombres }}
                                        {{ $calificacion->alumno->apellidos }}
                                    </td>
                                    <td>
                                        <i class="fas fa-book"></i> {{ $calificacion->curso->nombre }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge 
                                            {{ $calificacion->calificacion >= 10 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $calificacion->calificacion }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-1">
                                            <!-- Botón para abrir el modal de edición -->
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $calificacion->id }}" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                    
                                            <!-- Botón para Eliminar -->
                                            <form action="{{ route('calificaciones.destroy', $calificacion->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"
                                                    onclick="return confirm('¿Eliminar esta calificación?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                    
                                            <!-- Botón para ver historial de calificaciones -->
                                            <a href="{{ route('calificaciones.historial', $calificacion->alumno->id) }}" 
                                                class="btn btn-sm btn-info" title="Historial">
                                                <i class="fas fa-list"></i>
                                            </a>
                                    
                                            <!-- Botón para descargar certificado (Siempre ocupa su espacio) -->
                                            <a href="{{ $calificacion->calificacion >= 10 ? route('certificado.pdf', $calificacion->id) : '#' }}" 
                                                class="btn btn-sm btn-primary {{ $calificacion->calificacion < 10 ? 'disabled' : '' }}" 
                                                title="Descargar Certificado">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>


                                <!-- MODAL PARA EDITAR CALIFICACIÓN -->
                                <div class="modal fade" id="editModal{{ $calificacion->id }}" tabindex="-1"
                                    aria-labelledby="editModalLabel{{ $calificacion->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content border-0 shadow-lg rounded-4">
                                            <div class="modal-header bg-warning text-dark rounded-top">
                                                <h5 class="modal-title"><i class="fas fa-edit"></i> Editar Calificación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('calificaciones.update', $calificacion->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body bg-light">
                                                    <div class="row">
                                                        <!-- Alumno (No se puede modificar) -->
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"><i
                                                                        class="fas fa-user-graduate"></i> Alumno</label>
                                                                <input type="text" class="form-control shadow-sm"
                                                                    value="{{ $calificacion->alumno->nombres }} {{ $calificacion->alumno->apellidos }}"
                                                                    readonly>
                                                            </div>
                                                        </div>

                                                        <!-- Curso (No se puede modificar) -->
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"><i class="fas fa-book"></i>
                                                                    Curso</label>
                                                                <input type="text" class="form-control shadow-sm"
                                                                    value="{{ $calificacion->curso->nombre }}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Calificación (Editable) -->
                                                    <div class="row">
                                                        <div class="col-md-6 mx-auto">
                                                            <div class="mb-3">
                                                                <label for="calificacion" class="form-label"><i
                                                                        class="fas fa-star"></i> Calificación</label>
                                                                <input type="number" name="calificacion"
                                                                    id="calificacion"
                                                                    class="form-control shadow-sm text-center" required
                                                                    min="0" max="20" step="0.1"
                                                                    value="{{ $calificacion->calificacion }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Botones de acción -->
                                                <div class="modal-footer bg-light rounded-bottom">
                                                    <button type="submit" class="btn btn-warning shadow-sm">
                                                        <i class="fas fa-save"></i> Guardar Cambios
                                                    </button>
                                                    <button type="button" class="btn btn-secondary shadow-sm"
                                                        data-bs-dismiss="modal">
                                                        <i class="fas fa-times"></i> Cancelar
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        <i class="fas fa-exclamation-circle"></i> No se encontraron
                                        calificaciones con los criterios de búsqueda.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!--  Paginación Centrada -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $calificaciones->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>
    </div>
@endsection
