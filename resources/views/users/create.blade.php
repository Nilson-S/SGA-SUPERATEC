@extends('layouts.layout')

@section('title', 'Agregar Usuario')

@section('content')
<div class="container py-5">
    <h1 class="h3 text-center mb-4">Registrar Nuevo Usuario Administrador</h1>
    <form action="{{ route('users.store') }}" method="POST" class="shadow p-4 rounded bg-light">
        @csrf
        <div class="row">
            <!-- Primera columna -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">
                        <i class="fas fa-user"></i> Nombre
                    </label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Ingrese el nombre" required>
                </div>
                <div class="mb-3">
                    <label for="apellido" class="form-label">
                        <i class="fas fa-user-tag"></i> Apellido
                    </label>
                    <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Ingrese el apellido" required>
                </div>
                <div class="mb-3">
                    <label for="cedula" class="form-label">
                        <i class="fas fa-id-card"></i> Cédula de Identidad
                    </label>
                    <input type="text" name="cedula" id="cedula" class="form-control" placeholder="Ingrese la cédula" required>
                </div>
                <div class="mb-3">
                    <label for="genero" class="form-label">
                        <i class="fas fa-venus-mars"></i> Género
                    </label>
                    <select name="genero" id="genero" class="form-select" required>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                    </select>
                </div>
            </div>

            <!-- Segunda columna -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="fecha_nacimiento" class="form-label">
                        <i class="fas fa-calendar-alt"></i> Fecha de Nacimiento
                    </label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i> Correo Electrónico
                    </label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Ingrese el correo electrónico" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i> Contraseña
                    </label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Ingrese la contraseña" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">
                        <i class="fas fa-lock"></i> Confirmar Contraseña
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirme la contraseña" required>
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success btn-lg shadow-sm me-2">
                <i class="fas fa-save"></i> Registrar
            </button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-lg shadow-sm">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
