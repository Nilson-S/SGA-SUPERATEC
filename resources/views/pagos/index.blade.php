@extends('layouts.layout')

@section('title', 'Pagos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Pagos</h1>
    <a href="{{ route('pagos.create') }}" class="btn btn-primary">+ Nuevo Pago</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Alumno</th>
            <th>Curso</th>
            <th>Monto</th>
            <th>Método de Pago</th>
            <th>Fecha de Pago</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pagos as $pago)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $pago->alumno->nombres }} {{ $pago->alumno->apellidos }}</td>
            <td>{{ $pago->curso->nombre }}</td>
            <td>{{ $pago->monto }}</td>
            <td>{{ $pago->metodo_pago }}</td>
            <td>{{ $pago->fecha_pago }}</td>
            <td>
                <form action="{{ route('pagos.destroy', $pago) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este pago?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
