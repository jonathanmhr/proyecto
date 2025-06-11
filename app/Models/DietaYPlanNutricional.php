<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DietaYPlanNutricional extends Model
{
    use HasFactory;

    // Define el nombre de la tabla
    protected $table = 'dietas_y_planes_nutricionales';

    // Define la clave primaria
    protected $primaryKey = 'id_dieta';

    // Indica si la clave primaria es auto-incremental
    public $incrementing = true;

    // Tu tabla no tiene created_at/updated_at, así que lo desactivamos.
    public $timestamps = false;

    // Atributos que se pueden asignar masivamente (sin id_usuario)
    protected $fillable = [
        'nombre',
        'descripcion',
        'image_url', // Añadido según tu DUMP
        'calorias_diarias',
        'proteinas_g',
        'carbohidratos_g',
        'grasas_g',
    ];

    // Define los tipos de datos para las columnas
    protected $casts = [
        'calorias_diarias' => 'integer',
        'proteinas_g' => 'float',
        'carbohidratos_g' => 'float',
        'grasas_g' => 'float',
    ];

    /**
     * Define la relación de muchos a muchos con el modelo User.
     * Una dieta puede ser asignada a muchos usuarios.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'dieta_user', 'id_dieta', 'user_id');
    }
}