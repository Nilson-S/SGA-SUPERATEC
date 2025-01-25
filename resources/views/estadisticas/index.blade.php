@extends('layouts.layout')

@section('content')
<div class="container">
    <h1>Estadísticas del Sistema</h1>

    <div class="row">
        <div class="col-md-6">
            <h3>Ingresos por Cursos</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Ingresos (USD)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ingresosPorCurso as $curso)
                        <tr>
                            <td>{{ $curso['curso'] }}</td>
                            <td>${{ number_format($curso['ingresos'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-md-6">
            <h3>Ingresos por Talleres</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Taller</th>
                        <th>Ingresos (USD)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ingresosPorTaller as $taller)
                        <tr>
                            <td>{{ $taller['taller'] }}</td>
                            <td>${{ number_format($taller['ingresos'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <h3>Alumnos Inscritos por Curso</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Total de Inscritos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alumnosPorCurso as $curso)
                        <tr>
                            <td>{{ $curso->nombre }}</td>
                            <td>{{ $curso->inscripciones_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-md-6">
            <h3>Alumnos Inscritos por Taller</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Taller</th>
                        <th>Total de Inscritos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alumnosPorTaller as $taller)
                        <tr>
                            <td>{{ $taller->nombre }}</td>
                            <td>{{ $taller->inscripciones_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
