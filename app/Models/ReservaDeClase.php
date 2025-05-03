<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservaDeClase extends Model
{
    protected $table = 'reservas_de_clases';

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function clase()
    {
        return $this->belongsTo(ClaseGrupal::class, 'id_clase');
    }
}
