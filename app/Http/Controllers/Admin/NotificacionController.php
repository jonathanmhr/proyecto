<?php

namespace App\Http\Controllers\Admin;

// Controlador base
use App\Http\Controllers\Controller;

// Modelos
use App\Models\User;

// Solicitudes HTTP
use Illuminate\Http\Request;

// Autorización y permisos
use Silber\Bouncer\BouncerFacade as Bouncer;

// Notificaciones
use App\Notifications\NotificacionPersonalizada;

// Facades y servicios de Laravel
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class NotificacionController extends Controller
{

    public function index()
    {
        $notificaciones = DB::table('notifications')
            ->where('data->remitente_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Obtener IDs de usuarios destinatarios para la página actual
        $userIds = $notificaciones->pluck('notifiable_id')->unique();

        // Cargar usuarios destinatarios
        $usuarios = User::whereIn('id', $userIds)->get()->keyBy('id');

        return view('admin.notificaciones.index', compact('notificaciones', 'usuarios'));
    }


    public function create()
    {
        $roles = Bouncer::role()->get();  // roles con Bouncer
        $usuarios = User::orderBy('name')->paginate(10);

        return view('admin.notificaciones.create', compact('roles', 'usuarios'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'destino' => 'required|in:todos,roles,usuarios',
            'roles' => 'nullable|array',
            'roles.*' => 'string',
            'usuarios' => 'nullable|array',
            'usuarios.*' => 'integer|exists:users,id',
            'tipo' => 'required|in:notificacion,email',
        ]);

        $titulo = $request->input('titulo');
        $mensaje = $request->input('mensaje');
        $destino = $request->input('destino');
        $tipo = $request->input('tipo');

        $canales = $tipo === 'email' ? ['database', 'mail'] : ['database'];

        $remitente = Auth::user();

        if ($destino === 'todos') {
            User::chunk(100, function ($users) use ($titulo, $mensaje, $canales, $remitente) {
                foreach ($users as $user) {
                    $user->notify(new NotificacionPersonalizada($titulo, $mensaje, 'notificacion', $canales, $remitente));
                }
            });
        } elseif ($destino === 'roles' && $request->filled('roles')) {
            $roles = $request->input('roles');
            User::whereHas('roles', function ($q) use ($roles) {
                $q->whereIn('name', $roles);
            })->chunk(100, function ($users) use ($titulo, $mensaje, $canales, $remitente) {
                foreach ($users as $user) {
                    $user->notify(new NotificacionPersonalizada($titulo, $mensaje, 'notificacion', $canales, $remitente));
                }
            });
        } elseif ($destino === 'usuarios' && $request->filled('usuarios')) {
            $usuarios = User::whereIn('id', $request->input('usuarios'))->get();
            foreach ($usuarios as $user) {
                $user->notify(new NotificacionPersonalizada($titulo, $mensaje, 'notificacion', $canales, $remitente));
            }
        }

        return redirect()->route('admin.notificaciones.create')->with('success', 'Notificación enviada correctamente.');
    }
}
