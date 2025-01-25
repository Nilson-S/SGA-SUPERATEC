<?php

namespace App\Http\Controllers;

use App\Models\Taller;
use Illuminate\Http\Request;
use App\Models\Aula;

class TallerController extends Controller
{
    public function index()
    {
        $talleres = Taller::all();
        return view('talleres.index', compact('talleres'));
    }

    public function create()
    {
        $aulas = Aula::all(); // Obtén las aulas desde la base de datos
        return view('talleres.create', compact('aulas'));
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
            'aula' => 'required|string',
        ]);

        Taller::create($request->all());

        return redirect()->route('talleres.index')->with('success', 'Taller registrado correctamente.');
    }

    public function edit(Taller $taller)
    {
        $aulas = ['Aula 1', 'Aula 2', 'Aula de Formación Humana'];
        return view('talleres.edit', compact('taller', 'aulas'));
    }

    public function update(Request $request, Taller $taller)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'costo' => 'required|numeric',
            'duracion_horas' => 'required|numeric',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'aula' => 'required|string',
        ]);

        $taller->update($request->all());

        return redirect()->route('talleres.index')->with('success', 'Taller actualizado correctamente.');
    }

    public function destroy(Taller $taller)
    {
        $taller->delete();
        return redirect()->route('talleres.index')->with('success', 'Taller eliminado correctamente.');
    }
}
