<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Bouncer;

class UserController extends Controller
{
    // Método para mostrar la lista de usuarios
    public function index(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Recuperar los usuarios de la base de datos con paginación
        $users = User::when($request->search, function ($query) use ($request) {
            // Validación de longitud de búsqueda: mínimo 3 caracteres, máximo 8
            if (strlen($request->search) >= 3 && strlen($request->search) <= 8) {
                return $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            }
            return $query; // Si no cumple la longitud, no filtra
        })
            ->paginate(10); // 10 usuarios por página

        // Retornar la vista con la lista de usuarios
        return view('admin.users.index', compact('users'));
    }


    // Método para asignar un rol a un usuario
    public function assignRole(Request $request, $id)
    {
        // Encontrar el usuario por su ID
        $user = User::findOrFail($id);

        // Buscar el rol en la base de datos según el nombre proporcionado en la solicitud
        $role = Bouncer::role()->where('name', $request->role)->first();

        if (!$role) {
            // Si el rol no existe, redirigir con un mensaje de error
            return redirect()->route('admin.users.index')->with('error', 'El rol no existe.');
        }

        // Eliminar los roles anteriores del usuario
        $user->roles()->detach();

        // Asignar el nuevo rol al usuario
        $user->assign($role);

        // Asignar permisos según el rol
        if ($role->name === 'admin') {
            // Asignar permisos de administrador
            $perms = [
                ['name' => 'admin-access', 'title' => 'Acceso al panel de administración'],
                ['name' => 'admin_entrenador', 'title' => 'Acceso al panel de administracion de entrenadores'],
                ['name' => 'entrenador-access', 'title' => 'Acceso al panel de entrenador'],
                ['name' => 'cliente-access', 'title' => 'Acceso para clientes'],
            ];

            // Crear habilidades y asignarlas al rol
            foreach ($perms as $perm) {
                $ability = Bouncer::ability()->firstOrCreate($perm);
                Bouncer::allow($role)->to($ability);
            }
        } elseif ($role->name === 'entrenador') {
            // Asignar permiso de entrenador
            $perm = Bouncer::ability()->firstOrCreate([
                'name' => 'entrenador-access',
                'title' => 'Acceso al panel de entrenador',
            ]);
            Bouncer::allow($role)->to($perm);
        } elseif ($role->name === 'cliente') {
            // Asignar permiso de cliente
            $perm = Bouncer::ability()->firstOrCreate([
                'name' => 'cliente-access',
                'title' => 'Acceso para clientes',
            ]);
            Bouncer::allow($role)->to($perm);
        } elseif ($role->name === 'admin_entrenador') {
            // Si el rol es 'admin_entrenador'
            $perms = [
                ['name' => 'admin_entrenador', 'title' => 'Acceso al panel de administración de entrenadores'],
                // Otros permisos relacionados con la gestión de entrenadores
            ];

            // Crear habilidades y asignarlas al rol
            foreach ($perms as $perm) {
                $ability = Bouncer::ability()->firstOrCreate($perm);
                Bouncer::allow($role)->to($ability);
            }
        }


        // Refrescar los permisos asignados al usuario
        $user->load('roles');
        Bouncer::refresh($user);

        // Si el usuario actual está cambiando su propio rol, refrescar sus permisos
        if (auth()->id() === $user->id) {
            auth()->user()->load('roles');
            Bouncer::refresh(auth()->user());
        }

        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.users.index')->with('success', 'Rol y permisos asignados correctamente.');
    }

    // Método para mostrar el formulario de edición de un usuario
    public function edit($id)
    {
        // Obtener el usuario por su ID
        $user = User::findOrFail($id);

        // Retornar la vista de edición con el usuario
        return view('admin.users.edit', compact('user'));
    }

    // Método para actualizar la información de un usuario
    public function update(Request $request, $id)
    {
        // Encontrar al usuario por su ID
        $user = User::findOrFail($id);

        // Validar los datos enviados en la solicitud
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', // Validar que el nombre sea obligatorio y tenga un formato válido
            'email' => 'required|email|max:255|unique:users,email,' . $user->id, // Validar el email
        ]);

        // Actualizar los datos del usuario en la base de datos
        $user->update($validatedData);

        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    // Método para eliminar un usuario
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Evitar eliminar usuarios con el rol 'admin' (suponiendo que tienes un campo 'role')
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index')->with('error', 'No puedes eliminar un usuario con rol de admin.');
        }

        // Eliminar el usuario
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
