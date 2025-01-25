@extends('layouts.layout')

@section('title', 'Talleres')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Talleres Registrados</h1>
    <a href="{{ route('talleres.create') }}" class="btn btn-primary">+ Agregar Taller</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Costo</th>
            <th>Duración (hrs)</th>
            <th>Fechas</th>
            <th>Aula</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($talleres as $taller)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $taller->nombre }}</td>
            <td>{{ $taller->descripcion ?? 'N/A' }}</td>
            <td>${{ $taller->costo }}</td>
            <td>{{ $taller->duracion_horas }}</td>
            <td>{{ $taller->fecha_inicio }} - {{ $taller->fecha_fin }}</td>
            <td>{{ $taller->aula->nombre ?? 'N/A' }}</td>
            <td>
                <a href="{{ route('talleres.edit', $taller) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('talleres.destroy', $taller) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este taller?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
