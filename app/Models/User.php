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
    //public function clases()
    //{
    //    return $this->belongsToMany(ClaseGrupal::class, 'suscripciones', 'id_usuario', 'id_clase')
    //        ->wherePivot('estado', Suscripcion::ESTADO_ACTIVO)  // Filtrar solo suscripciones activas
    //        ->wherePivot('fecha_fin', '>', now());  // Filtrar suscripciones con fecha de fin futura
    //}

    public function clasesAceptadas()
    {
        return $this->belongsToMany(ClaseGrupal::class, 'solicitud_clases', 'user_id', 'id_clase')
            ->wherePivot('estado', 'aceptada')
            ->withTimestamps();
    }

    public function getCuposRestantesAttribute()
    {
        $cuposUsados = $this->usuarios()
            ->wherePivot('estado', 'aceptada')
            ->count();

        return max(0, $this->cupos_maximos - $cuposUsados);
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
    public function clasesIndividualesAsignadas()
    {
        return $this->hasMany(ClaseIndividual::class, 'usuario_id');
    }

    public function clasesIndividualesCreadas()
    {
        return $this->hasMany(ClaseIndividual::class, 'creado_por');
    }

    public function entrenamientosGuardados()
    {
        return $this->belongsToMany(Entrenamiento::class, 'usuario_entrenamiento', 'user_id', 'entrenamiento_id')
            ->wherePivotNull('fecha_inicio')
            ->withTimestamps();
    }

    public function entrenamientos()
    {
        return $this->belongsToMany(Entrenamiento::class, 'usuario_entrenamiento', 'user_id', 'entrenamiento_id')
            ->withPivot('fecha_inicio', 'semanas_duracion', 'dias_entrenamiento')
            ->withTimestamps();
    }

    public function guardarEntrenamiento($entrenamientoId)
    {
        // Añadir registro con fecha_inicio = NULL para indicar guardado
        $this->entrenamientosGuardados()->syncWithoutDetaching([$entrenamientoId]);
    }

    public function quitarEntrenamiento($entrenamientoId)
    {
        // Quitar registro con fecha_inicio NULL (guardado)
        $this->entrenamientosGuardados()->detach($entrenamientoId);
    }
    
    public function dietas()
    {
        return $this->belongsToMany(DietaYPlanNutricional::class, 'dieta_user', 'user_id', 'id_dieta');
    }

        public function clearDietasRecomendadasCache()
    {
        Cache::forget('dietas_recomendadas_' . $this->id);
    }

}
