<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compra_almacen_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compra_id')->constrained('compras')->onDelete('cascade');
            $table->foreignId('almacen_id')->constrained('almacen')->onDelete('restrict'); 
            $table->unsignedInteger('cantidad');
            $table->decimal('precio_unitario_compra', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
            $table->unique(['compra_id', 'almacen_id']);
        });
    }

 
    public function down(): void
    {
        Schema::dropIfExists('compra_almacen_item');
    }
};