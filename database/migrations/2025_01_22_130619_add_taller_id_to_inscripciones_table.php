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
    Schema::table('inscripciones', function (Blueprint $table) {
        $table->foreignId('taller_id')->nullable()->constrained('talleres')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('inscripciones', function (Blueprint $table) {
        $table->dropForeign(['taller_id']);
        $table->dropColumn('taller_id');
    });
}

};
