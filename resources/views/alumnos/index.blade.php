@extends('layouts.layout')

@section('title', 'Alumnos')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Lista de Alumnos</h1>
            <a href="{{ route('alumnos.create') }}" class="btn btn-primary shadow">+ Agregar Alumno</a>
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
                        <th>Cédula</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <!-- Cuerpo de la tabla -->
                <tbody>
                    @foreach ($alumnos as $alumno)
                        <tr class="{{ $loop->even ? 'table-light' : 'table-secondary' }}">
                            <td class="fw-bold">{{ $loop->iteration }}</td>
                            <td>{{ $alumno->nombres }}</td>
                            <td>{{ $alumno->apellidos }}</td>
                            <td>{{ $alumno->cedula }}</td>
                            <td>{{ $alumno->correo }}</td>
                            <td>
                                <!-- Botón para Ver Más -->
                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                    data-bs-target="#detailsModal{{ $alumno->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <!-- Botón para Editar -->
                                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $alumno->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- Botón para Eliminar -->
                                <form action="{{ route('alumnos.destroy', $alumno) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Eliminar este alumno?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal para Ver Más -->
                        <div class="modal fade" id="detailsModal{{ $alumno->id }}" tabindex="-1"
                            aria-labelledby="detailsModalLabel{{ $alumno->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title" id="detailsModalLabel{{ $alumno->id }}">Detalles del
                                            Alumno</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Nombre:</strong> {{ $alumno->nombres }}</p>
                                        <p><strong>Apellido:</strong> {{ $alumno->apellidos }}</p>
                                        <p><strong>Cédula:</strong> {{ $alumno->cedula }}</p>
                                        <p><strong>Fecha de Nacimiento:</strong> {{ $alumno->fecha_nacimiento }}</p>
                                        <p><strong>Edad:</strong> {{ $alumno->edad }} años</p>
                                        <p><strong>Género:</strong> {{ ucfirst($alumno->genero) }}</p>
                                        <p><strong>Grado de Instrucción:</strong> {{ $alumno->grado_instruccion }}</p>
                                        <p><strong>Dirección:</strong> {{ $alumno->direccion }}</p>
                                        <p><strong>Teléfono:</strong> {{ $alumno->telefono }}</p>
                                        <p><strong>Correo Electrónico:</strong> {{ $alumno->correo }}</p>
                                        <p><strong>Fecha de Registro:</strong> {{ $alumno->created_at->format('d/m/Y') }}
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary shadow-sm"
                                            data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para Editar -->
                        <div class="modal fade" id="editModal{{ $alumno->id }}" tabindex="-1"
                            aria-labelledby="editModalLabel{{ $alumno->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-dark">
                                        <h5 class="modal-title" id="editModalLabel{{ $alumno->id }}">Editar Alumno</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('alumnos.update', $alumno) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="row">
                                                <!-- Primera columna -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="nombres" class="form-label">Nombres</label>
                                                        <input type="text" name="nombres" id="nombres"
                                                            class="form-control" value="{{ $alumno->nombres }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="apellidos" class="form-label">Apellidos</label>
                                                        <input type="text" name="apellidos" id="apellidos"
                                                            class="form-control" value="{{ $alumno->apellidos }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="cedula" class="form-label">Cédula</label>
                                                        <input type="text" name="cedula" id="cedula"
                                                            class="form-control" value="{{ $alumno->cedula }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="fecha_nacimiento" class="form-label">Fecha de
                                                            Nacimiento</label>
                                                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                                                            class="form-control" value="{{ $alumno->fecha_nacimiento }}"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="genero" class="form-label">Género</label>
                                                        <select name="genero" id="genero" class="form-control"
                                                            required>
                                                            <option value="Masculino"
                                                                {{ $alumno->genero == 'Masculino' ? 'selected' : '' }}>
                                                                Masculino</option>
                                                            <option value="Femenino"
                                                                {{ $alumno->genero == 'Femenino' ? 'selected' : '' }}>
                                                                Femenino</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- Segunda columna -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="grado_instruccion" class="form-label">Grado de
                                                            Instrucción</label>
                                                        <select name="grado_instruccion" id="grado_instruccion"
                                                            class="form-control" required>
                                                            <option value="Básica"
                                                                {{ $alumno->grado_instruccion == 'Básica' ? 'selected' : '' }}>
                                                                Básica</option>
                                                            <option value="Bachiller"
                                                                {{ $alumno->grado_instruccion == 'Bachiller' ? 'selected' : '' }}>
                                                                Bachiller</option>
                                                            <option value="Universitaria"
                                                                {{ $alumno->grado_instruccion == 'Universitaria' ? 'selected' : '' }}>
                                                                Universitaria</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="direccion" class="form-label">Dirección</label>
                                                        <textarea name="direccion" id="direccion" class="form-control" rows="3">{{ $alumno->direccion }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="telefono" class="form-label">Teléfono</label>
                                                        <input type="text" name="telefono" id="telefono"
                                                            class="form-control" value="{{ $alumno->telefono }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="correo" class="form-label">Correo
                                                            Electrónico</label>
                                                        <input type="email" name="correo" id="correo"
                                                            class="form-control" value="{{ $alumno->correo }}" required>
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
