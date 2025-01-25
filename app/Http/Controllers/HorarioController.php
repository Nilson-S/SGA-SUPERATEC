<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Curso;
use App\Models\Taller;
use App\Models\Facilitador;
use App\Models\Aula;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index()
    {
        $horarios = Horario::with(['curso', 'taller', 'facilitador', 'aula'])->get();
        return view('horarios.index', compact('horarios'));
    }

    public function create()
    {
        $cursos = Curso::all();
        $talleres = Taller::all();
        $facilitadores = Facilitador::all();
        $aulas = Aula::all();

        return view('horarios.create', compact('cursos', 'talleres', 'facilitadores', 'aulas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'curso_id' => 'nullable|exists:cursos,id',
            'taller_id' => 'nullable|exists:talleres,id',
            'facilitador_id' => 'required|exists:facilitadores,id',
            'aula_id' => 'required|exists:aulas,id',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        Horario::create($request->all());

        return redirect()->route('horarios.index')->with('success', 'Horario registrado correctamente.');
    }

    public function destroy(Horario $horario)
    {
        $horario->delete();
        return redirect()->route('horarios.index')->with('success', 'Horario eliminado correctamente.');
    }
}
