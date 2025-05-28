<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compra_id')->unique()->constrained('compras')->onDelete('cascade');
            $table->string('numero_factura')->unique();
            $table->dateTime('fecha_emision')->default(now());
            $table->date('fecha_vencimiento')->nullable();
            $table->decimal('total_factura', 10, 2);
            $table->string('estado_pago')->default('pendiente'); 
            $table->string('ruta_pdf')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};