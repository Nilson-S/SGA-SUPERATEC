<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function index()
    {
        $alumnos = Alumno::all();
        return view('alumnos.index', compact('alumnos'));
    }

    public function create()
    {
        $grados = ['Básica', 'Bachiller', 'Universitaria'];
        return view('alumnos.create', compact('grados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'cedula' => 'required|string|max:20|unique:alumnos',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|string',
            'grado_instruccion' => 'required|string',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:15',
            'correo' => 'nullable|email|max:255',
        ]);

        Alumno::create($request->all());

        return redirect()->route('alumnos.index')->with('success', 'Alumno registrado correctamente.');
    }

    public function edit(Alumno $alumno)
    {
        $grados = ['Básica', 'Bachiller', 'Universitaria'];
        return view('alumnos.edit', compact('alumno', 'grados'));
    }

    public function update(Request $request, Alumno $alumno)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'cedula' => 'required|string|max:20|unique:alumnos,cedula,' . $alumno->id,
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|string',
            'grado_instruccion' => 'required|string',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:15',
            'correo' => 'nullable|email|max:255',
        ]);

        $alumno->update($request->all());

        return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado correctamente.');
    }

    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado correctamente.');
    }
}
