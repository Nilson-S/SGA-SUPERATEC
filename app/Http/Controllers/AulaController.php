<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aula;

class AulaController extends Controller
{
    public function index()
    {
        $aulas = Aula::all();
        return view('aulas.index', compact('aulas'));
    }

    public function create()
    {
        return view('aulas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        Aula::create($request->all());

        return redirect()->route('aulas.index')->with('success', 'Aula registrada correctamente.');
    }

    public function update(Request $request, Aula $aula)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $aula->update($request->all());

        return redirect()->route('aulas.index')->with('success', 'Aula actualizada correctamente.');
    }

    public function show($id)
    {
        $aula = Aula::with('cursos')->findOrFail($id);
        return view('aulas.show', compact('aula'));
    }


    public function destroy(Aula $aula)
    {
        $aula->delete();
        return redirect()->route('aulas.index')->with('success', 'Aula eliminada correctamente.');
    }
}
