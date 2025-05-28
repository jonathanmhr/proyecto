<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilUsuario extends Model
{
    protected $table = 'perfil_usuario'; // Definimos el nombre de la tabla explícitamente

    protected $fillable = [
        'id_usuario', 'fecha_nacimiento', 'peso', 'altura', 'objetivo', 'id_nivel',
    ];
    public $timestamps = false;

    // Relación inversa con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }

    //compra//
    public function compras()
    {
        return $this->hasMany(Compra::class);
    }
}
