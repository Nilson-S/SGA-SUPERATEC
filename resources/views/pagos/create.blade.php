@extends('layouts.layout')
@section('title', 'Registrar Pago')

@section('content')
<h1 class="h3">Registrar Nuevo Pago</h1>

<form action="{{ route('pagos.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="alumno_id" class="form-label">Alumno</label>
        <select name="alumno_id" id="alumno_id" class="form-control" required>
            <option value="">Selecciona un alumno</option>
            @foreach($alumnos as $alumno)
            <option value="{{ $alumno->id }}">{{ $alumno->nombres }} {{ $alumno->apellidos }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="curso_id" class="form-label">Curso</label>
        <select name="curso_id" id="curso_id" class="form-control" required>
            <option value="">Selecciona un curso</option>
            @foreach($cursos as $curso)
            <option value="{{ $curso->id }}">{{ $curso->nombre }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="monto" class="form-label">Monto</label>
        <input type="number" name="monto" id="monto" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="metodo_pago" class="form-label">Método de Pago</label>
        <select name="metodo_pago" id="metodo_pago" class="form-control" required>
            <option value="">Selecciona un método de pago</option>
            <option value="Transferencia Bancaria">Transferencia Bancaria</option>
            <option value="Efectivo Bs">Efectivo Bs</option>
            <option value="Efectivo USD">Efectivo USD</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="fecha_pago" class="form-label">Fecha de Pago</label>
        <input type="date" name="fecha_pago" id="fecha_pago" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Registrar</button>
    <a href="{{ route('pagos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
