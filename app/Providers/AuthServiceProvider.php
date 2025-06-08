<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Entrenamiento;
use App\Policies\EntrenamientoPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * El mapeo de modelos a policies.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Entrenamiento::class => EntrenamientoPolicy::class,
    ];

    /**
     * Registrar los servicios de autenticación/autorización.
     */
    public function boot()
    {
        $this->registerPolicies();

        // Aquí puedes agregar Gates si quieres
    }
}
