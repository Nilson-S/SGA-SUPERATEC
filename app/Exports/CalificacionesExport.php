<?php

namespace App\Exports;

use App\Models\Calificacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class CalificacionesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
     * Obtiene la colección de datos de calificaciones.
     */
    public function collection()
    {
        return Calificacion::with('alumno', 'curso')->get()->map(function ($calificacion, $index) {
            return [
                '#' => $index + 1, // Número de fila
                'Nombre' => $calificacion->alumno->nombres,
                'Apellido' => $calificacion->alumno->apellidos,
                'Cédula' => $calificacion->alumno->cedula,
                'Fecha de Nacimiento' => $calificacion->alumno->fecha_nacimiento,
                'Género' => $calificacion->alumno->genero,
                'Grado de Instrucción' => $calificacion->alumno->grado_instruccion,
                'Dirección' => $calificacion->alumno->direccion,
                'Teléfono' => $calificacion->alumno->telefono,
                'Correo Electrónico' => $calificacion->alumno->correo,
                'Curso' => $calificacion->curso->nombre,
                'Calificación' => $calificacion->calificacion,
                'Fecha de Registro' => $calificacion->created_at->format('d/m/Y'),
            ];
        });
    }

    /**
     * Encabezados de la tabla en Excel.
     */
    public function headings(): array
    {
        return [
            '#',
            'Nombre',
            'Apellido',
            'Cédula',
            'Fecha de Nacimiento',
            'Género',
            'Grado de Instrucción',
            'Dirección',
            'Teléfono',
            'Correo Electrónico',
            'Curso',
            'Calificación',
            'Fecha de Registro'
        ];
    }

    /**
     * Ajusta el estilo de la hoja de Excel.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $columnCount = count($this->headings()); // Contamos cuántas columnas hay
                $lastColumn = chr(64 + $columnCount); // Convertimos el número a letra (ej: 13 -> M)
                $lastRow = $sheet->getHighestRow() + 2; // Fila después de los datos para los totales

                //  ENCABEZADOS de la tabla (Fila 1)
                $headerRange = "A1:{$lastColumn}1";
                $sheet->getStyle($headerRange)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '0073AA'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Aplicar bordes a todas las celdas con datos
                $sheet->getStyle("A1:{$lastColumn}{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Ajustar tamaño de columnas automáticamente
                foreach (range('A', $lastColumn) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                //  Cálculo de Totales
                $totalAlumnos = Calificacion::count();
                $totalAprobados = Calificacion::where('calificacion', '>=', 10)->count();
                $totalReprobados = Calificacion::where('calificacion', '<', 10)->count();
                $totalMasculinos = Calificacion::whereHas('alumno', function ($q) {
                    $q->where('genero', 'Masculino');
                })->count();
                $totalFemeninos = Calificacion::whereHas('alumno', function ($q) {
                    $q->where('genero', 'Femenino');
                })->count();

                //  Agregar los totales al final de la tabla
                $totalsRow = $lastRow + 1;
                $totals = [
                    "Total Alumnos Inscritos:" => $totalAlumnos,
                    "Total Alumnos Aprobados:" => $totalAprobados,
                    "Total Alumnos Reprobados:" => $totalReprobados,
                    "Total Alumnos Masculinos:" => $totalMasculinos,
                    "Total Alumnos Femeninos:" => $totalFemeninos,
                ];

                // Combinar celdas y agregar valores
                $rowIndex = $totalsRow;
                foreach ($totals as $key => $value) {
                    $sheet->mergeCells("A{$rowIndex}:J{$rowIndex}"); // Unimos celdas de A hasta J
                    $sheet->setCellValue("A{$rowIndex}", $key);
                    $sheet->setCellValue("K{$rowIndex}", $value); // Valor en la columna K
                    $rowIndex++;
                }

                //  Estilo de los totales
                $sheet->getStyle("A{$totalsRow}:K" . ($rowIndex - 1))->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                    ],
                ]);

                // Estilo para los valores numéricos en los totales
                $sheet->getStyle("K{$totalsRow}:K" . ($rowIndex - 1))->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
            },
        ];
    }
}
