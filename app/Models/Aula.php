<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;

    protected $table = 'aulas';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // Relación: Un aula puede tener muchos cursos
    public function cursos()
    {
        return $this->hasMany(Curso::class, 'aula_id');
    }
}
