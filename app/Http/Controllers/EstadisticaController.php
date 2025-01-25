<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Curso;
use App\Models\Taller;
use App\Models\Pago;

class EstadisticaController extends Controller
{
    public function index()
    {
        // Total de ingresos por cursos y talleres
        $ingresosPorCurso = Curso::with('inscripciones.pagos')
            ->get()
            ->map(function ($curso) {
                return [
                    'curso' => $curso->nombre,
                    'ingresos' => $curso->inscripciones->sum(fn($inscripcion) => $inscripcion->pagos->sum('monto')),
                ];
            });

        $ingresosPorTaller = Taller::with('inscripciones.pagos')
            ->get()
            ->map(function ($taller) {
                return [
                    'taller' => $taller->nombre,
                    'ingresos' => $taller->inscripciones->sum(fn($inscripcion) => $inscripcion->pagos->sum('monto')),
                ];
            });

        // Total de alumnos inscritos por curso y taller
        $alumnosPorCurso = Curso::withCount('inscripciones')->get();
        $alumnosPorTaller = Taller::withCount('inscripciones')->get();

        return view('estadisticas.index', compact('ingresosPorCurso', 'ingresosPorTaller', 'alumnosPorCurso', 'alumnosPorTaller'));
    }
}
