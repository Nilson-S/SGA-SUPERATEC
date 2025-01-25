<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'apellido',
        'cedula',
        'genero',
        'fecha_nacimiento',
        'email',
        'password',
    ];

    // Accesor para calcular la edad automáticamente
    public function getEdadAttribute()
    {
        return $this->fecha_nacimiento ? Carbon::parse($this->fecha_nacimiento)->age : null;
    }
}
