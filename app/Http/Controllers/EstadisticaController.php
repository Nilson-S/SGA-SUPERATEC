<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Calificacion;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EstadisticaController extends Controller
{
    public function index()
    {
        //  Total de inscripciones por curso
        $inscripcionesPorCurso = Inscripcion::selectRaw('curso_id, COUNT(*) as total')
            ->groupBy('curso_id')
            ->with('curso')
            ->get();

        //  Inscripciones por mes (últimos 12 meses)
        $inscripcionesPorMes = Inscripcion::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mes, COUNT(*) as total')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        //  Distribución de alumnos por género
        $distribucionGenero = Inscripcion::with('alumno')
            ->get()
            ->groupBy('alumno.genero')
            ->map->count();

        //  Estadísticas de calificaciones: Aprobados vs Reprobados por Curso
        $calificacionesPorCurso = Calificacion::selectRaw('curso_id, 
                SUM(CASE WHEN calificacion >= 10 THEN 1 ELSE 0 END) as aprobados,
                SUM(CASE WHEN calificacion < 10 THEN 1 ELSE 0 END) as reprobados')
            ->groupBy('curso_id')
            ->with('curso')
            ->get();
        //  Ingresos por curso
        $ingresosPorCurso = Inscripcion::selectRaw('curso_id, SUM(monto_pago) as total_ingresos')
            ->groupBy('curso_id')
            ->with('curso')
            ->get();

        // Estadísticas en tiempo real
        $totalIngresos = Inscripcion::sum('monto_pago');
        $totalInscripciones = Inscripcion::count();
        $inscripcionesHoy = Inscripcion::whereDate('created_at', Carbon::today())->count();
        $totalAlumnos = Inscripcion::distinct('alumno_id')->count('alumno_id');

        return view('estadisticas.index', compact(
            'inscripcionesPorCurso',
            'inscripcionesPorMes',
            'distribucionGenero',
            'calificacionesPorCurso',
            'totalInscripciones',
            'inscripcionesHoy',
            'totalAlumnos',
            'ingresosPorCurso',
            'totalIngresos'
        ));
    }
}
