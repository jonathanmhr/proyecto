<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class PerfilUsuarioHistorial extends Model
{
    protected $table = 'perfil_usuario_historial';

    protected $fillable = [
        'user_id',
        'fecha_nacimiento',
        'peso',
        'altura',
        'objetivo',
        'id_nivel',
    ];

    // Relación inversa
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
