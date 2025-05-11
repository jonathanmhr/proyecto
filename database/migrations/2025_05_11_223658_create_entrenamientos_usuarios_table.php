<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntrenamientosUsuariosTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('entrenamientos_usuarios')) {
            Schema::create('entrenamientos_usuarios', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('entrenamiento_id');
                $table->unsignedBigInteger('usuario_id');
                $table->timestamps();

                // Índices para las claves foráneas
                $table->foreign('entrenamiento_id')->references('id_entrenamiento')->on('entrenamientos')->onDelete('cascade');
                $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('entrenamientos_usuarios');
    }
}
