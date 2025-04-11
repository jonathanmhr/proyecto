<?php

// database/seeders/RolesSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Crear roles
        $admin = Role::create(['name' => 'admin']);
        $trainer = Role::create(['name' => 'trainer']);
        $client = Role::create(['name' => 'client']);

        // Crear permisos (si deseas)
        $permission1 = Permission::create(['name' => 'manage users']);
        $permission2 = Permission::create(['name' => 'manage classes']);
        
        // Asignar permisos a roles (ejemplo)
        $admin->givePermissionTo($permission1);
        $trainer->givePermissionTo($permission2);

        // Asignar roles a usuarios
        $user = \App\Models\User::find(1); // El ID de tu usuario administrador
        $user->assignRole('admin');
    }
}
