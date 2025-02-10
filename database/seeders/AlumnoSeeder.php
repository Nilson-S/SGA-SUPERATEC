<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alumno;

class AlumnoSeeder extends Seeder
{
    public function run(): void
    {
        Alumno::insert([
            [
                'nombres' => 'Carlos',
                'apellidos' => 'Pérez',
                'cedula' => 'V12345678',
                'fecha_nacimiento' => '2000-05-10',
                'genero' => 'Masculino',
                'grado_instruccion' => 'Universitario',
                'direccion' => 'Caracas, Venezuela',
                'telefono' => '0412-1234567',
                'correo' => 'carlos.perez@example.com',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'nombres' => 'María',
                'apellidos' => 'González',
                'cedula' => 'V87654321',
                'fecha_nacimiento' => '1998-07-25',
                'genero' => 'Femenino',
                'grado_instruccion' => 'Técnico Superior',
                'direccion' => 'Valencia, Venezuela',
                'telefono' => '0424-9876543',
                'correo' => 'maria.gonzalez@example.com',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'nombres' => 'José',
                'apellidos' => 'Rodríguez',
                'cedula' => 'V23456789',
                'fecha_nacimiento' => '1995-03-15',
                'genero' => 'Masculino',
                'grado_instruccion' => 'Bachillerato',
                'direccion' => 'Maracay, Venezuela',
                'telefono' => '0416-3456789',
                'correo' => 'jose.rodriguez@example.com',
                'created_at' => now(), 'updated_at' => now()
            ],
        ]);
    }
}
