<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatabaseStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Tabla de alumnos
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('cedula', 20)->unique();
            $table->date('fecha_nacimiento');
            $table->enum('genero', ['Masculino', 'Femenino']);
            $table->string('grado_instruccion');
            $table->text('direccion');
            $table->string('telefono');
            $table->string('correo')->unique();
            $table->timestamps();
        });

        // Tabla de facilitadores
        Schema::create('facilitadores', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('cedula', 20)->unique();
            $table->string('especialidad');
            $table->string('telefono');
            $table->string('correo')->unique();
            $table->timestamps();
        });

        // Tabla de cursos
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->integer('duracion_horas');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->decimal('costo', 10, 2);
            $table->unsignedBigInteger('facilitador_id');
            $table->foreign('facilitador_id')->references('id')->on('facilitadores')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabla de aulas
        Schema::create('aulas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });

        // Tabla de horarios
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('curso_id');
            $table->unsignedBigInteger('aula_id');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');
            $table->foreign('aula_id')->references('id')->on('aulas')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabla de inscripciones
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alumno_id');
            $table->unsignedBigInteger('curso_id');
            $table->foreign('alumno_id')->references('id')->on('alumnos')->onDelete('cascade');
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');
            $table->timestamps();
        });

       
        // Tabla de calificaciones
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alumno_id');
            $table->unsignedBigInteger('curso_id');
            $table->decimal('calificacion', 5, 2);
            $table->foreign('alumno_id')->references('id')->on('alumnos')->onDelete('cascade');
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calificaciones');

        Schema::dropIfExists('inscripciones');
        Schema::dropIfExists('horarios');
        Schema::dropIfExists('aulas');
        Schema::dropIfExists('cursos');
        Schema::dropIfExists('facilitadores');
        Schema::dropIfExists('alumnos');
        Schema::dropIfExists('users');
    }
}
