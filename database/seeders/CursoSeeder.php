<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curso;
use App\Models\Facilitador;
use App\Models\Aula;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        $facilitadores = Facilitador::pluck('id')->toArray(); // Obtener IDs de facilitadores
        $aulas = Aula::pluck('id')->toArray(); // Obtener IDs de aulas

        $cursos = [
            ['nombre' => 'Programación en Python', 'descripcion' => 'Curso introductorio de Python.', 'duracion_horas' => 40, 'fecha_inicio' => '2025-02-01', 'fecha_fin' => '2025-03-15', 'costo' => 50.00],
            ['nombre' => 'Excel Avanzado', 'descripcion' => 'Dominando macros y tablas dinámicas.', 'duracion_horas' => 30, 'fecha_inicio' => '2025-02-10', 'fecha_fin' => '2025-03-20', 'costo' => 30.00],
            ['nombre' => 'Oratoria y Comunicación', 'descripcion' => 'Mejora tus habilidades de hablar en público.', 'duracion_horas' => 25, 'fecha_inicio' => '2025-02-15', 'fecha_fin' => '2025-03-25', 'costo' => 25.00],
            ['nombre' => 'Inglés Básico', 'descripcion' => 'Fundamentos del idioma inglés.', 'duracion_horas' => 50, 'fecha_inicio' => '2025-02-05', 'fecha_fin' => '2025-04-01', 'costo' => 45.00],
            ['nombre' => 'Soporte Técnico en IT', 'descripcion' => 'Conceptos básicos de hardware y software.', 'duracion_horas' => 35, 'fecha_inicio' => '2025-02-20', 'fecha_fin' => '2025-04-10', 'costo' => 40.00],
            ['nombre' => 'Desarrollo Web con Laravel', 'descripcion' => 'Construye aplicaciones web con Laravel.', 'duracion_horas' => 60, 'fecha_inicio' => '2025-03-01', 'fecha_fin' => '2025-04-20', 'costo' => 60.00],
            ['nombre' => 'Emprendimiento Digital', 'descripcion' => 'Crea tu negocio en internet.', 'duracion_horas' => 20, 'fecha_inicio' => '2025-02-28', 'fecha_fin' => '2025-04-05', 'costo' => 20.00],
        ];

        foreach ($cursos as $curso) {
            Curso::create(array_merge($curso, [
                'facilitador_id' => $facilitadores[array_rand($facilitadores)], // Asigna un facilitador aleatorio
                'aula_id' => $aulas ? $aulas[array_rand($aulas)] : null, // Asigna un aula aleatoria o NULL
            ]));
        }
    }
}
