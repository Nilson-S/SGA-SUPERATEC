<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facilitador extends Model
{
    use HasFactory;

    protected $table = 'facilitadores';

    protected $fillable = [
        'nombres',
        'apellidos',
        'cedula', // Agregado para que se pueda asignar masivamente
        'especialidad',
        'telefono',
        'correo',
    ];
}
