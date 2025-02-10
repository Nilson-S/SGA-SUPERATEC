@extends('layouts.layout')

@section('title', 'Alumnos')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3"><i class="fas fa-users"></i> Lista de Alumnos</h1>
            <a href="{{ route('alumnos.create') }}" class="btn btn-primary shadow">
                <i class="fas fa-plus"></i> Agregar Alumno
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success shadow">{{ session('success') }}</div>
        @endif

        <!--  Barra de búsqueda -->
        <div class="mb-4 d-flex justify-content-start">
            <form action="{{ route('alumnos.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control form-control-sm me-2"
                    placeholder="Buscar cédula..." value="{{ request('search') }}" style="width: 250px;">
                <button type="submit" class="btn btn-info btn-sm text-white">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </form>
        </div>

        <!--  Tabla de alumnos -->
        <div class="table-responsive">
            <table class="table table-hover shadow rounded-3 text-center align-middle">
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
                <tbody>
                    @forelse ($alumnos as $alumno)
                        <tr class="{{ $loop->even ? 'table-light' : 'table-secondary' }}">
                            <td class="fw-bold">{{ $loop->iteration }}</td>
                            <td>{{ $alumno->nombres }}</td>
                            <td>{{ $alumno->apellidos }}</td>
                            <td>{{ $alumno->cedula }}</td>
                            <td>{{ $alumno->correo }}</td>
                            <td>
                                <!--  Ver detalles -->
                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                    data-bs-target="#detailsModal{{ $alumno->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <!--  Editar -->
                                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $alumno->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!--  Eliminar -->
                                <form action="{{ route('alumnos.destroy', $alumno) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Eliminar este alumno?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                            <td>
                                <a href="{{ route('calificaciones.historial', $alumno->id) }}"
                                    class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-file-alt"> Calificacion</i> 
                                </a>
                            </td>
                            </form>
                            </td>
                        </tr>

                        <!-- Modal para Ver Detalles del Alumno -->
                        <div class="modal fade" id="detailsModal{{ $alumno->id }}" tabindex="-1"
                            aria-labelledby="detailsModalLabel{{ $alumno->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <!-- Encabezado -->
                                    <div class="modal-header bg-info text-white rounded-top">
                                        <h5 class="modal-title fw-bold">
                                            <i class="fas fa-user-graduate"></i> Detalles del Alumno
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <!-- Cuerpo del modal -->
                                    <div class="modal-body bg-light">
                                        <div class="row">
                                            <!-- Columna Izquierda -->
                                            <div class="col-md-6">
                                                <p><strong><i class="fas fa-user"></i> Nombre:</strong>
                                                    {{ $alumno->nombres }}</p>
                                                <p><strong><i class="fas fa-user-tag"></i> Apellido:</strong>
                                                    {{ $alumno->apellidos }}</p>
                                                <p><strong><i class="fas fa-id-card"></i> Cédula:</strong>
                                                    {{ $alumno->cedula }}</p>
                                                <p><strong><i class="fas fa-calendar-alt"></i> Fecha de Nacimiento:</strong>
                                                    <span class="text-success">{{ $alumno->fecha_nacimiento }}</span>
                                                </p>
                                                <p><strong><i class="fas fa-venus-mars"></i> Género:</strong>
                                                    {{ ucfirst($alumno->genero) }}</p>
                                            </div>

                                            <!-- Columna Derecha -->
                                            <div class="col-md-6">
                                                <p><strong><i class="fas fa-book-reader"></i> Grado de Instrucción:</strong>
                                                    {{ $alumno->grado_instruccion }}</p>
                                                <p><strong><i class="fas fa-map-marker-alt"></i> Dirección:</strong>
                                                    {{ $alumno->direccion }}</p>
                                                <p><strong><i class="fas fa-phone"></i> Teléfono:</strong>
                                                    {{ $alumno->telefono }}</p>
                                                <p><strong><i class="fas fa-envelope"></i> Correo:</strong>
                                                    {{ $alumno->correo }}</p>
                                                <p><strong><i class="fas fa-calendar-check"></i> Fecha de Registro:</strong>
                                                    <span
                                                        class="text-success">{{ $alumno->created_at->format('d/m/Y') }}</span>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Sección de Cursos Inscritos -->
                                        <div class="mt-4">
                                            <h5><i class="fas fa-book"></i> Cursos Inscritos</h5>
                                            @if ($alumno->inscripciones->isEmpty())
                                                <p class="text-muted">Este alumno no está inscrito en ningún curso.</p>
                                            @else
                                                <ul class="list-group">
                                                    @foreach ($alumno->inscripciones as $inscripcion)
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            <strong>{{ $inscripcion->curso->nombre }}</strong>
                                                            <span
                                                                class="badge bg-primary">{{ $inscripcion->curso->fecha_inicio }}
                                                                - {{ $inscripcion->curso->fecha_fin }}</span>
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


                        <!-- Modal para Editar Alumno -->
                        <div class="modal fade" id="editModal{{ $alumno->id }}" tabindex="-1"
                            aria-labelledby="editModalLabel{{ $alumno->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <!-- Encabezado -->
                                    <div class="modal-header bg-warning text-dark rounded-top">
                                        <h5 class="modal-title fw-bold">
                                            <i class="fas fa-edit"></i> Editar Alumno
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <!-- Formulario -->
                                    <form action="{{ route('alumnos.update', $alumno) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body bg-light">
                                            <div class="row">
                                                <!-- Primera columna -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-user"></i>
                                                            Nombre</label>
                                                        <input type="text" name="nombres" class="form-control"
                                                            value="{{ $alumno->nombres }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-user-tag"></i>
                                                            Apellido</label>
                                                        <input type="text" name="apellidos" class="form-control"
                                                            value="{{ $alumno->apellidos }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-id-card"></i>
                                                            Cédula</label>
                                                        <input type="text" name="cedula" class="form-control"
                                                            value="{{ $alumno->cedula }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-calendar-alt"></i>
                                                            Fecha de Nacimiento</label>
                                                        <input type="date" name="fecha_nacimiento"
                                                            class="form-control" value="{{ $alumno->fecha_nacimiento }}"
                                                            required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-birthday-cake"></i>
                                                            Edad</label>
                                                        <input type="number" name="edad" class="form-control"
                                                            value="{{ $alumno->edad }}" readonly>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-venus-mars"></i>
                                                            Género</label>
                                                        <select name="genero" class="form-control" required>
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
                                                        <label class="form-label"><i class="fas fa-book-reader"></i> Grado
                                                            de Instrucción</label>
                                                        <select name="grado_instruccion" class="form-control" required>
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
                                                        <label class="form-label"><i class="fas fa-map-marker-alt"></i>
                                                            Dirección</label>
                                                        <textarea name="direccion" class="form-control" rows="3">{{ $alumno->direccion }}</textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-phone"></i>
                                                            Teléfono</label>
                                                        <input type="text" name="telefono" class="form-control"
                                                            value="{{ $alumno->telefono }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-envelope"></i> Correo
                                                            Electrónico</label>
                                                        <input type="email" name="correo" class="form-control"
                                                            value="{{ $alumno->correo }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-calendar-check"></i>
                                                            Fecha de Registro</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $alumno->created_at->format('d/m/Y') }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pie del modal -->
                                        <div class="modal-footer bg-light rounded-bottom">
                                            <button type="submit" class="btn btn-success shadow-sm">
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
                            <td colspan="6">No se encontraron alumnos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
