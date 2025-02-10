@extends('layouts.layout')

@section('title', 'Agregar Aula')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header  text-dark text-center rounded-top">
            <h2 class="mb-0"><i class="fas fa-school"></i> Registrar Nueva Aula</h2>
        </div>
        <div class="card-body bg-light p-4">
            <form action="{{ route('aulas.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Nombre del Aula -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nombre" class="form-label"><i class="fas fa-door-open"></i> Nombre del Aula</label>
                            <input type="text" name="nombre" id="nombre" class="form-control border-primary shadow-sm" 
                                placeholder="Ingrese el nombre del aula" required>
                        </div>
                    </div>
                    
                    <!-- Descripción del Aula -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="descripcion" class="form-label"><i class="fas fa-align-left"></i> Descripción</label>
                            <textarea name="descripcion" id="descripcion" class="form-control border-primary shadow-sm" 
                                placeholder="Ingrese una breve descripción"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg shadow-sm me-2">
                        <i class="fas fa-save"></i> Registrar Aula
                    </button>
                    <a href="{{ route('aulas.index') }}" class="btn btn-secondary btn-lg shadow-sm">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
