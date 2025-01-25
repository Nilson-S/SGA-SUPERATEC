@extends('layouts.layout')

@section('title', 'Facilitadores')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Facilitadores Registrados</h1>
            <a href="{{ route('facilitadores.create') }}" class="btn btn-primary shadow">+ Agregar Facilitador</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success shadow">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover shadow rounded-3 text-center align-middle">
                <!-- Encabezado -->
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
                <!-- Cuerpo de la tabla -->
                <tbody>
                    @foreach ($facilitadores as $facilitador)
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

                                <!-- Botón para Eliminar -->
                                <form action="{{ route('facilitadores.destroy', $facilitador) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Eliminar este facilitador?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal para Ver Más -->
                        <div class="modal fade" id="detailsModal{{ $facilitador->id }}" tabindex="-1"
                            aria-labelledby="detailsModalLabel{{ $facilitador->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title" id="detailsModalLabel{{ $facilitador->id }}">Detalles del
                                            Facilitador</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Nombre:</strong> {{ $facilitador->nombres }} </p>
                                        <p><strong>Apellido:</strong> {{ $facilitador->apellidos }}</p>
                                        <p><strong>Cédula:</strong> {{ $facilitador->cedula }}</p>
                                        <p><strong>Especialidad:</strong> {{ $facilitador->especialidad }}</p>
                                        <p><strong>Teléfono:</strong> {{ $facilitador->telefono ?? 'N/A' }}</p>
                                        <p><strong>Correo:</strong> {{ $facilitador->correo ?? 'N/A' }}</p>
                                        <p><strong>Fecha de Registro:</strong>
                                            {{ $facilitador->created_at->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary shadow-sm"
                                            data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para Editar -->
                        <div class="modal fade" id="editModal{{ $facilitador->id }}" tabindex="-1"
                            aria-labelledby="editModalLabel{{ $facilitador->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-dark">
                                        <h5 class="modal-title" id="editModalLabel{{ $facilitador->id }}">Editar
                                            Facilitador</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('facilitadores.update', $facilitador) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="row">
                                                <!-- Primera columna -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="nombres" class="form-label">Nombre</label>
                                                        <input type="text" name="nombres" id="nombres"
                                                            class="form-control" value="{{ $facilitador->nombres }}"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="apellidos" class="form-label">Apellido</label>
                                                        <input type="text" name="apellidos" id="apellidos"
                                                            class="form-control" value="{{ $facilitador->apellidos }}"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="cedula" class="form-label">Cédula</label>
                                                        <input type="text" name="cedula" id="cedula"
                                                            class="form-control" value="{{ $facilitador->cedula }}"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="especialidad" class="form-label">Especialidad</label>
                                                        <input type="text" name="especialidad" id="especialidad"
                                                            class="form-control" value="{{ $facilitador->especialidad }}"
                                                            required>
                                                    </div>
                                                </div>

                                                <!-- Segunda columna -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="telefono" class="form-label">Teléfono</label>
                                                        <input type="text" name="telefono" id="telefono"
                                                            class="form-control" value="{{ $facilitador->telefono }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="correo" class="form-label">Correo</label>
                                                        <input type="email" name="correo" id="correo"
                                                            class="form-control" value="{{ $facilitador->correo }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="created_at" class="form-label">Fecha de
                                                            Registro</label>
                                                        <input type="text" id="created_at" class="form-control"
                                                            value="{{ $facilitador->created_at->format('d/m/Y') }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success shadow-sm">Guardar
                                                Cambios</button>
                                            <button type="button" class="btn btn-secondary shadow-sm"
                                                data-bs-dismiss="modal">Cancelar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
