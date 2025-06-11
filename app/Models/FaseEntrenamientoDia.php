<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaseEntrenamientoDia extends Model
{
    protected $table = 'fase_entrenamiento_dias';

    protected $fillable = [
        'entrenamiento_id',
        'fase_entrenamiento_id',
        'fecha',
        'estado',
        'user_id',
    ];


    // Relación a Entrenamiento
    public function entrenamiento()
    {
        return $this->belongsTo(Entrenamiento::class, 'entrenamiento_id');
    }

    // Relación a FaseEntrenamiento
    public function fase()
    {
        return $this->belongsTo(FaseEntrenamiento::class, 'fase_entrenamiento_id');
    }

    public function diasPlanificados()
    {
        return $this->hasMany(FaseEntrenamientoDia::class, 'fase_entrenamiento_id');
    }
    public function faseEntrenamiento()
    {
        return $this->belongsTo(FaseEntrenamiento::class, 'fase_entrenamiento_id');
    }
}
