<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CompraAlmacenItem;

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
        'tipo',
        'fecha_ultima_entrada',
    ];

    public function compras()
    {
        return $this->belongsToMany(Compra::class, 'compra_almacen_item')
                    ->using(CompraAlmacenItem::class)
                    ->withPivot('cantidad', 'precio_unitario_compra', 'subtotal')
                    ->withTimestamps();
    }
    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }
}
