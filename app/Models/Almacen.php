<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;

    protected $table = 'almacen'; 

    protected $fillable = [
        'nombre',
        'descripcion',
        'sku',
        'cantidad_disponible',
        'precio_unitario',
        'proveedor',
        'imagen',
        'fecha_ultima_entrada',
    ];

   
    public function compras()
    {
        return $this->belongsToMany(Compra::class, 'compra_almacen_item')
                    ->withPivot('cantidad', 'precio_unitario_compra', 'subtotal')
                    ->withTimestamps();
    }
}