@extends('layouts.layout')

@section('title', 'Cursos')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Cursos Registrados</h1>
            <a href="{{ route('cursos.create') }}" class="btn btn-primary shadow">+ Agregar Curso</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success shadow">{{ session('success') }}</div>
        @endif

        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($cursos as $curso)
                <div class="col">
                    <div class="card h-100 shadow">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $curso->nombre }}</h5>
                            <p class="card-text">
                                {{ Str::limit($curso->descripcion, 50, '...') }}
                            </p>
                            <p class="card-text"><strong>Facilitador:</strong> 
                                {{ $curso->facilitador->nombres ?? 'N/A' }} {{ $curso->facilitador->apellidos ?? '' }}
                            </p>
                            <p class="card-text"><strong>Fecha de Inicio:</strong> {{ $curso->fecha_inicio }}</p>
                        </div>
                        <div class="card-footer text-center">
                            <!-- Botón para Ver Detalles -->
                            <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                data-bs-target="#detailsModal{{ $curso->id }}">
                                <i class="fas fa-eye"></i> Ver
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

                <!-- Modal para Ver Detalles -->
                <div class="modal fade" id="detailsModal{{ $curso->id }}" tabindex="-1"
                    aria-labelledby="detailsModalLabel{{ $curso->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title" id="detailsModalLabel{{ $curso->id }}">Detalles del Curso</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Nombre:</strong> {{ $curso->nombre }}</p>
                                <p><strong>Descripción:</strong> {{ $curso->descripcion ?? 'N/A' }}</p>
                                <p><strong>Costo:</strong> ${{ $curso->costo }}</p>
                                <p><strong>Duración:</strong> {{ $curso->duracion_horas }} horas</p>
                                <p><strong>Fecha de Inicio:</strong> {{ $curso->fecha_inicio }}</p>
                                <p><strong>Fecha de Fin:</strong> {{ $curso->fecha_fin }}</p>
                                <p><strong>Aula:</strong> {{ $curso->aula->nombre ?? 'N/A' }}</p>
                                <p><strong>Facilitador:</strong> {{ $curso->facilitador->nombres ?? 'N/A' }}
                                    {{ $curso->facilitador->apellidos ?? '' }}
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para Editar -->
                <div class="modal fade" id="editModal{{ $curso->id }}" tabindex="-1"
                    aria-labelledby="editModalLabel{{ $curso->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-dark">
                                <h5 class="modal-title" id="editModalLabel{{ $curso->id }}">Editar Curso</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('cursos.update', $curso) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nombre" class="form-label">Nombre</label>
                                                <input type="text" name="nombre" id="nombre" class="form-control"
                                                    value="{{ $curso->nombre }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="descripcion" class="form-label">Descripción</label>
                                                <textarea name="descripcion" id="descripcion" class="form-control">{{ $curso->descripcion }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="costo" class="form-label">Costo</label>
                                                <input type="number" name="costo" id="costo" class="form-control"
                                                    value="{{ $curso->costo }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="duracion_horas" class="form-label">Duración (Horas)</label>
                                                <input type="number" name="duracion_horas" id="duracion_horas"
                                                    class="form-control" value="{{ $curso->duracion_horas }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                                                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control"
                                                    value="{{ $curso->fecha_inicio }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                                                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control"
                                                    value="{{ $curso->fecha_fin }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="aula_id" class="form-label">Aula</label>
                                                <select name="aula_id" id="aula_id" class="form-control" required>
                                                    @foreach ($aulas as $aula)
                                                        <option value="{{ $aula->id }}" {{ $curso->aula_id == $aula->id ? 'selected' : '' }}>
                                                            {{ $aula->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="facilitador_id" class="form-label">Facilitador</label>
                                                <select name="facilitador_id" id="facilitador_id" class="form-control"
                                                    required>
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
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success shadow-sm">Guardar Cambios</button>
                                    <button type="button" class="btn btn-secondary shadow-sm"
                                        data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="d-flex justify-content-center mt-4">
            {{ $cursos->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
