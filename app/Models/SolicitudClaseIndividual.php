<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudClaseIndividual extends Model
{
    use HasFactory;
    protected $table = 'modificaciones_clases_individuales';

    protected $fillable = [
        'clase_individual_id',
        'entrenador_id',
        'datos_nuevos',
        'estado',
    ];

    protected $casts = [
        'datos_nuevos' => 'array',
    ];

    public function clase()
    {
        return $this->belongsTo(ClaseIndividual::class, 'clase_individual_id');
    }

    public function entrenador()
    {
        return $this->belongsTo(User::class, 'entrenador_id');
    }
}
