@extends('layouts.layout')

@section('title', 'Cursos')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3"><i class="fas fa-graduation-cap"></i> Cursos Registrados</h1>
            <a href="{{ route('cursos.create') }}" class="btn btn-primary shadow">
                <i class="fas fa-plus"></i> Agregar Curso
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success shadow">{{ session('success') }}</div>
        @endif

        <!--  FILTROS AVANZADOS -->
        <div class="mb-4 p-3 bg-white rounded shadow-sm border">
            <h5 class="mb-3 text-info"><i class="fas fa-filter"></i> Filtros de Búsqueda</h5>
            <form action="{{ route('cursos.index') }}" method="GET" class="row g-2 align-items-center">

                <!--  Buscar por nombre del curso -->
                <div class="col-md-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Buscar curso..."
                            value="{{ request('search') }}">
                    </div>
                </div>

                <!--  Filtro por facilitador -->
                <div class="col-md-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                        <select name="facilitador_id" class="form-control">
                            <option value="">-- Filtrar por Facilitador --</option>
                            @foreach ($facilitadores as $facilitador)
                                <option value="{{ $facilitador->id }}"
                                    {{ request('facilitador_id') == $facilitador->id ? 'selected' : '' }}>
                                    {{ $facilitador->nombres }} {{ $facilitador->apellidos }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!--  Filtro por aula -->
                <div class="col-md-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="fas fa-school"></i></span>
                        <select name="aula_id" class="form-control">
                            <option value="">-- Filtrar por Aula --</option>
                            @foreach ($aulas as $aula)
                                <option value="{{ $aula->id }}" {{ request('aula_id') == $aula->id ? 'selected' : '' }}>
                                    {{ $aula->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!--  Botones de acción -->
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-info btn-sm text-white me-2">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                    <a href="{{ route('cursos.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-eraser"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>


        <div class="row row-cols-1 row-cols-md-3 g-4">
            @forelse ($cursos as $curso)
                <div class="col">
                    <div class="card h-100 shadow-lg border-0 rounded-4">
                        <div class="card-header bg-primary text-white text-center rounded-top">
                            <h5 class="mb-0 fw-bold">{{ $curso->nombre }}</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><strong>Descripción:</strong>
                                {{ Str::limit($curso->descripcion, 60, '...') }}</p>
                            <p class="card-text"><strong>Facilitador:</strong>
                                <span class="badge bg-secondary">{{ $curso->facilitador->nombres ?? 'N/A' }}
                                    {{ $curso->facilitador->apellidos ?? '' }}</span>
                            </p>
                            <p class="card-text"><strong>Inicio:</strong>
                                <span
                                    class="text-success">{{ \Carbon\Carbon::parse($curso->fecha_inicio)->format('d/m/Y') }}</span>
                            </p>
                        </div>
                        <div class="card-footer text-center bg-light rounded-bottom">
                            <!-- Botón para Ver Detalles -->
                            <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                data-bs-target="#detailsModal{{ $curso->id }}">
                                <i class="fas fa-eye"></i> Ver Detalles
                            </button>

                            <!-- Botón para Editar -->
                            <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $curso->id }}">
                                <i class="fas fa-edit"></i> Editar
                            </button>

                            <!-- Botón para Eliminar -->
                            <form action="{{ route('cursos.destroy', $curso) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('¿Eliminar este curso?')">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!--  Modal para Ver Detalles -->
                <div class="modal fade" id="detailsModal{{ $curso->id }}" tabindex="-1"
                    aria-labelledby="detailsModalLabel{{ $curso->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title" id="detailsModalLabel{{ $curso->id }}">
                                    <i class="fas fa-book"></i> Detalles del Curso
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Nombre:</strong> {{ $curso->nombre }}</p>
                                        <p><strong>Descripción:</strong> {{ $curso->descripcion ?? 'N/A' }}</p>
                                        <p><strong>Duración:</strong> {{ $curso->duracion_horas }} horas</p>
                                        <p><strong>Costo:</strong> <span
                                                class="badge bg-success">${{ $curso->costo }}</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Fecha de Inicio:</strong> <span
                                                class="text-success">{{ \Carbon\Carbon::parse($curso->fecha_inicio)->format('d/m/Y') }}</span>
                                        </p>
                                        <p><strong>Fecha de Fin:</strong> <span
                                                class="text-danger">{{ \Carbon\Carbon::parse($curso->fecha_fin)->format('d/m/Y') }}</span>
                                        </p>
                                        <p><strong>Aula:</strong> <span
                                                class="badge bg-primary">{{ $curso->aula->nombre ?? 'N/A' }}</span></p>
                                        <p><strong>Facilitador:</strong> <span
                                                class="badge bg-secondary">{{ $curso->facilitador->nombres ?? 'N/A' }}
                                                {{ $curso->facilitador->apellidos ?? '' }}</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer bg-light">
                                <!--  Nuevo Botón: Ver Información Completa -->
                                <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-primary shadow-sm">
                                    <i class="fas fa-info-circle"></i> Ver Información Completa
                                </a>

                                <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">
                                    <i class="fas fa-times"></i> Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  MODAL PARA EDITAR CURSO -->
                <div class="modal fade" id="editModal{{ $curso->id }}" tabindex="-1"
                    aria-labelledby="editModalLabel{{ $curso->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content border-0 shadow-lg rounded-4">
                            <div class="modal-header bg-warning text-dark rounded-top">
                                <h5 class="modal-title fw-bold" id="editModalLabel{{ $curso->id }}">
                                    <i class="fas fa-edit"></i> Editar Curso
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('cursos.update', $curso) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body bg-light">
                                    <div class="row">
                                        <!--  Columna 1 -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><i class="fas fa-book"></i> Nombre del
                                                    Curso</label>
                                                <input type="text" name="nombre" class="form-control"
                                                    value="{{ $curso->nombre }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label"><i class="fas fa-align-left"></i>
                                                    Descripción</label>
                                                <textarea name="descripcion" class="form-control" rows="3">{{ $curso->descripcion }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label"><i class="fas fa-dollar-sign"></i> Costo</label>
                                                <input type="number" name="costo" class="form-control"
                                                    value="{{ $curso->costo }}" step="0.01" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label"><i class="fas fa-clock"></i> Duración
                                                    (Horas)
                                                </label>
                                                <input type="number" name="duracion_horas" class="form-control"
                                                    value="{{ $curso->duracion_horas }}" required>
                                            </div>
                                        </div>

                                        <!--  Columna 2 -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><i class="fas fa-calendar-alt"></i> Fecha de
                                                    Inicio</label>
                                                <input type="date" name="fecha_inicio" class="form-control"
                                                    value="{{ $curso->fecha_inicio }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label"><i class="fas fa-calendar-check"></i> Fecha de
                                                    Fin</label>
                                                <input type="date" name="fecha_fin" class="form-control"
                                                    value="{{ $curso->fecha_fin }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label"><i class="fas fa-school"></i> Aula</label>
                                                <select name="aula_id" class="form-control" required>
                                                    @foreach ($aulas as $aula)
                                                        <option value="{{ $aula->id }}"
                                                            {{ $curso->aula_id == $aula->id ? 'selected' : '' }}>
                                                            {{ $aula->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label"><i class="fas fa-user-tie"></i>
                                                    Facilitador</label>
                                                <select name="facilitador_id" class="form-control" required>
                                                    @foreach ($facilitadores as $facilitador)
                                                        <option value="{{ $facilitador->id }}"
                                                            {{ $curso->facilitador_id == $facilitador->id ? 'selected' : '' }}>
                                                            {{ $facilitador->nombres }} {{ $facilitador->apellidos }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--  Botones del modal -->
                                <div class="modal-footer bg-light rounded-bottom">
                                    <button type="submit" class="btn btn-success shadow-sm">
                                        <i class="fas fa-save"></i> Guardar Cambios
                                    </button>
                                    <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">
                                        <i class="fas fa-times"></i> Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <!--  MENSAJE CUANDO NO HAY RESULTADOS -->
                <tr>
                    <td colspan="5" class="text-muted"><i class="fas fa-exclamation-circle"></i> No se encontraron
                        cursos con los criterios de búsqueda.</td>
                </tr>
            @endforelse
        </div>

        <!--  PAGINACIÓN CENTRADA -->
        <div class="d-flex justify-content-center mt-4">
            {{ $cursos->links('pagination::bootstrap-5') }}
        </div>

    </div>
@endsection
