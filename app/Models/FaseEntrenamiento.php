<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FaseEntrenamiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'entrenamiento_id',
        'nombre',
        'duracion_min',
        'kcal_estimadas',
        'orden',
    ];

    public function entrenamiento()
    {
        return $this->belongsTo(Entrenamiento::class);
    }

    public function actividades()
    {
        return $this->hasMany(ActividadEntrenamiento::class);
    }
}
