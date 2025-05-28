<?php

namespace App\Http\Controllers\Admin;

// Controlador base
use App\Http\Controllers\Controller;

// Request para manejar peticiones HTTP
use Illuminate\Http\Request;

// Modelos
use App\Models\User;

// Autorización y roles
use Silber\Bouncer\Database\Role;
use Bouncer;
use Carbon\Carbon;

// Facades y servicios de Laravel
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;

// Paginación
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    public function dashboard()
    {
        // Total de usuarios registrados en el sistema
        $totalUsuarios = User::count();

        // Total de entrenadores activos
        $entrenadoresActivos = User::whereHas('roles', function ($consulta) {
            $consulta->where('name', 'entrenador');
        })->count();

        // Total de roles creados (grupos)
        $gruposCreados = Role::count();

        // Usuarios que han iniciado sesión hoy (basado en la tabla de sesiones)
        $inicioHoy = Carbon::today()->timestamp;
        $manana = Carbon::tomorrow()->timestamp;

        $usuariosActivosHoy = DB::table('sessions')
            ->whereBetween('last_activity', [$inicioHoy, $manana])
            ->whereNotNull('user_id')
            ->distinct('user_id')
            ->count('user_id');

        // Usuarios inactivos desde hace más de 7 días
        $inactivosMas7Dias = User::where('is_active', false)
            ->where('updated_at', '<=', now()->subDays(7))
            ->count();

        // Últimos 5 usuarios registrados
        $usuariosRecientes = User::orderBy('created_at', 'desc')->take(5)->get();

        // Notificaciones enviadas por el usuario actual, con título, remitente (él mismo) y fecha
        $notificacionesEnviadas = DB::table('notifications')
            ->where('data->remitente_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($noti) {
                $data = json_decode($noti->data);
                return (object) [
                    'titulo' => $data->titulo ?? 'Sin título',
                    'fecha' => $noti->created_at,
                    'remitente' => Auth::user()->name,  // quien envió soy yo (usuario actual)
                ];
            });

        // Notificaciones recibidas para el usuario actual
        $notificacionesRecibidas = DB::table('notifications')
            ->where('notifiable_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Mapear notificaciones recibidas con icono y nombre remitente
        $alertas = $notificacionesRecibidas->map(function ($noti) {
            $data = json_decode($noti->data);

            $icono = 'ℹ️'; // por defecto
            if (stripos($data->titulo ?? '', 'error') !== false) {
                $icono = '⚠️';
            } elseif (stripos($data->titulo ?? '', 'exito') !== false) {
                $icono = '✅';
            }

            // Obtener nombre remitente si existe
            $remitenteNombre = 'Desconocido';
            if (!empty($data->remitente_id)) {
                $usuario = User::find($data->remitente_id);
                if ($usuario) {
                    $remitenteNombre = $usuario->name;
                }
            }

            return (object) [
                'icono' => $icono,
                'titulo' => $data->titulo ?? 'Sin título',
                'remitente' => $remitenteNombre,
                'fecha' => $noti->created_at,
            ];
        });

        // Total de usuarios por rol
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
            'alertas',  // notificaciones recibidas con icono, remitente, título, fecha
            'usuariosPorRol',
            'notificacionesEnviadas',  // notificaciones enviadas con título, remitente (yo), fecha
            'usuariosRecientes'
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

        $usersQuery = User::with('roles')
            ->leftJoin('assigned_roles', 'users.id', '=', 'assigned_roles.entity_id')
            ->leftJoin('roles', 'roles.id', '=', 'assigned_roles.role_id')
            ->when($search && strlen($search) >= 3 && strlen($search) <= 100, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('users.name', 'like', "%$search%")
                        ->orWhere('users.email', 'like', "%$search%");
                });
            })
            ->when($roleFilter, function ($query) use ($roleFilter) {
                $query->where('roles.name', $roleFilter);
            })
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

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        $status = Password::sendResetLink(['email' => $user->email]);

        return back()->with(
            $status === Password::RESET_LINK_SENT
                ? ['success' => 'Enlace de restablecimiento enviado a ' . $user->email]
                : ['error' => 'No se pudo enviar el enlace de restablecimiento.']
        );
    }

    public function conectados()
    {
        $inicioHoy = Carbon::today()->timestamp;
        $manana = Carbon::tomorrow()->timestamp;

        $sesiones = DB::table('sessions')
            ->whereBetween('last_activity', [$inicioHoy, $manana])
            ->whereNotNull('user_id')
            ->orderByDesc('last_activity')
            ->get();

        $usuariosConectados = $sesiones->groupBy('user_id')->map(function ($sesionesUsuario) {
            $ultimaSesion = $sesionesUsuario->first(); // la sesión más reciente
            $usuario = User::find($ultimaSesion->user_id);

            return [
                'usuario' => $usuario,
                'ultima_actividad' => Carbon::createFromTimestamp($ultimaSesion->last_activity)->format('H:i'),
                'ip' => $ultimaSesion->ip_address,
                'navegador' => $ultimaSesion->user_agent,
            ];
        });

        return view('admin.users.conectados', compact('usuariosConectados'));
    }

    public function inactivos()
    {
        $inactivos = User::where('is_active', false)
            ->where('updated_at', '<=', Carbon::now()->subDays(7))
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.users.inactivos', compact('inactivos'));
    }

    public function entrenadores(Request $request)
    {
        $search = $request->search;

        $entrenadoresQuery = User::with('roles')
            ->leftJoin('assigned_roles', 'users.id', '=', 'assigned_roles.entity_id')
            ->leftJoin('roles', 'roles.id', '=', 'assigned_roles.role_id')
            ->when($search && strlen($search) >= 3 && strlen($search) <= 100, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('users.name', 'like', "%$search%")
                        ->orWhere('users.email', 'like', "%$search%");
                });
            })
            ->whereIn('roles.name', ['entrenador', 'admin_entrenador'])
            ->select('users.*', DB::raw("CASE roles.name
            WHEN 'admin' THEN 1
            WHEN 'admin_entrenador' THEN 2
            WHEN 'entrenador' THEN 3
            WHEN 'cliente' THEN 4
            ELSE 999 END as role_priority"))
            ->orderBy('role_priority')
            ->orderBy('users.name');

        $entrenadores = $entrenadoresQuery->paginate(10)->withQueryString();

        return view('admin.users.entrenadores', compact('entrenadores'));
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
