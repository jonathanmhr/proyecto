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

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'usuario_entrenamiento')
                    ->withPivot('fecha_inicio', 'semanas_duracion', 'dias_entrenamiento')
                    ->withTimestamps();
    }
    public function usuariosGuardaron()
{
    return $this->belongsToMany(User::class, 'entrenamiento_user', 'entrenamiento_id', 'user_id')->withTimestamps();
}
}
