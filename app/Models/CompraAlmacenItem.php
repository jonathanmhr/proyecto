<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CompraAlmacenItem extends Pivot
{
    use HasFactory;

    protected $table = 'compra_almacen_item';

    public $incrementing = true;

    protected $fillable = [
        'compra_id',
        'almacen_id',
        'cantidad',
        'precio_unitario_compra',
        'subtotal',
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }
}
