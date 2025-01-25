<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\FacilitadorController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\TallerController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\EstadisticaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AulaController;

// Redirigir la ruta raíz al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas del Login (públicas)
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Rutas protegidas con middleware 'auth'
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas para Alumnos
    Route::resource('alumnos', AlumnoController::class);

    // Rutas para Facilitadores
    Route::resource('facilitadores', FacilitadorController::class);

    // Rutas para Cursos
    Route::resource('cursos', CursoController::class);

    // Rutas para Talleres
    Route::resource('talleres', TallerController::class);

    // Rutas para Calificaciones (excepto show, edit y update)
    Route::resource('calificaciones', CalificacionController::class)->except(['show', 'edit', 'update']);

    // Rutas para Inscripciones
    Route::resource('inscripciones', InscripcionController::class);

    // Rutas para Pagos
    Route::resource('pagos', PagoController::class);

    // Rutas para Estadísticas
    Route::get('estadisticas', [EstadisticaController::class, 'index'])->name('estadisticas.index');

    // Rutas para los Horarios
    Route::resource('horarios', HorarioController::class);

    // Rutas para Usuarios Administradores
    Route::resource('users', UserController::class);

    // Rutas para Aulas
    Route::resource('aulas', AulaController::class);
    
});
