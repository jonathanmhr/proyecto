<?php

namespace App\Policies;

use App\Models\Entrenamiento;
use App\Models\User;

class EntrenamientoPolicy
{
    public function viewAny(User $user): bool
    {
        // Puedes permitir a ciertos roles ver lista
        return in_array($user->rol, ['admin-entrenador', 'entrenador']);
    }

    public function view(User $user, Entrenamiento $entrenamiento): bool
    {
        // Aquí puedes poner reglas para ver un entrenamiento específico
        return in_array($user->rol, ['admin-entrenador', 'entrenador']);
    }

    public function create(User $user): bool
    {
        return in_array($user->rol, ['admin-entrenador', 'entrenador']);
    }

    public function update(User $user, Entrenamiento $entrenamiento): bool
    {
        return in_array($user->rol, ['admin-entrenador', 'entrenador']);
    }

    public function delete(User $user, Entrenamiento $entrenamiento): bool
    {
       return in_array($user->rol, ['admin-entrenador', 'entrenador']);
    }

    public function restore(User $user, Entrenamiento $entrenamiento): bool
    {
        return false;
    }

    public function forceDelete(User $user, Entrenamiento $entrenamiento): bool
    {
        return false;
    }
}
