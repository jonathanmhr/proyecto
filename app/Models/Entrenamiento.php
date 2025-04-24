<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrenamiento extends Model
{
    use HasFactory;

    // Definir la clave primaria personalizada
    protected $primaryKey = 'id_entrenamiento';

    // Definir la tabla si el nombre no sigue la convención
    protected $table = 'entrenamientos';

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
