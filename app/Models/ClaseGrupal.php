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
        'hora_inicio',
        'fecha',
        'duracion',
        'ubicacion',
        'nivel',
        'entrenador_id',
        'frecuencia',
        'dias_semana',
    ];

    protected $casts = [
        'dias_semana' => 'array',
    ];

    // Definir la clave de ruta personalizada
    public function getRouteKeyName()
    {
        return 'id_clase';
    }

    // Relaciones
public function usuarios()
{
    return $this->belongsToMany(User::class, 'solicitud_clases', 'id_clase', 'user_id')
        ->withPivot('estado')
        ->withTimestamps();
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
