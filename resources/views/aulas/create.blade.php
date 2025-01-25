@extends('layouts.layout')

@section('title', 'Agregar Aula')

@section('content')
<div class="container py-5">
    <h1 class="h3 text-center mb-4">Registrar Nueva Aula</h1>
    <form action="{{ route('aulas.store') }}" method="POST" class="shadow p-4 rounded bg-light">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingrese el nombre del aula" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Ingrese una breve descripción"></textarea>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success btn-lg shadow-sm me-2">
                <i class="fas fa-save"></i> Registrar
            </button>
            <a href="{{ route('aulas.index') }}" class="btn btn-secondary btn-lg shadow-sm">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
