<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'curso_id',
        'facilitador_id',
        'aula_id',
        'dias', 
        'hora_inicio',
        'hora_fin',
    ];
    

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    public function facilitador()
    {
        return $this->belongsTo(Facilitador::class);
    }

    // Accesor para formatear los días como array
    public function getDiasArrayAttribute()
    {
        return explode(',', $this->dias);
    }
}
