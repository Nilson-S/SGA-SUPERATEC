<?php
namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Curso;
use App\Models\Pago;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::with(['alumno', 'curso'])->get();
        return view('pagos.index', compact('pagos'));
    }

    public function create()
    {
        $alumnos = Alumno::all();
        $cursos = Curso::all();
        return view('pagos.create', compact('alumnos', 'cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'curso_id' => 'required|exists:cursos,id',
            'monto' => 'required|numeric|min:0',
            'metodo_pago' => 'required|in:Transferencia Bancaria,Efectivo Bs,Efectivo USD',
            'fecha_pago' => 'required|date',
        ]);

        Pago::create($request->all());

        return redirect()->route('pagos.index')->with('success', 'Pago registrado correctamente.');
    }

    public function destroy(Pago $pago)
    {
        $pago->delete();
        return redirect()->route('pagos.index')->with('success', 'Pago eliminado correctamente.');
    }
}
