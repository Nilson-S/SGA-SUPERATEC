<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'cursos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'costo',
        'duracion_horas',
        'fecha_inicio',
        'fecha_fin',
        'aula_id',
        'facilitador_id',
    ];

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    public function facilitador()
    {
        return $this->belongsTo(Facilitador::class);
    }
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'curso_id');
    }
    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}
