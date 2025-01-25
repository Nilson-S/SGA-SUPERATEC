@extends('layouts.layout')

@section('title', 'Aulas')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Aulas Registradas</h1>
        <a href="{{ route('aulas.create') }}" class="btn btn-primary shadow">+ Agregar Aula</a>
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
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <!-- Cuerpo de la tabla -->
            <tbody>
                @foreach ($aulas as $aula)
                <tr class="{{ $loop->even ? 'table-light' : 'table-secondary' }}">
                    <td class="fw-bold">{{ $loop->iteration }}</td>
                    <td>{{ $aula->nombre }}</td>
                    <td>{{ $aula->descripcion ?? 'N/A' }}</td>
                    <td>
                        <!-- Botón para Ver Detalles -->
                        <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $aula->id }}">
                            <i class="fas fa-eye"></i>
                        </button>

                        <!-- Botón para Editar -->
                        <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $aula->id }}">
                            <i class="fas fa-edit"></i>
                        </button>

                        <!-- Botón para Eliminar -->
                        <form action="{{ route('aulas.destroy', $aula) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar esta aula?')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>

                <!-- Modal para Ver Detalles -->
                <div class="modal fade" id="detailsModal{{ $aula->id }}" tabindex="-1" aria-labelledby="detailsModalLabel{{ $aula->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title" id="detailsModalLabel{{ $aula->id }}">Detalles del Aula</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Nombre:</strong> {{ $aula->nombre }}</p>
                                <p><strong>Descripción:</strong> {{ $aula->descripcion ?? 'N/A' }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para Editar -->
                <div class="modal fade" id="editModal{{ $aula->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $aula->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-dark">
                                <h5 class="modal-title" id="editModalLabel{{ $aula->id }}">Editar Aula</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('aulas.update', $aula) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nombre" class="form-label">Nombre</label>
                                                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $aula->nombre }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="descripcion" class="form-label">Descripción</label>
                                                <textarea name="descripcion" id="descripcion" class="form-control">{{ $aula->descripcion }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success shadow-sm">Guardar Cambios</button>
                                    <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">Cancelar</button>
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
