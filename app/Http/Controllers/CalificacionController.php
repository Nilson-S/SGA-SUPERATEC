<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Calificacion;
use App\Models\Curso;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CalificacionesExport;

class CalificacionController extends Controller
{
    public function index(Request $request)
    {
        $query = Calificacion::with(['alumno', 'curso']);

        //  Filtro por nombre del alumno o cédula
        if ($request->filled('search')) {
            $query->whereHas('alumno', function ($q) use ($request) {
                $q->where('nombres', 'like', '%' . $request->search . '%')
                    ->orWhere('apellidos', 'like', '%' . $request->search . '%')
                    ->orWhere('cedula', 'like', '%' . $request->search . '%');
            });
        }

        //  Filtro por curso
        if ($request->filled('curso_id')) {
            $query->where('curso_id', $request->curso_id);
        }

        // Filtro por estado de aprobación
        if ($request->filled('estado')) {
            if ($request->estado == 'aprobado') {
                $query->where('calificacion', '>=', 10);
            } elseif ($request->estado == 'reprobado') {
                $query->where('calificacion', '<', 10);
            }
        }



        //  Aplicar paginación (6 resultados por página)
        $calificaciones = $query->paginate(6);

        //  Pasar los cursos para el filtro
        $cursos = Curso::all();

        return view('calificaciones.index', compact('calificaciones', 'cursos'));
    }


    public function export()
    {
        return Excel::download(new CalificacionesExport, 'calificaciones.xlsx');
    }

    public function create()
    {
        $alumnos = Alumno::all();
        $cursos = Curso::all();
        return view('calificaciones.create', compact('alumnos', 'cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'curso_id' => 'required|exists:cursos,id',
            'calificacion' => 'required|numeric|min:0|max:20',
        ]);

        Calificacion::create($request->all());

        return redirect()->route('calificaciones.index')->with('success', 'Calificación registrada correctamente.');
    }

    public function edit(Calificacion $calificacion)
    {
        $alumnos = Alumno::all();
        $cursos = Curso::all();
        return view('calificaciones.edit', compact('calificacion', 'alumnos', 'cursos'));
    }

    public function update(Request $request, Calificacion $calificacione)
    {
        $request->validate([
            'calificacion' => 'required|numeric|min:0|max:20',
        ]);

        $calificacione->update(['calificacion' => $request->calificacion]);

        return redirect()->route('calificaciones.index')->with('success', 'Calificación actualizada correctamente.');
    }

    public function obtenerCursosAlumno($alumno_id)
    {
        // Obtener los cursos en los que el alumno está inscrito
        $cursos = Curso::whereHas('inscripciones', function ($query) use ($alumno_id) {
            $query->where('alumno_id', $alumno_id);
        })->get();

        return response()->json($cursos);
    }
    public function historial($alumno_id)
    {
        // Obtener el alumno con sus calificaciones y cursos
        $alumno = Alumno::with(['calificaciones.curso'])->findOrFail($alumno_id);

        // Obtener calificaciones ordenadas por fecha más reciente
        $calificaciones = $alumno->calificaciones()->with('curso')->orderBy('created_at', 'desc')->paginate(6);

        return view('calificaciones.historial', compact('alumno', 'calificaciones'));
    }

    public function destroy(Calificacion $calificacione)
    {
        $calificacione->delete();
        return redirect()->route('calificaciones.index')->with('success', 'Calificación eliminada correctamente.');
    }
}
