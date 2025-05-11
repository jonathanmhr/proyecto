<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrenamiento extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_entrenamiento';

    protected $table = 'entrenamientos';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'nombre',
        'tipo',
        'duracion',
        'fecha',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
    public function usuarios()
{
    return $this->belongsToMany(User::class, 'entrenamientos_usuarios', 'entrenamiento_id', 'usuario_id');
}
}
