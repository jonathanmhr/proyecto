<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRolesAndAbilities;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // RELACIONES
    public function clases()
    {
        return $this->belongsToMany(ClaseGrupal::class, 'suscripciones', 'id_usuario', 'id_clase')
            ->wherePivot('estado', Suscripcion::ESTADO_ACTIVO)  // Filtrar solo suscripciones activas
            ->wherePivot('fecha_fin', '>', now());  // Filtrar suscripciones con fecha de fin futura
    }

    // Relación: Clases grupales asociadas al entrenador
    public function clasesGrupales()
    {
        return $this->hasMany(ClaseGrupal::class, 'entrenador_id');
    }

    // Relación: Usuarios inscritos en clases grupales
    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'suscripciones', 'id_clase', 'id_usuario')
            ->withPivot('estado', 'fecha_inicio', 'fecha_fin');  // Datos adicionales de la suscripción
    }

    // Relación: Reservas de clases realizadas por el usuario
    public function reservasDeClases()
    {
        return $this->hasMany(ReservaDeClase::class, 'id_usuario');
    }

    // Relación: Perfil de usuario asociado
    public function perfilUsuario()
    {
        return $this->hasOne(PerfilUsuario::class, 'id_usuario', 'id');
    }

    // Relación: Suscripciones asociadas a la clase grupal
    public function suscripciones()
    {
        return $this->hasMany(Suscripcion::class, 'id_clase');
    }
    // Relación: Solicitudes de clases asociadas al usuario
    public function entrenamientos()
    {
        return $this->belongsToMany(Entrenamiento::class, 'entrenamientos_usuarios', 'usuario_id', 'entrenamiento_id');
    }
}
