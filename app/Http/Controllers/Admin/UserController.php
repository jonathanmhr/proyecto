<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Silber\Bouncer\Database\Role;
use Bouncer;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function dashboard()
    {
        // Total usuarios
        $totalUsuarios = User::count();

        // Entrenadores activos (usuarios con rol 'entrenador')
        $entrenadoresActivos = User::whereHas('roles', function ($query) {
            $query->where('name', 'entrenador');
        })->count();

        // Grupos creados (roles que consideramos "grupos" en Bouncer)
        $gruposCreados = Role::count();

        // Usuarios activos hoy
        $usuariosActivosHoy = User::whereDate('last_login_at', now()->toDateString())->count();

        // Usuarios inactivos +7 días
        $inactivosMas7Dias = User::where('last_login_at', '<', now()->subDays(7))->count();

        // Alertas ejemplo
        $alertas = [
            "🔴 Usuario Juan Pérez lleva 10 días inactivo",
            "⚠️ Grupo 'Equipo Norte' sin entrenador asignado",
            "✅ Se completó la exportación del reporte de progreso",
        ];

        // Acciones rápidas
        $accionesRapidas = [
            ['label' => 'Crear nuevo usuario', 'route' => route('admin.users.create'), 'icon' => 'user-plus', 'color' => 'blue'],
            ['label' => 'Asignar entrenador a usuarios', 'route' => route('admin.entrenadores.asignar'), 'icon' => 'user-check', 'color' => 'green'],
            ['label' => 'Crear nuevo grupo', 'route' => route('admin.groups.create'), 'icon' => 'layers', 'color' => 'yellow'],
            ['label' => 'Generar reporte', 'route' => route('admin.reportes.index'), 'icon' => 'file-text', 'color' => 'indigo'],
            ['label' => 'Enviar anuncio', 'route' => route('admin.anuncios.create'), 'icon' => 'send', 'color' => 'purple'],
        ];

        // Usuarios por rol
        $usuariosPorRol = User::select(DB::raw('roles.name as rol'), DB::raw('count(users.id) as total'))
            ->join('assigned_roles', 'users.id', '=', 'assigned_roles.entity_id')
            ->join('roles', 'roles.id', '=', 'assigned_roles.role_id')
            ->groupBy('roles.name')
            ->pluck('total', 'rol');

        return view('admin.dashboard', compact(
            'totalUsuarios',
            'entrenadoresActivos',
            'gruposCreados',
            'usuariosActivosHoy',
            'inactivosMas7Dias',
            'alertas',
            'accionesRapidas',
            'usuariosPorRol'
        ));
    }

    // Método para mostrar la lista de usuarios
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $search = $request->search;
        $roleFilter = $request->role;

        $users = User::with('roles')
            ->when($search, function ($query) use ($search) {
                if (strlen($search) >= 3 && strlen($search) <= 100) {
                    return $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%")
                            ->orWhere('email', 'like', "%$search%");
                    });
                }
            })
            ->get()
            ->filter(function ($user) use ($roleFilter) {
                if (!$roleFilter) return true;
                return $user->roles->contains('name', $roleFilter);
            })
            ->sortBy(function ($user) {
                $priority = [
                    'admin' => 1,
                    'admin_entrenador' => 2,
                    'entrenador' => 3,
                    'cliente' => 4,
                ];

                $userRole = optional($user->roles->first())->name;
                return $priority[$userRole] ?? 999;
            })
            ->values();

        // Convertir a una colección paginada manual (ya que usamos get()->filter()->sortBy())
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $paginatedUsers = new LengthAwarePaginator(
            $users->slice(($currentPage - 1) * $perPage, $perPage),
            $users->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.users.index', ['users' => $paginatedUsers]);
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
        $user = User::findOrFail($id);

        // Obtener las clases a las que el usuario está suscrito
        $clases = $user->clases;

        return view('admin.users.edit', compact('user', 'clases'));
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

        // Verificar si el usuario tiene suscripciones activas
        if ($user->clases()->exists()) {
            // Eliminar las suscripciones del usuario
            $user->clases()->detach(); // Desvincula las clases
        }

        // Evitar eliminar usuarios con el rol 'admin'
        if (Bouncer::is(auth()->user())->a('admin') && Bouncer::is($user)->a('admin')) {
            return redirect()->route('admin.users.index')->with('error', 'No puedes eliminar a otro usuario con rol de admin.');
        }

        // Eliminar el usuario
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente.');
    }

    // Método para ver todas las suscripciones de un usuario
    public function suscripciones($id)
    {
        $user = User::findOrFail($id);

        // Obtener las clases a las que está suscrito el usuario
        $suscripciones = $user->clases;

        return view('admin.users.suscripciones', compact('user', 'suscripciones'));
    }
}
