<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerfilUsuario extends Model
{
    protected $table = 'perfil_usuario'; // Especificamos el nombre real de la tabla

    protected $fillable = [
        'id_usuario',
        'fecha_nacimiento',
        'peso',
        'altura',
        'objetivo',
        'id_nivel',
    ];

    /**
     * Relación con el modelo User.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    /**
     * Relación con el modelo de niveles (si existe).
     */
}
