<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'curso_id',
        'taller_id',
        'aula_id',
        'facilitador_id',
        'hora_inicio',
        'hora_fin',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function taller()
    {
        return $this->belongsTo(Taller::class);
    }

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    public function facilitador()
    {
        return $this->belongsTo(Facilitador::class);
    }
    
}
