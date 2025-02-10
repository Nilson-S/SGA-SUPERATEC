@extends('layouts.layout')

@section('title', 'Facilitadores')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3"><i class="fas fa-chalkboard-teacher"></i> Facilitadores Registrados</h1>
            <a href="{{ route('facilitadores.create') }}" class="btn btn-primary shadow">
                <i class="fas fa-plus"></i> Agregar Facilitador
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success shadow">{{ session('success') }}</div>
        @endif
        <!-- Barra de búsqueda -->
        <div class="mb-4 d-flex justify-content-start">
            <form action="{{ route('facilitadores.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control form-control-sm me-2"
                    placeholder="Buscar por cédula..." value="{{ request('search') }}" style="width: 250px;">
                <button type="submit" class="btn btn-info btn-sm text-white">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-hover shadow rounded-3 text-center align-middle">
                <thead class="bg-info text-white">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Especialidad</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($facilitadores as $facilitador)

                        <tr class="{{ $loop->even ? 'table-light' : 'table-secondary' }}">
                            <td class="fw-bold">{{ $loop->iteration }}</td>
                            <td>{{ $facilitador->nombres }}</td>
                            <td>{{ $facilitador->apellidos }}</td>
                            <td>{{ $facilitador->especialidad }}</td>
                            <td>{{ $facilitador->correo ?? 'N/A' }}</td>
                            <td>
                                <!-- Botón para Ver Más -->
                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                    data-bs-target="#detailsModal{{ $facilitador->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                            
                                <!-- Botón para Editar -->
                                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $facilitador->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            
                                <!-- Botón para Ver Horarios -->
                                <a href="{{ route('facilitadores.horarios', $facilitador->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-calendar-alt"></i>
                                </a>
                            
                                <!-- Botón para Eliminar -->
                                <form action="{{ route('facilitadores.destroy', $facilitador->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Eliminar este facilitador?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal para Ver Detalles del Facilitador -->
                        <div class="modal fade" id="detailsModal{{ $facilitador->id }}" tabindex="-1"
                            aria-labelledby="detailsModalLabel{{ $facilitador->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <!-- Encabezado del modal -->
                                    <div class="modal-header bg-info text-white rounded-top">
                                        <h5 class="modal-title fw-bold">
                                            <i class="fas fa-user-tie"></i> Detalles del Facilitador
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <!-- Cuerpo del modal -->
                                    <div class="modal-body bg-light">
                                        <div class="row">
                                            <!-- Columna Izquierda -->
                                            <div class="col-md-6">
                                                <p class="mb-2"><strong><i class="fas fa-user"></i> Nombre:</strong>
                                                    {{ $facilitador->nombres }}</p>
                                                <p class="mb-2"><strong><i class="fas fa-user-tag"></i> Apellido:</strong>
                                                    {{ $facilitador->apellidos }}</p>
                                                <p class="mb-2"><strong><i class="fas fa-id-card"></i> Cédula:</strong>
                                                    {{ $facilitador->cedula }}</p>
                                                <p class="mb-2"><strong><i class="fas fa-graduation-cap"></i>
                                                        Especialidad:</strong>
                                                    <span class="badge bg-primary">{{ $facilitador->especialidad }}</span>
                                                </p>
                                            </div>

                                            <!-- Columna Derecha -->
                                            <div class="col-md-6">
                                                <p class="mb-2"><strong><i class="fas fa-phone"></i> Teléfono:</strong>
                                                    {{ $facilitador->telefono ?? 'N/A' }}
                                                </p>
                                                <p class="mb-2"><strong><i class="fas fa-envelope"></i> Correo:</strong>
                                                    {{ $facilitador->correo ?? 'N/A' }}
                                                </p>
                                                <p class="mb-2"><strong><i class="fas fa-calendar-alt"></i> Fecha de
                                                        Registro:</strong>
                                                    <span
                                                        class="text-success">{{ $facilitador->created_at->format('d/m/Y') }}</span>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Sección de Cursos Impartidos -->
                                        <div class="mt-4">
                                            <h5><i class="fas fa-book-open"></i> Cursos Impartidos</h5>
                                            @if ($facilitador->cursos->isEmpty())
                                                <p class="text-muted">Este facilitador no está impartiendo ningún curso.</p>
                                            @else
                                                <ul class="list-group">
                                                    @foreach ($facilitador->cursos as $curso)
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            <strong>{{ $curso->nombre }}</strong>
                                                            <span class="badge bg-success">{{ $curso->fecha_inicio }} -
                                                                {{ $curso->fecha_fin }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Pie del modal -->
                                    <div class="modal-footer bg-light rounded-bottom">
                                        <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">
                                            <i class="fas fa-times"></i> Cerrar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Modal para Editar -->
                        <div class="modal fade" id="editModal{{ $facilitador->id }}" tabindex="-1"
                            aria-labelledby="editModalLabel{{ $facilitador->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <div class="modal-header bg-warning text-dark rounded-top">
                                        <h5 class="modal-title">
                                            <i class="fas fa-edit"></i> Editar Facilitador
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('facilitadores.update', $facilitador->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body bg-light">
                                            <div class="row">
                                                <!-- Primera columna -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="fas fa-user"></i> Nombre
                                                        </label>
                                                        <input type="text" name="nombres" class="form-control"
                                                            value="{{ $facilitador->nombres }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="fas fa-user-tag"></i> Apellido
                                                        </label>
                                                        <input type="text" name="apellidos" class="form-control"
                                                            value="{{ $facilitador->apellidos }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="fas fa-id-card"></i> Cédula
                                                        </label>
                                                        <input type="text" name="cedula" class="form-control"
                                                            value="{{ $facilitador->cedula }}" required>
                                                    </div>
                                                </div>

                                                <!-- Segunda columna -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="fas fa-briefcase"></i> Especialidad
                                                        </label>
                                                        <input type="text" name="especialidad" class="form-control"
                                                            value="{{ $facilitador->especialidad }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="fas fa-phone"></i> Teléfono
                                                        </label>
                                                        <input type="text" name="telefono" class="form-control"
                                                            value="{{ $facilitador->telefono }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="fas fa-envelope"></i> Correo
                                                        </label>
                                                        <input type="email" name="correo" class="form-control"
                                                            value="{{ $facilitador->correo }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
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
                            <td colspan="6" class="text-center">No se encontraron facilitadores con esta cédula.</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
@endsection
