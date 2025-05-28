<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot; // Importante usar Pivot

class CompraAlmacenItem extends Pivot // Extiende de Pivot
{
    use HasFactory;

    protected $table = 'compra_almacen_item';

    public $incrementing = true; // Si tu tabla pivot tiene un ID auto-incremental

    protected $fillable = [
        'compra_id',
        'almacen_id',
        'cantidad',
        'precio_unitario_compra',
        'imagen',
        'subtotal',
    ];

    // Relaciones si necesitas acceder desde el pivot directamente
    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function almacenItem() // Nombre diferente para no colisionar con el modelo Almacen
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }
}