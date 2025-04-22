<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilUsuario extends Model
{
    use HasFactory;

    // Definir la tabla para el modelo
    protected $table = 'perfil_usuario';
    public $timestamps = false;

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'id_usuario',
        'fecha_nacimiento',
        'peso',
        'altura',
        'objetivo',
        'id_nivel',
    ];

    // Relación con el usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    // Otros métodos...
}
