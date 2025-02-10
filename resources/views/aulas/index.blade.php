@extends('layouts.layout')

@section('title', 'Aulas')

@section('content')
<div class="container py-5">
    <!-- Encabezado 1 -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary"><i class="fas fa-school"></i> Aulas Registradas</h1>
        <a href="{{ route('aulas.create') }}" class="btn btn-primary shadow">
            <i class="fas fa-plus"></i> Agregar Aula
        </a>
    </div>

        @if (session('success'))
            <div class="alert alert-success shadow">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover shadow rounded-3 text-center align-middle">
                <thead class="text-white" style="background-color: #007bff;">
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
                                
                                <!-- Botón para ver cursos en el aula -->
                                <a href="{{ route('aulas.show', $aula->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-book"></i>
                                </a>
                                <!-- Botón para Editar -->
                                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $aula->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- Botón para Eliminar -->
                                <form action="{{ route('aulas.destroy', $aula) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Eliminar esta aula?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>

                                </form>
                            </td>
                        </tr>

                        <!-- Modal para Ver Detalles -->
                        <div class="modal fade" id="detailsModal{{ $aula->id }}" tabindex="-1"
                            aria-labelledby="detailsModalLabel{{ $aula->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title" id="detailsModalLabel{{ $aula->id }}">Detalles del Aula
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Nombre:</strong> {{ $aula->nombre }}</p>
                                        <p><strong>Descripción:</strong> {{ $aula->descripcion ?? 'N/A' }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary shadow-sm"
                                            data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                       <!-- Modal para Editar Aula -->
                       <div class="modal fade" id="editModal{{ $aula->id }}" tabindex="-1"
                        aria-labelledby="editModalLabel{{ $aula->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content border-0 shadow-lg rounded-4">
                                <div class="modal-header bg-warning text-dark rounded-top">
                                    <h5 class="modal-title"><i class="fas fa-edit"></i> Editar Aula</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('aulas.update', $aula) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body bg-light">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="nombre" class="form-label"><i class="fas fa-door-open"></i> Nombre</label>
                                                    <input type="text" name="nombre" id="nombre" class="form-control"
                                                        value="{{ $aula->nombre }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="descripcion" class="form-label"><i class="fas fa-align-left"></i> Descripción</label>
                                                    <textarea name="descripcion" id="descripcion" class="form-control">{{ $aula->descripcion }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
