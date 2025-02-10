<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('inscripciones', function (Blueprint $table) {
            $table->decimal('monto_pago', 10, 2)->nullable()->after('fecha_inscripcion');
            $table->enum('metodo_pago', ['Transferencia Bancaria', 'Efectivo Bs', 'Efectivo USD'])->nullable()->after('monto_pago');
            $table->date('fecha_pago')->nullable()->after('metodo_pago');
        });
    }

    public function down()
    {
        Schema::table('inscripciones', function (Blueprint $table) {
            $table->dropColumn(['monto_pago', 'metodo_pago', 'fecha_pago']);
        });
    }
};
