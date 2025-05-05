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
            $table->unsignedBigInteger('id_clase');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
    
            // Claves foráneas
            $table->foreign('id_clase')->references('id_clase')->on('clases_grupales')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_clases');
    }
};
