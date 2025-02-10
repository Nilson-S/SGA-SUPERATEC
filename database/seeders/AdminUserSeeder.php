<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'apellido' => 'SuperaTec',
            'cedula' => '12345678',
            'genero' => 'Masculino', 
            'fecha_nacimiento' => '1990-01-01',
            'email' => 'admin@superatec.com',
            'password' => Hash::make('admin123'), 
        ]);
    }
}
