<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entrenamiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'duracion_total',
        'kcal_total',
        'zona_muscular',
        'nivel',
        'equipamiento',
        'creado_por',
        'es_individual',
    ];

    public function fases()
    {
        return $this->hasMany(FaseEntrenamiento::class);
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    // Relación muchos a muchos con usuarios que están realizando el entrenamiento
    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'usuario_entrenamiento', 'entrenamiento_id', 'user_id')
            ->wherePivotNotNull('fecha_inicio')
            ->withPivot('fecha_inicio', 'semanas_duracion', 'dias_entrenamiento')
            ->withTimestamps();
    }

    // Usuarios que solo guardaron el entrenamiento (fecha_inicio nulo)
    public function usuariosGuardaron()
    {
        return $this->belongsToMany(User::class, 'usuario_entrenamiento', 'entrenamiento_id', 'user_id')
            ->wherePivotNull('fecha_inicio')
            ->withTimestamps();
    }
    // Accessor para calcular la duración total del entrenamiento
    public function getDuracionAttribute()
    {
        return $this->fases()->sum('duracion_min');
    }
    // Accesor para duración en días
    public function getDuracionDiasAttribute()
    {
        // Suma la duración de todas las fases en minutos
        $totalMinutos = $this->fases()->sum('duracion_min');

        // Convierte minutos a días (asumiendo 1 día = 1440 minutos)
        $dias = $totalMinutos / 1440;

        // Redondear para mostrar entero, o ajustar según lo que prefieras
        return $dias > 0 ? ceil($dias) : null;
    }

    public function diasPlanificados()
    {
        return $this->hasMany(FaseEntrenamientoDia::class, 'entrenamiento_id');
    }
    public function fasesDias()
{
    return $this->hasMany(FaseEntrenamientoDia::class, 'entrenamiento_id');
}
}
