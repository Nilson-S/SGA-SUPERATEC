<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;

    protected $table = 'inscripciones';

    protected $fillable = [
        'alumno_id',
        'curso_id',
        'fecha_inscripcion',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
    public function taller()
    {
        return $this->belongsTo(Taller::class);
    }
}
