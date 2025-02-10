<?php

namespace App\Http\Controllers;

use App\Models\Facilitador;
use App\Models\Horario;
use Illuminate\Http\Request;

class FacilitadorController extends Controller
{
    public function index(Request $request)
{
    // Cargar los cursos impartidos por cada facilitador
    $query = Facilitador::with('cursos');

    // Filtrar por cédula si se proporciona un parámetro de búsqueda
    if ($request->has('search')) {
        $query->where('cedula', 'like', '%' . $request->search . '%');
    }

    $facilitadores = $query->paginate(10);

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

    public function update(Request $request, $id)
    {
        $facilitador = Facilitador::findOrFail($id);

        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'cedula' => 'required|string|max:20|unique:facilitadores,cedula,' . $facilitador->id,
            'especialidad' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:255',
        ]);

        $facilitador->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'cedula' => $request->cedula,
            'especialidad' => $request->especialidad,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
        ]);

        return redirect()->route('facilitadores.index')->with('success', 'Facilitador actualizado correctamente.');
    }

    public function verHorarios(Facilitador $facilitador)
    {
        // Obtener horarios del facilitador
        $horarios = Horario::with(['curso', 'aula'])
            ->where('facilitador_id', $facilitador->id)
            ->get();

        return view('facilitadores.horarios_facilitador', compact('facilitador', 'horarios'));
    }

    public function destroy(Facilitador $facilitador)
    {
        $facilitador->delete();
        return redirect()->route('facilitadores.index')->with('success', 'Facilitador eliminado correctamente.');
    }
}
