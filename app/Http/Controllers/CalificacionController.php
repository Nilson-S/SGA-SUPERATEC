<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Calificacion;
use App\Models\Curso;
use Illuminate\Http\Request;

class CalificacionController extends Controller
{
    public function index()
    {
        $calificaciones = Calificacion::with(['alumno', 'curso'])->get();
        return view('calificaciones.index', compact('calificaciones'));
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
            'nota' => 'required|numeric|min:0|max:20',
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

    public function update(Request $request, Calificacion $calificacion)
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'curso_id' => 'required|exists:cursos,id',
            'nota' => 'required|numeric|min:0|max:20',
        ]);

        $calificacion->update($request->all());

        return redirect()->route('calificaciones.index')->with('success', 'Calificación actualizada correctamente.');
    }

    public function destroy(Calificacion $calificacion)
    {
        $calificacion->delete();
        return redirect()->route('calificaciones.index')->with('success', 'Calificación eliminada correctamente.');
    }
}
