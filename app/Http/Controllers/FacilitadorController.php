<?php

namespace App\Http\Controllers;

use App\Models\Facilitador;
use Illuminate\Http\Request;

class FacilitadorController extends Controller
{
    public function index()
    {
        $facilitadores = Facilitador::all();
        return view('facilitadores.index', compact('facilitadores'));
    }

    public function create()
    {
        return view('facilitadores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'cedula' => 'required|string|max:20|unique:facilitadores',
            'especialidad' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:255',
        ]);

        Facilitador::create($request->all());

        return redirect()->route('facilitadores.index')->with('success', 'Facilitador registrado correctamente.');
    }

    public function edit(Facilitador $facilitador)
    {
        return view('facilitadores.edit', compact('facilitador'));
    }

    public function update(Request $request, Facilitador $facilitador)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'cedula' => 'required|string|max:20|unique:facilitadores,cedula,' . $facilitador->id,
            'especialidad' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:255',
        ]);

        $facilitador->update($request->all());

        return redirect()->route('facilitadores.index')->with('success', 'Facilitador actualizado correctamente.');
    }

    public function destroy(Facilitador $facilitador)
    {
        $facilitador->delete();
        return redirect()->route('facilitadores.index')->with('success', 'Facilitador eliminado correctamente.');
    }
}
