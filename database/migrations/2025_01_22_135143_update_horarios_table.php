<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateHorariosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('horarios', function (Blueprint $table) {
            // Añadir la columna para taller y facilitador
            $table->unsignedBigInteger('taller_id')->nullable()->after('curso_id');
            $table->unsignedBigInteger('facilitador_id')->after('aula_id');

            // Definir las relaciones para las nuevas columnas
            $table->foreign('taller_id')->references('id')->on('talleres')->onDelete('cascade');
            $table->foreign('facilitador_id')->references('id')->on('facilitadores')->onDelete('cascade');

            // Eliminar la columna 'fecha', si existe
            if (Schema::hasColumn('horarios', 'fecha')) {
                $table->dropColumn('fecha');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('horarios', function (Blueprint $table) {
            // Eliminar las nuevas columnas y relaciones
            $table->dropForeign(['taller_id']);
            $table->dropForeign(['facilitador_id']);
            $table->dropColumn(['taller_id', 'facilitador_id']);

            // Restaurar la columna 'fecha', si se desea
            $table->date('fecha')->nullable();
        });
    }
}
