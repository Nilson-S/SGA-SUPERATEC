@extends('layouts.layout')

@section('title', 'Usuarios Administradores')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Gestión de Usuarios Administradores</h1>
            <a href="{{ route('users.create') }}" class="btn btn-primary shadow">+ Agregar Usuario</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success shadow">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover shadow rounded-3">
                <!-- Encabezado -->
                <thead class="bg-info text-white">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo Electrónico</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <!-- Cuerpo de la tabla -->
                <tbody>
                    @foreach ($users as $user)
                        <tr class="{{ $loop->even ? 'table-light' : 'table-secondary' }}">
                            <td class="text-center fw-bold">{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->apellido }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                                <!-- Botón para ver detalles -->
                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                    data-bs-target="#detailsModal{{ $user->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <!-- Botón para editar -->
                                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $user->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- Botón para eliminar -->
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Eliminar este usuario?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal para Ver Detalles -->
                        <div class="modal fade" id="detailsModal{{ $user->id }}" tabindex="-1"
                            aria-labelledby="detailsModalLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title" id="detailsModalLabel{{ $user->id }}">Detalles del
                                            Usuario</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Nombre:</strong> {{ $user->name }}</p>
                                        <p><strong>Apellido:</strong> {{ $user->apellido }}</p>
                                        <p><strong>Cédula:</strong> {{ $user->cedula }}</p>
                                        <p><strong>Género:</strong> {{ ucfirst($user->genero) }}</p>
                                        <p><strong>Fecha de Nacimiento:</strong> {{ $user->fecha_nacimiento }}</p>
                                        <p><strong>Edad:</strong> {{ $user->edad }} años</p>
                                        <p><strong>Correo Electrónico:</strong> {{ $user->email }}</p>
                                        <p><strong>Fecha de Creación:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary shadow-sm"
                                            data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para Editar -->
                        <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1"
                            aria-labelledby="editModalLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-dark">
                                        <h5 class="modal-title" id="editModalLabel{{ $user->id }}">Editar Usuario</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('users.update', $user) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="row">
                                                <!-- Primera columna -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Nombre</label>
                                                        <input type="text" name="name" id="name"
                                                            class="form-control" value="{{ $user->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="apellido" class="form-label">Apellido</label>
                                                        <input type="text" name="apellido" id="apellido"
                                                            class="form-control" value="{{ $user->apellido }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="cedula" class="form-label">Cédula de Identidad</label>
                                                        <input type="text" name="cedula" id="cedula"
                                                            class="form-control" value="{{ $user->cedula }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="genero" class="form-label">Género</label>
                                                        <select name="genero" id="genero" class="form-control" required>
                                                            <option value="masculino"
                                                                {{ $user->genero == 'masculino' ? 'selected' : '' }}>
                                                                Masculino
                                                            </option>
                                                            <option value="femenino"
                                                                {{ $user->genero == 'femenino' ? 'selected' : '' }}>
                                                                Femenino
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- Segunda columna -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="fecha_nacimiento" class="form-label">Fecha de
                                                            Nacimiento</label>
                                                        <input type="date" name="fecha_nacimiento"
                                                            id="fecha_nacimiento" class="form-control"
                                                            value="{{ $user->fecha_nacimiento }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Correo
                                                            Electrónico</label>
                                                        <input type="email" name="email" id="email"
                                                            class="form-control" value="{{ $user->email }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="password" class="form-label">Nueva Contraseña
                                                            (Opcional)</label>
                                                        <input type="password" name="password" id="password"
                                                            class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="password_confirmation" class="form-label">Confirmar
                                                            Contraseña</label>
                                                        <input type="password" name="password_confirmation"
                                                            id="password_confirmation" class="form-control">
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
