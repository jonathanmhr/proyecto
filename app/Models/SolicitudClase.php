<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudClase extends Model
{
    use HasFactory;

    protected $fillable = ['id_clase', 'user_id'];

    public function clase()
    {
        return $this->belongsTo(ClaseGrupal::class, 'id_clase');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}