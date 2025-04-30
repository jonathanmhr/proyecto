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
        Schema::table('clases_grupales', function (Blueprint $table) {
            $table->date('fecha_fin')->after('fecha_inicio'); // Agrega el campo después de fecha_inicio
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clases_grupales', function (Blueprint $table) {
            $table->dropColumn('fecha_fin'); // Eliminar el campo en el rollback
        });
    }
};
