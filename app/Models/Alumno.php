<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Alumno extends Model
{
    use HasFactory;

    protected $table = 'alumnos';

    protected $fillable = [
        'nombres',
        'apellidos',
        'cedula',
        'fecha_nacimiento',
        'genero',
        'grado_instruccion',
        'direccion',
        'telefono',
        'correo',
    ];

    // Accesor para calcular la edad dinámicamente
    public function getEdadAttribute()
    {
        return Carbon::parse($this->fecha_nacimiento)->age;
    }
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'alumno_id');
    }

    // Relación con Calificaciones
    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'alumno_id');
    }
}
