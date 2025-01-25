<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Curso;
use App\Models\Inscripcion;
use Illuminate\Http\Request;

class InscripcionController extends Controller
{
    public function index()
    {
        $inscripciones = Inscripcion::with(['alumno', 'curso'])->get();
        return view('inscripciones.index', compact('inscripciones'));
    }

    public function create()
    {
        $alumnos = Alumno::all();
        $cursos = Curso::all();
        return view('inscripciones.create', compact('alumnos', 'cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'curso_id' => 'required|exists:cursos,id',
            'fecha_inscripcion' => 'required|date',
        ]);

        Inscripcion::create($request->all());

        return redirect()->route('inscripciones.index')->with('success', 'Inscripción realizada correctamente.');
    }

    public function destroy(Inscripcion $inscripcion)
    {
        $inscripcion->delete();
        return redirect()->route('inscripciones.index')->with('success', 'Inscripción eliminada correctamente.');
    }
}
