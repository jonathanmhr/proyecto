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
            $table->boolean('cambio_pendiente')->default(false); // Campo para marcar si hay cambios pendientes
        });
    }
    
    public function down()
    {
        Schema::table('clases_grupales', function (Blueprint $table) {
            $table->dropColumn('cambio_pendiente');
        });
    }
};
