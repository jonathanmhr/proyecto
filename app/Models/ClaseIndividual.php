<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClaseIndividual extends Model
{
    protected $table = 'clases_individuales';

    public $timestamps = true;

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_hora',
        'usuario_id',
        'creado_por',
        'frecuencia',
        'dias_semana',
        'fecha_inicio',
        'fecha_fin',
        'hora_inicio',
        'duracion',
        'lugar',        // agregado
        'nivel',        // agregado
        'entrenador_id' // agregado
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'hora_inicio' => 'datetime:H:i:s',
        'dias_semana' => 'array', // importante para que lo convierta automáticamente desde/hacia JSON
    ];

    /**
     * Relación con el usuario (cliente asignado).
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relación con el creador (admin o admin-entrenador).
     */
    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
    
    /**
    * Relación con entrenador (usuario que imparte la clase)
    */
    public function entrenador()
    {
        return $this->belongsTo(User::class, 'entrenador_id');
    }

}
