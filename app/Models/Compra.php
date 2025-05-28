<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'compras';

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

    /**
     * El usuario que realizó la compra.
     */
    public function user()
    {
        return $this->belongsTo(User::class); // Asegúrate que el modelo User exista en App\Models\User
    }

    /**
     * Los ítems de almacén incluidos en esta compra.
     */
    public function itemsAlmacen()
    {
        return $this->belongsToMany(Almacen::class, 'compra_almacen_item')
                    ->withPivot('cantidad', 'precio_unitario_compra', 'subtotal')
                    ->withTimestamps();
    }

    /**
     * La factura asociada a esta compra.
     */
    public function factura()
    {
        return $this->hasOne(Factura::class);
    }
}