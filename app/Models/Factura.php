<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'facturas';

    protected $fillable = [
        'compra_id',
        'numero_factura',
        'fecha_emision',
        'fecha_vencimiento',
        'total_factura',
        'estado_pago',
        'ruta_pdf',
        'notas',
    ];

    protected $casts = [
        'fecha_emision' => 'datetime',
        'fecha_vencimiento' => 'date',
    ];

    /**
     * La compra a la que pertenece esta factura.
     */
    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }
}