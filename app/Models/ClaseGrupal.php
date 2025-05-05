<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaseGrupal extends Model
{
    use HasFactory;

    // Definir la clave primaria
    protected $primaryKey = 'id_clase';

    // Definir la tabla
    protected $table = 'clases_grupales';

    // Atributos asignables masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'cupos_maximos',
        'fecha_inicio',
        'fecha_fin',
        'fecha',
        'duracion',
        'ubicacion',
        'nivel',
        'entrenador_id',
    ];

    // Definir la clave de ruta personalizada
    public function getRouteKeyName()
    {
        return 'id_clase';
    }

    // Relaciones
    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'suscripciones', 'id_clase', 'id_usuario')
            ->withPivot('estado', 'fecha_inicio', 'fecha_fin'); // Datos adicionales de la suscripción
    }

    public function entrenador()
    {
        return $this->belongsTo(User::class, 'entrenador_id'); // Relación con el entrenador
    }

    public function reservas()
    {
        return $this->hasMany(ReservaDeClase::class, 'id_clase'); // Relación con las reservas
    }

    public function solicitudes()
    {
        return $this->hasMany(SolicitudClase::class, 'id_clase'); // Relación con las solicitudes
    }
    public function suscripciones()
    {
        return $this->hasMany(Suscripcion::class, 'id_clase');
    }
}
