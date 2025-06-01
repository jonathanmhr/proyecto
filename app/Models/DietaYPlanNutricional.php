<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DietaYPlanNutricional extends Model
{
    use HasFactory;

    // Define el nombre de la tabla si no sigue la convención de nombres de Laravel (plural del modelo)
    protected $table = 'dietas_y_planes_nutricionales';

    // Define la clave primaria si no es 'id'
    protected $primaryKey = 'id_dieta';

    // Indica si la clave primaria es auto-incremental (Laravel lo asume por defecto si es INT)
    public $incrementing = true;

    // Define los atributos que se pueden asignar masivamente
    protected $fillable = [
        'id_usuario',
        'nombre',
        'descripcion',
        'calorias_diarias',
        'proteinas_g',
        'carbohidratos_g',
        'grasas_g',
    ];

    // Define los tipos de datos para las columnas (opcional, pero buena práctica para claridad)
    protected $casts = [
        'calorias_diarias' => 'integer',
        'proteinas_g' => 'float',
        'carbohidratos_g' => 'float',
        'grasas_g' => 'float',
    ];

    /**
     * Define la relación con el modelo User si id_usuario se refiere a la tabla users.
     * Una dieta puede pertenecer a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}