<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Suscripcion extends Model
{
    use HasFactory;

    // Definir la clave primaria personalizada
    protected $primaryKey = 'id_suscripcion';

    // Definir la tabla si el nombre no sigue la convención
    protected $table = 'suscripciones';

    // Indicar si el modelo debe gestionar timestamps
    public $timestamps = true;  // Si no tienes 'created_at' y 'updated_at', ponlo en false

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

    // Definir constantes para el estado de la suscripción
    const ESTADO_ACTIVO = 'activo';
    const ESTADO_INACTIVO = 'inactivo';

    // Verificar si la suscripción está activa
    public function estaActiva()
    {
        return $this->estado === self::ESTADO_ACTIVO && $this->fecha_fin > now();
    }

    // Accesor para formatear las fechas de forma adecuada
    protected $dates = ['fecha_inicio', 'fecha_fin'];

    // Mutador para manejar fechas de suscripción (ejemplo, si lo necesitas)
    public function setFechaInicioAttribute($value)
    {
        $this->attributes['fecha_inicio'] = Carbon::parse($value);
    }

    public function setFechaFinAttribute($value)
    {
        $this->attributes['fecha_fin'] = Carbon::parse($value);
    }
}
