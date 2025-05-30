<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CompraAlmacenItem;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fecha_compra',
        'total_compra',
        'metodo_pago',
        'estado',
        
    ];

    protected $casts = [
        'fecha_compra' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function itemsAlmacen()
    {
        return $this->belongsToMany(Almacen::class, 'compra_almacen_item')
            ->using(CompraAlmacenItem::class)
            ->withPivot('cantidad', 'precio_unitario_compra', 'subtotal')
            ->withTimestamps();
    }


    public function factura()
    {
        return $this->hasOne(Factura::class);
    }
}
