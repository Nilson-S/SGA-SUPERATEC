@extends('layouts.layout')

@section('title', 'Agregar Facilitador')

@section('content')
<div class="container py-5">
    <h1 class="h3 text-center mb-4">Registrar Nuevo Facilitador</h1>
    <form action="{{ route('facilitadores.store') }}" method="POST" class="shadow p-4 rounded bg-light">
        @csrf
        <div class="row">
            <!-- Primera columna -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nombres" class="form-label">
                        <i class="fas fa-user"></i> Nombres
                    </label>
                    <input type="text" name="nombres" id="nombres" class="form-control" placeholder="Ingrese los nombres" required>
                </div>
                <div class="mb-3">
                    <label for="apellidos" class="form-label">
                        <i class="fas fa-user-tag"></i> Apellidos
                    </label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Ingrese los apellidos" required>
                </div>
                <div class="mb-3">
                    <label for="cedula" class="form-label">
                        <i class="fas fa-id-card"></i> Cédula
                    </label>
                    <input type="text" name="cedula" id="cedula" class="form-control" placeholder="Ingrese la cédula" required>
                </div>
            </div>

            <!-- Segunda columna -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="especialidad" class="form-label">
                        <i class="fas fa-briefcase"></i> Especialidad
                    </label>
                    <input type="text" name="especialidad" id="especialidad" class="form-control" placeholder="Ingrese la especialidad" required>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">
                        <i class="fas fa-phone"></i> Teléfono
                    </label>
                    <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Ingrese el teléfono">
                </div>
                <div class="mb-3">
                    <label for="correo" class="form-label">
                        <i class="fas fa-envelope"></i> Correo Electrónico
                    </label>
                    <input type="email" name="correo" id="correo" class="form-control" placeholder="Ingrese el correo electrónico">
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success btn-lg shadow-sm me-2">
                <i class="fas fa-save"></i> Registrar
            </button>
            <a href="{{ route('facilitadores.index') }}" class="btn btn-secondary btn-lg shadow-sm">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
