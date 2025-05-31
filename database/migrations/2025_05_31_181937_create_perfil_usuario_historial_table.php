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
        Schema::create('perfil_usuario_historial', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            
            // Campos que quieras guardar, por ejemplo:
            $table->date('fecha_nacimiento')->nullable();
            $table->decimal('peso', 5, 2)->nullable();
            $table->decimal('altura', 5, 2)->nullable();
            $table->string('objetivo')->nullable();
            $table->unsignedTinyInteger('id_nivel')->nullable();
            
            $table->timestamps();

            // Foreign key para usuario
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('perfil_usuario_historial');
    }
};
