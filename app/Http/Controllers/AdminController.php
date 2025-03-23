<?php

// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all(); // Obtener todos los usuarios
        return view('admin.index', compact('users'));
    }

    public function assignRole(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        // Asignar el rol seleccionado
        $user->syncRoles($request->role);

        return redirect()->route('admin.index')->with('success', 'Rol asignado correctamente.');
    }
}
