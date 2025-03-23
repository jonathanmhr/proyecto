<?php

// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class AdminController extends Controller
{
    // Mostrar lista de usuarios
    public function index()
    {
        // Verificar si el usuario tiene el rol de admin
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado');
        }
    
        // Obtener usuarios paginados
        $users = User::paginate(10); // Cambia el número de usuarios por página si es necesario
        return view('admin.index', compact('users')); // Aquí debería cargar la vista admin.index
    }

    // Asignar un rol a un usuario
    public function assignRole(Request $request, $userId)
    {
        // Verificar si el usuario tiene el rol de admin
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado');
        }

        $user = User::findOrFail($userId);
        $role = Role::findByName($request->role);
        $user->syncRoles($role); // Asigna el rol al usuario
        return redirect()->route('admin.index')->with('success', 'Rol asignado correctamente');
    }

    // Eliminar un usuario
    public function deleteUser($userId)
    {
        // Verificar si el usuario tiene el rol de admin
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado');
        }

        $user = User::findOrFail($userId);
        $user->delete(); // Elimina al usuario
        return redirect()->route('admin.index')->with('success', 'Usuario eliminado correctamente');
    }
}
