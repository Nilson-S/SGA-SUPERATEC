<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facilitador;

class FacilitadorSeeder extends Seeder
{
    public function run(): void
    {
        Facilitador::insert([
            [
                'nombres' => 'Luis',
                'apellidos' => 'Martínez',
                'cedula' => 'V56789012',
                'especialidad' => 'Programación',
                'telefono' => '0412-5678901',
                'correo' => 'luis.martinez@example.com',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'nombres' => 'Ana',
                'apellidos' => 'Fernández',
                'cedula' => 'V67890123',
                'especialidad' => 'Idiomas',
                'telefono' => '0424-6789012',
                'correo' => 'ana.fernandez@example.com',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'nombres' => 'Ricardo',
                'apellidos' => 'Gómez',
                'cedula' => 'V78901234',
                'especialidad' => 'Emprendimiento',
                'telefono' => '0416-7890123',
                'correo' => 'ricardo.gomez@example.com',
                'created_at' => now(), 'updated_at' => now()
            ],
        ]);
    }
}
