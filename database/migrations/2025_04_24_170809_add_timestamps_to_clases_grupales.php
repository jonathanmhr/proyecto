<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToClasesGrupales extends Migration
{
    public function up()
    {
        Schema::table('clases_grupales', function (Blueprint $table) {
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('clases_grupales', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
}
