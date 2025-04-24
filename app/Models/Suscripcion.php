<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suscripcion extends Model
{
    use HasFactory;

    // Definir la clave primaria personalizada
    protected $primaryKey = 'id_suscripcion';

    // Definir la tabla si el nombre no sigue la convención
    protected $table = 'suscripciones';

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'id_usuario',   // El ID del usuario que se suscribe
        'id_clase',     // El ID de la clase a la que se suscribe
        'estado',       // El estado de la suscripción (activo, inactivo, etc.)
        'fecha_inicio', // La fecha en la que comienza la suscripción
        'fecha_fin',    // La fecha en la que termina la suscripción
    ];

    // Relación con el usuario (pertenece a un usuario)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    // Relación con la clase grupal (pertenece a una clase grupal)
    public function clase()
    {
        return $this->belongsTo(ClaseGrupal::class, 'id_clase');
    }
}
