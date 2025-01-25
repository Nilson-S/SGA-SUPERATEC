<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{
    use HasFactory;

    protected $table = 'talleres';

    protected $fillable = [
        'nombre',
        'descripcion',
        'costo',
        'duracion_horas',
        'fecha_inicio',
        'fecha_fin',
        'aula',
    ];
    public function inscripciones()
{
    return $this->hasMany(Inscripcion::class);
}

}
