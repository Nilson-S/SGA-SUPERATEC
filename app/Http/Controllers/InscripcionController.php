<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Curso;
use App\Models\Horario;
use App\Models\Inscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InscripcionController extends Controller
{
    public function index(Request $request)
    {
        $query = Inscripcion::with(['alumno', 'curso']);

        // Filtrar por nombre o cédula del alumno
        if ($request->filled('search')) {
            $query->whereHas('alumno', function ($q) use ($request) {
                $q->where('nombres', 'like', '%' . $request->search . '%')
                    ->orWhere('apellidos', 'like', '%' . $request->search . '%')
                    ->orWhere('cedula', 'like', '%' . $request->search . '%');
            });
        }

        // Filtrar por curso
        if ($request->filled('curso_id')) {
            $query->where('curso_id', $request->curso_id);
        }

        // Filtrar por fecha de inscripción (rango)
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha_inscripcion', [$request->fecha_inicio, $request->fecha_fin]);
        }

        // Filtrar por método de pago
        if ($request->filled('metodo_pago')) {
            $query->where('metodo_pago', $request->metodo_pago);
        }

        // Filtrar por monto pagado (rango)
        if ($request->filled('monto_min') && $request->filled('monto_max')) {
            $query->whereBetween('monto_pago', [$request->monto_min, $request->monto_max]);
        }

        $inscripciones = $query->get();
        $alumnos = Alumno::all();
        $cursos = Curso::all();

        return view('inscripciones.index', compact('inscripciones', 'alumnos', 'cursos'));
    }

    public function create()
    {
        $alumnos = Alumno::all();
        $cursos = Curso::with('horarios')->get(); // Obtener cursos con horarios asociados

        return view('inscripciones.create', compact('alumnos', 'cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'curso_id' => 'required|exists:cursos,id',
            'fecha_inscripcion' => 'required|date',
            'monto_pago' => 'nullable|numeric',
            'metodo_pago' => 'nullable|in:Transferencia Bancaria,Efectivo Bs,Efectivo USD',
            'fecha_pago' => 'nullable|date',
        ]);

        Inscripcion::create($request->all());

        return redirect()->route('inscripciones.index')->with('success', 'Inscripción registrada correctamente.');
    }

    public function update(Request $request, Inscripcion $inscripcione)
    {
        try {
            $request->validate([
                'alumno_id' => 'required|exists:alumnos,id',
                'curso_id' => 'required|exists:cursos,id',
                'fecha_inscripcion' => 'required|date',
                'monto_pago' => 'nullable|numeric',
                'metodo_pago' => 'nullable|in:Transferencia Bancaria,Efectivo Bs,Efectivo USD',
                'fecha_pago' => 'nullable|date',
            ]);

            $inscripcione->update($request->all());

            return redirect()->route('inscripciones.index')->with('success', 'Inscripción actualizada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar la inscripción: ' . $e->getMessage());
            return redirect()->route('inscripciones.index')->with('error', 'Ocurrió un error al actualizar la inscripción.');
        }
    }

    public function destroy(Inscripcion $inscripcione)
    {
        try {
            $inscripcione->delete();
            return redirect()->route('inscripciones.index')->with('success', 'Inscripción eliminada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar la inscripción: ' . $e->getMessage());
            return redirect()->route('inscripciones.index')->with('error', 'No se pudo eliminar la inscripción.');
        }
    }
    public function marcarComoPagado($id)
    {
        $inscripcion = Inscripcion::findOrFail($id);

        // Asignar el costo del curso como monto pagado
        $monto_curso = $inscripcion->curso->costo;

        $inscripcion->update([
            'monto_pago' => $monto_curso, // Se coloca el costo del curso
            'fecha_pago' => now() // Se registra la fecha actual
        ]);

        return redirect()->route('inscripciones.index')->with('success', 'Inscripción marcada como pagada.');
    }
    public function historial(Alumno $alumno)
    {
        // Obtener todas las inscripciones del alumno con los datos del curso
        $inscripciones = $alumno->inscripciones()->with('curso')->orderBy('fecha_inscripcion', 'desc')->get();

        return view('inscripciones.historial', compact('alumno', 'inscripciones'));
    }

    public function obtenerHorariosCurso($curso_id)
    {
        $horarios = Horario::where('curso_id', $curso_id)->with('aula')->get();

        return response()->json($horarios->map(function ($horario) {
            return [
                'dias' => implode(', ', array_map(function ($dia) {
                    return $this->traducirDia($dia);
                }, explode(',', $horario->dias))),
                'hora_inicio' => date('h:i A', strtotime($horario->hora_inicio)),
                'hora_fin' => date('h:i A', strtotime($horario->hora_fin)),
                'aula' => $horario->aula->nombre ?? 'N/A'
            ];
        }));
    }

    /**
     *  Función auxiliar para traducir abreviaturas de días a nombres completos
     */
    private function traducirDia($abreviatura)
    {
        $dias = [
            'L' => 'Lunes',
            'M' => 'Martes',
            'MI' => 'Miércoles',
            'J' => 'Jueves',
            'V' => 'Viernes',
            'S' => 'Sábado',
        ];
        return $dias[$abreviatura] ?? $abreviatura;
    }
}
