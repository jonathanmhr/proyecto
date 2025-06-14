<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Instructor extends Model
{
    use HasFactory;

    protected $table = 'instructores'; // nombre exacto de la tabla

    protected $primaryKey = 'id_instructor'; // clave primaria personalizada

    public $timestamps = true; // usa created_at y updated_at

    // Campos que se pueden asignar masivamente
 protected $fillable = [
        'nombre',
        'apellidos',
        'especialidad',
        'email',
        'telefono',
        'foto',
        'descripcion',
        'certificaciones',
        'horario',
        'activo',
    ];

    protected $casts = [
        'horario' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
