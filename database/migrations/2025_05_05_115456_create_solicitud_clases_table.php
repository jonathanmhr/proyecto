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
        Schema::create('solicitud_clases', function (Blueprint $table) {
            $table->id();

            // Coinciden con las columnas referenciadas
            $table->unsignedBigInteger('user_id');     // BIGINT UNSIGNED para users.id
            $table->unsignedInteger('id_clase');        // INT UNSIGNED para clases_grupales.id_clase

            $table->timestamps();

            // Llaves foráneas correctas
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('id_clase')
                ->references('id_clase')->on('clases_grupales')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitud_clases');
    }
};
