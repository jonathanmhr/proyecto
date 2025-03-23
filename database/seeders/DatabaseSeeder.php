<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuarios de ejemplo
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Crear roles
        $adminRole = Role::create(['name' => 'admin']);
        $trainerRole = Role::create(['name' => 'trainer']);
        $clientRole = Role::create(['name' => 'client']);

        // Crear permisos
        $manageUsers = Permission::create(['name' => 'manage users']);
        $manageClasses = Permission::create(['name' => 'manage classes']);

        // Asignar permisos a roles
        $adminRole->givePermissionTo($manageUsers);
        $trainerRole->givePermissionTo($manageClasses);
    }
}