<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UsuarioEntrenamiento extends Model
{
    use HasFactory;

    protected $table = 'usuario_entrenamiento';

    protected $fillable = [
        'user_id',
        'entrenamiento_id',
        'fecha_inicio',
        'semanas_duracion',
        'dias_entrenamiento',
    ];

    protected $casts = [
        'dias_entrenamiento' => 'array',
        'fecha_inicio' => 'date',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function entrenamiento()
    {
        return $this->belongsTo(Entrenamiento::class);
    }
}
