<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('clases_grupales', function (Blueprint $table) {
            $table->date('fecha_inicio')->after('cupos_maximos');
        });
    }

    public function down(): void
    {
        Schema::table('clases_grupales', function (Blueprint $table) {
            $table->dropColumn('fecha_inicio');
        });
    }
};
