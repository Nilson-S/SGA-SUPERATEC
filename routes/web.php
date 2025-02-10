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
use App\Exports\CalificacionesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\CertificadoController;

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
    Route::get('facilitadores/{facilitador}/horarios', [FacilitadorController::class, 'verHorarios'])->name('facilitadores.horarios');


    // Rutas para Cursos
    Route::resource('cursos', CursoController::class);

    // Rutas para Talleres
    Route::resource('talleres', TallerController::class);

    // Rutas para Calificaciones 
    Route::resource('calificaciones', CalificacionController::class)->except(['show']);
    Route::get('/calificaciones/cursos/{alumno}', [CalificacionController::class, 'obtenerCursosAlumno']);
    Route::get('/alumnos/{alumno}/historial-calificaciones', [CalificacionController::class, 'historial'])
    ->name('calificaciones.historial');
    Route::get('calificaciones/export', [CalificacionController::class, 'export'])->name('calificaciones.export');

    // Rutas para Inscripciones
    Route::resource('inscripciones', InscripcionController::class);
    Route::patch('/inscripciones/{id}/pago', [InscripcionController::class, 'marcarComoPagado'])->name('inscripciones.marcarPagado');
    Route::get('/inscripciones/historial/{alumno}', [InscripcionController::class, 'historial'])
    ->name('inscripciones.historial');
    Route::get('inscripciones/horarios-curso/{curso_id}', [InscripcionController::class, 'obtenerHorariosCurso']);


    // Rutas para Estadísticas
    Route::get('estadisticas', [EstadisticaController::class, 'index'])->name('estadisticas.index');
    Route::get('/estadisticas/filtrar', [EstadisticaController::class, 'filtrarEstadisticas'])->name('estadisticas.filtrar');

    // Rutas para los Horarios
    Route::resource('horarios', HorarioController::class);
    Route::get('horarios/facilitador/{curso_id}', [HorarioController::class, 'obtenerFacilitador']);
    Route::get('horarios/detalles-curso/{curso_id}', [HorarioController::class, 'obtenerDetallesCurso']);



    // Rutas para Usuarios Administradores
    Route::resource('users', UserController::class);

    // Rutas para Aulas
    Route::resource('aulas', AulaController::class);

    // Rutas para Certidicados
    Route::get('/certificado/{id}', [CertificadoController::class, 'generarCertificado'])->name('certificado.pdf');
    
});
