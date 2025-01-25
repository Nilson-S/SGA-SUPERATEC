<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('apellido')->after('name');
            $table->string('cedula')->unique()->after('apellido');
            $table->enum('genero', ['masculino', 'femenino'])->after('cedula');
            $table->date('fecha_nacimiento')->nullable()->after('genero');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['apellido', 'cedula', 'genero', 'fecha_nacimiento']);
        });
    }
}
