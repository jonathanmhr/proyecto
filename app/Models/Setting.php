<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $primaryKey = 'key'; // Especificamos que 'key' es la clave primaria
    public $incrementing = false; // La clave primaria no es auto-incremental
    protected $keyType = 'string';   // El tipo de la clave primaria es string

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Helper para obtener un valor de configuración.
     */
    public static function getValue(string $key, $default = null)
    {
        $setting = self::find($key);
        return $setting ? $setting->value : $default;
    }

    /**
     * Helper para establecer o actualizar un valor de configuración.
     */
    public static function setValue(string $key, $value)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}