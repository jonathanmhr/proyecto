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
            $table->unsignedBigInteger('entrenador_id')->nullable(); // Relación con el entrenador
            $table->foreign('entrenador_id')->references('id')->on('users')->onDelete('set null');
        });
    }
    
    public function down()
    {
        Schema::table('clases_grupales', function (Blueprint $table) {
            $table->dropForeign(['entrenador_id']);
            $table->dropColumn('entrenador_id');
        });
    }
};
