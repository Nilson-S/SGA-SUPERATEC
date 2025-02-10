<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CertificadoController extends Controller
{
    public function generarCertificado($id)
    {
        // Obtener la calificación con su relación de alumno y curso
        $calificacion = Calificacion::with('alumno', 'curso')->findOrFail($id);

        // Verificar si el alumno aprobó
        if ($calificacion->calificacion < 10) {
            return redirect()->back()->with('error', 'Este estudiante no ha aprobado el curso.');
        }

        // Pasar datos a la vista del certificado
        $pdf = Pdf::loadView('certificados.certificado', compact('calificacion'));

        // Descargar el PDF con un nombre personalizado
        return $pdf->download("Certificado_{$calificacion->alumno->nombres}_{$calificacion->curso->nombre}.pdf");
    }
}
