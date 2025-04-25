<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaseGrupal extends Model
{
    use HasFactory;

    // Definir la clave primaria personalizada
    protected $primaryKey = 'id_clase';

    // Definir la tabla si el nombre no sigue la convención
    protected $table = 'clases_grupales';

    // Atributos asignables masivamente
    protected $fillable = ['nombre', 'descripcion', 'cupos_maximos'];

    // Si la relación existe, se define aquí
    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'suscripciones', 'id_clase', 'id_usuario')
            ->withPivot('estado', 'fecha_inicio', 'fecha_fin');  // Para manejar los datos adicionales de la suscripción
    }
    
    public function entrenador()
    {
        return $this->belongsTo(User::class, 'id_entrenador');  // Suponiendo que tienes un campo 'id_entrenador' en tu tabla 'clases_grupales'
    }
}
