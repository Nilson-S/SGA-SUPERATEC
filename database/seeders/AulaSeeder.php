<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aula;

class AulaSeeder extends Seeder
{
    public function run()
    {
        Aula::insert([
            ['nombre' => 'Aula 1', 'descripcion' => 'Aula principal 1'],
            ['nombre' => 'Aula 2', 'descripcion' => 'Aula principal 2'],
            ['nombre' => 'Aula de Formación Humana', 'descripcion' => 'Espacio dedicado a actividades de formación humana'],
        ]);
    }
}
