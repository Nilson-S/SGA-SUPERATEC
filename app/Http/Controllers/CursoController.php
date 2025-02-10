<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Aula;
use App\Models\Facilitador;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        $query = Curso::query();

        // Filtro por nombre del curso
        if ($request->filled('search')) {
            $query->where('nombre', 'LIKE', '%' . $request->search . '%');
        }

        // Filtro por facilitador
        if ($request->filled('facilitador_id')) {
            $query->where('facilitador_id', $request->facilitador_id);
        }

        // Filtro por aula
        if ($request->filled('aula_id')) {
            $query->where('aula_id', $request->aula_id);
        }

        // Obtener los cursos filtrados
        $cursos = $query->paginate(6);

        // Pasar los datos necesarios a la vista
        $facilitadores = Facilitador::all();
        $aulas = Aula::all();

        return view('cursos.index', compact('cursos', 'facilitadores', 'aulas'));
    }

    public function create()
    {
        $aulas = Aula::all();
        $facilitadores = Facilitador::all();
        return view('cursos.create', compact('aulas', 'facilitadores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'costo' => 'required|numeric',
            'duracion_horas' => 'required|numeric',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'aula_id' => 'required|exists:aulas,id',
            'facilitador_id' => 'required|exists:facilitadores,id',
        ]);

        Curso::create($request->all());

        return redirect()->route('cursos.index')->with('success', 'Curso registrado correctamente.');
    }

    public function show($id)
    {
        $curso = Curso::with(['facilitador', 'aula', 'inscripciones.alumno', 'horarios'])->findOrFail($id);
        
        return view('cursos.show', compact('curso'));
    }
    

    public function edit(Curso $curso)
    {
        $aulas = Aula::all();
        $facilitadores = Facilitador::all();
        return view('cursos.edit', compact('curso', 'aulas', 'facilitadores'));
    }

    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'costo' => 'required|numeric',
            'duracion_horas' => 'required|numeric',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'aula_id' => 'required|exists:aulas,id',
            'facilitador_id' => 'required|exists:facilitadores,id',
        ]);

        $curso->update($request->all());

        return redirect()->route('cursos.index')->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy(Curso $curso)
    {
        $curso->delete();
        return redirect()->route('cursos.index')->with('success', 'Curso eliminado correctamente.');
    }
}
