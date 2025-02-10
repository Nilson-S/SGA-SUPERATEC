<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Curso;
use App\Models\Facilitador;
use App\Models\Aula;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index(Request $request)
{
    $query = Horario::with(['curso', 'facilitador', 'aula']);

    //  Filtrar por Curso
    if ($request->filled('curso_id')) {
        $query->where('curso_id', $request->curso_id);
    }

    //  Filtrar por Facilitador
    if ($request->filled('facilitador_id')) {
        $query->where('facilitador_id', $request->facilitador_id);
    }

    //  Filtrar por Aula
    if ($request->filled('aula_id')) {
        $query->where('aula_id', $request->aula_id);
    }

    // Filtrar por Día
    if ($request->filled('dia')) {
        $query->where('dias', 'LIKE', '%' . $request->dia . '%');
    }

    //  paginación con 6 registros por página
    $horarios = $query->paginate(6);

    // Obtener datos para los filtros
    $cursos = Curso::all();
    $facilitadores = Facilitador::all();
    $aulas = Aula::all();

    return view('horarios.index', compact('horarios', 'cursos', 'facilitadores', 'aulas'));
}

    public function create()
    {
        $cursos = Curso::all();
        $aulas = Aula::all();
        return view('horarios.create', compact('cursos', 'aulas'));
    }

    public function obtenerDetallesCurso($curso_id)
    {
        $curso = Curso::with(['facilitador', 'aula'])->findOrFail($curso_id);

        return response()->json([
            'facilitador' => [
                'id' => $curso->facilitador->id ?? null,
                'nombre' => $curso->facilitador->nombres . ' ' . $curso->facilitador->apellidos ?? 'N/A'
            ],
            'aula' => [
                'id' => $curso->aula->id ?? null,
                'nombre' => $curso->aula->nombre ?? 'N/A'
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'aula_id' => 'required|exists:aulas,id',
            'dias' => 'required|array',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $diasString = implode(',', $request->dias);
        $curso = Curso::findOrFail($request->curso_id);
        $facilitador_id = $curso->facilitador_id;

        if ($this->validarConflicto($request, $diasString, $curso->id)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => "Conflicto de horarios detectado."]);
        }

        Horario::create([
            'curso_id' => $request->curso_id,
            'facilitador_id' => $facilitador_id,
            'aula_id' => $request->aula_id,
            'dias' => $diasString,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
        ]);

        return redirect()->route('horarios.index')->with('success', 'Horario registrado correctamente.');
    }

    public function edit($id)
    {
        $horario = Horario::findOrFail($id);
        $cursos = Curso::all();
        $aulas = Aula::all();

        return response()->json([
            'horario' => $horario,
            'cursos' => $cursos,
            'aulas' => $aulas
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'aula_id' => 'required|exists:aulas,id',
            'dias' => 'required|array',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $horario = Horario::findOrFail($id);
        $diasString = implode(',', $request->dias);
        $curso = Curso::findOrFail($request->curso_id);
        $facilitador_id = $curso->facilitador_id;

        if ($this->validarConflicto($request, $diasString, $curso->id, $id)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => "Conflicto de horarios detectado."]);
        }

        $horario->update([
            'curso_id' => $request->curso_id,
            'facilitador_id' => $facilitador_id,
            'aula_id' => $request->aula_id,
            'dias' => $diasString,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
        ]);

        return redirect()->route('horarios.index')->with('success', 'Horario actualizado correctamente.');
    }

    private function validarConflicto($request, $diasString, $curso_id, $horario_id = null)
    {
        $horariosExistentes = Horario::where('aula_id', $request->aula_id)
            ->where('curso_id', '!=', $curso_id)
            ->when($horario_id, function ($query) use ($horario_id) {
                return $query->where('id', '!=', $horario_id);
            })
            ->get();

        foreach ($horariosExistentes as $horario) {
            $diasExistentes = explode(',', $horario->dias);
            $diasConflicto = array_intersect($diasExistentes, explode(',', $diasString));

            if (!empty($diasConflicto) && (
                ($request->hora_inicio >= $horario->hora_inicio && $request->hora_inicio < $horario->hora_fin) ||
                ($request->hora_fin > $horario->hora_inicio && $request->hora_fin <= $horario->hora_fin) ||
                ($request->hora_inicio <= $horario->hora_inicio && $request->hora_fin >= $horario->hora_fin)
            )) {
                return true;
            }
        }

        return false;
    }

    public function destroy($id)
    {
        $horario = Horario::findOrFail($id);
        $horario->delete();
        return redirect()->route('horarios.index')->with('success', 'Horario eliminado correctamente.');
    }
}
