<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActividadEntrenamiento extends Model
{
    use HasFactory;
    
    protected $table ='actividades_entrenamiento';

    protected $fillable = [
        'fase_entrenamiento_id',
        'nombre',
        'tipo',
        'series',
        'repeticiones',
        'imagen',
    ];

    public function fase()
    {
        return $this->belongsTo(FaseEntrenamiento::class, 'fase_entrenamiento_id');
    }
}
