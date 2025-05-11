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
        Schema::create('entrenamientos_usuarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('entrenamiento_id');  // Cambiar a unsignedInteger
            $table->unsignedBigInteger('usuario_id');
            $table->timestamps();

            // Definir las claves foráneas
            $table->foreign('entrenamiento_id')->references('id_entrenamiento')->on('entrenamientos')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('entrenamientos_usuarios');
    }
};
