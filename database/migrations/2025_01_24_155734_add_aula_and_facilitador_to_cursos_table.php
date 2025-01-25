<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->unsignedBigInteger('aula_id')->after('fecha_fin'); // Añade aula_id

    
            // Foreign key constraints
            $table->foreign('aula_id')->references('id')->on('aulas')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropForeign(['aula_id']);


        });
    }
    
};
