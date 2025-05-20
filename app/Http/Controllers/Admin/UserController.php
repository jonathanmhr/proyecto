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
        $totalUsuarios = User::count();

        $entrenadoresActivos = User::whereHas('roles', function ($query) {
            $query->where('name', 'entrenador');
        })->count();

        $gruposCreados = Role::count();

        $usuariosActivosHoy = User::where('is_active', true)->count();
        $inactivosMas7Dias = User::where('is_active', false)
            ->where('updated_at', '<=', now()->subDays(7))
            ->count();
        $usuariosRecientes = User::orderBy('created_at', 'desc')->take(5)->get();

        $alertas = [
            "⚠️ Grupo 'Equipo Norte' sin entrenador asignado",
            "✅ Se completó la exportación del reporte de progreso",
        ];

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
            'usuariosPorRol'
        ));
    }

    // Método para mostrar la lista de usuarios mejor optimizado
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $search = $request->search;
        $roleFilter = $request->role;

        // Prioridad para ordenar roles
        $rolePriority = [
            'admin' => 1,
            'admin_entrenador' => 2,
            'entrenador' => 3,
            'cliente' => 4,
        ];

        $usersQuery = User::with('roles')
            ->when($search && strlen($search) >= 3 && strlen($search) <= 100, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                });
            })
            ->when($roleFilter, function ($query) use ($roleFilter) {
                $query->whereHas('roles', function ($q) use ($roleFilter) {
                    $q->where('name', $roleFilter);
                });
            });

        // Aquí se agrega orden por prioridad de rol usando un CASE
        $usersQuery->leftJoin('assigned_roles', 'users.id', '=', 'assigned_roles.entity_id')
            ->leftJoin('roles', 'roles.id', '=', 'assigned_roles.role_id')
            ->select('users.*', DB::raw("CASE roles.name
                WHEN 'admin' THEN 1
                WHEN 'admin_entrenador' THEN 2
                WHEN 'entrenador' THEN 3
                WHEN 'cliente' THEN 4
                ELSE 999 END as role_priority"))
            ->orderBy('role_priority')
            ->orderBy('users.name');

        $users = $usersQuery->paginate(10)->withQueryString();

        return view('admin.users.index', ['users' => $users]);
    }

    // Método para asignar un rol a un usuario con validación
    public function assignRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::findOrFail($id);

        $role = Bouncer::role()->where('name', $request->role)->first();

        if (!$role) {
            return redirect()->route('admin.users.index')->with('error', 'El rol no existe.');
        }

        $user->roles()->detach();

        $user->assign($role);

        // Asignar permisos según el rol
        if ($role->name === 'admin') {
            $perms = [
                ['name' => 'admin-access', 'title' => 'Acceso al panel de administración'],
                ['name' => 'admin_entrenador', 'title' => 'Acceso al panel de administracion de entrenadores'],
                ['name' => 'entrenador-access', 'title' => 'Acceso al panel de entrenador'],
                ['name' => 'cliente-access', 'title' => 'Acceso para clientes'],
            ];

            foreach ($perms as $perm) {
                $ability = Bouncer::ability()->firstOrCreate($perm);
                Bouncer::allow($role)->to($ability);
            }
        } elseif ($role->name === 'entrenador') {
            $perm = Bouncer::ability()->firstOrCreate([
                'name' => 'entrenador-access',
                'title' => 'Acceso al panel de entrenador',
            ]);
            Bouncer::allow($role)->to($perm);
        } elseif ($role->name === 'cliente') {
            $perm = Bouncer::ability()->firstOrCreate([
                'name' => 'cliente-access',
                'title' => 'Acceso para clientes',
            ]);
            Bouncer::allow($role)->to($perm);
        } elseif ($role->name === 'admin_entrenador') {
            $perms = [
                ['name' => 'admin_entrenador', 'title' => 'Acceso al panel de administración de entrenadores'],
            ];

            foreach ($perms as $perm) {
                $ability = Bouncer::ability()->firstOrCreate($perm);
                Bouncer::allow($role)->to($ability);
            }
        }

        $user->load('roles');
        Bouncer::refresh($user);

        if (auth()->id() === $user->id) {
            auth()->user()->load('roles');
            Bouncer::refresh(auth()->user());
        }

        return redirect()->route('admin.users.index')->with('success', 'Rol y permisos asignados correctamente.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $clases = $user->clases;
        return view('admin.users.edit', compact('user', 'clases'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($validatedData);

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->clases()->exists()) {
            $user->clases()->detach();
        }

        if (Bouncer::is(auth()->user())->a('admin') && Bouncer::is($user)->a('admin')) {
            return redirect()->route('admin.users.index')->with('error', 'No puedes eliminar a otro usuario con rol de admin.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente.');
    }

    public function suscripciones($id)
    {
        $user = User::findOrFail($id);
        $suscripciones = $user->clases;
        return view('admin.users.suscripciones', compact('user', 'suscripciones'));
    }

    public function changeStatus($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Estado actualizado correctamente.');
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function generarReporte()
    {
        return view('admin.reportes.generar');
    }

    public function enviarAnuncio()
    {
        return view('admin.anuncios.enviar');
    }
}
