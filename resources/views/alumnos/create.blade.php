@extends('layouts.layout')

@section('title', 'Agregar Alumno')

@section('content')
<div class="container py-5">
    <h1 class="h3 text-center mb-4">Registrar Nuevo Alumno</h1>
    <form action="{{ route('alumnos.store') }}" method="POST" class="shadow p-4 rounded bg-light">
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
                        <i class="fas fa-id-card"></i> Cédula de Identidad
                    </label>
                    <input type="text" name="cedula" id="cedula" class="form-control" placeholder="Ingrese la cédula" required>
                </div>
                <div class="mb-3">
                    <label for="fecha_nacimiento" class="form-label">
                        <i class="fas fa-calendar-alt"></i> Fecha de Nacimiento
                    </label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="genero" class="form-label">
                        <i class="fas fa-venus-mars"></i> Género
                    </label>
                    <select name="genero" id="genero" class="form-control" required>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>
                </div>
            </div>

            <!-- Segunda columna -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="grado_instruccion" class="form-label">
                        <i class="fas fa-graduation-cap"></i> Grado de Instrucción
                    </label>
                    <select name="grado_instruccion" id="grado_instruccion" class="form-control" required>
                        @foreach($grados as $grado)
                        <option value="{{ $grado }}">{{ $grado }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="direccion" class="form-label">
                        <i class="fas fa-map-marker-alt"></i> Dirección
                    </label>
                    <textarea name="direccion" id="direccion" class="form-control" placeholder="Ingrese la dirección"></textarea>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">
                        <i class="fas fa-phone"></i> Teléfono
                    </label>
                    <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Ingrese el número de teléfono">
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
            <a href="{{ route('alumnos.index') }}" class="btn btn-secondary btn-lg shadow-sm">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
