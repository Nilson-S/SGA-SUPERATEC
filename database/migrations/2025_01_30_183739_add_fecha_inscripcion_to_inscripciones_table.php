<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('inscripciones', function (Blueprint $table) {
            if (!Schema::hasColumn('inscripciones', 'fecha_inscripcion')) {
                $table->date('fecha_inscripcion')->after('curso_id')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inscripciones', function (Blueprint $table) {
            if (Schema::hasColumn('inscripciones', 'fecha_inscripcion')) {
                $table->dropColumn('fecha_inscripcion');
            }
        });
    }
};
