<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SolicitudCambioEntrenamiento extends Model
{
    use HasFactory;

    protected $table = 'solicitud_cambio_entrenamiento';

    protected $fillable = [
        'entrenamiento_id',
        'entrenador_id',
        'datos_modificados',
        'estado',
    ];

    protected $casts = [
        'datos_modificados' => 'array',  // Laravel hará cast JSON automáticamente
    ];

    public function entrenamiento()
    {
        return $this->belongsTo(Entrenamiento::class, 'entrenamiento_id');
    }

    public function entrenador()
    {
        return $this->belongsTo(User::class, 'entrenador_id');
    }
}
