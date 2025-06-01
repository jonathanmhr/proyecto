<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Controladores
use App\Http\Controllers\Compra\CompraController;
use App\Http\Controllers\Compra\AlmacenController;
use App\Http\Controllers\Compra\CarritoController;
use App\Http\Controllers\Compra\CheckoutController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminEntrenador\AdminEntrenadorController;
use App\Http\Controllers\AdminEntrenador\AdminEntrenamientoController;
use App\Http\Controllers\Entrenador\EntrenadorController;
use App\Http\Controllers\Perfil\PerfilController;
use App\Http\Controllers\Cliente\DashboardController;
use App\Http\Controllers\General\ClaseGrupalController;
use App\Http\Controllers\General\EntrenamientoController;
use App\Http\Controllers\General\SolicitudClaseController;
use App\Http\Controllers\General\SuscripcionController;
use App\Http\Controllers\Admin\NotificacionController;
use App\Http\Controllers\General\NotificacionesController;
use App\Http\Controllers\Charts\ChartController;
use App\Http\Controllers\Charts\TrainerChartController;

// Middleware
use App\Actions\VerificarUsuarioActivo;
use Illuminate\Support\Facades\Auth;

//Google
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\GoogleController;

// ----------------------
// RUTA DE BIENVENIDA
// ----------------------
Route::get('/', fn() => view('welcome'));

Route::get('auth/google/redirect', [GoogleController::class, 'redirectToGoogle'])->name('auth.google.redirect');
// Ruta a la que Google redirige después de iniciar sesión
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// ----------------------
// RUTAS DEL DASHBOARD
// ----------------------
$middlewares = [
    'auth',
    config('jetstream.auth_session'),
    'verified',
    VerificarUsuarioActivo::class,
];
Route::middleware(array_filter($middlewares))->group(function () {
    Route::get('/dashboard', [PerfilController::class, 'index'])->name('dashboard');
});

// ----------------------
// RUTAS DE VERIFICACIÓN DE CORREO ELECTRÓNICO
// ----------------------
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', fn() => view('auth.verify-email'))->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/dashboard');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Correo de verificación reenviado.');
    })->middleware('throttle:6,1')->name('verification.send');
});

// ----------------------
// RUTAS ADMINISTRATIVAS
// ----------------------
Route::middleware(['auth', 'verified', 'can:admin-access', VerificarUsuarioActivo::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard principal
        Route::get('/', [UserController::class, 'dashboard'])->name('dashboard');

        // Gestión de usuarios
        Route::get('usuarios', [UserController::class, 'index'])->name('usuarios.index');
        Route::get('usuarios/activos', [UserController::class, 'activos'])->name('usuarios.activos');
        Route::get('usuarios/inactivos', [UserController::class, 'inactivos'])->name('usuarios.inactivos');
        Route::get('usuarios/crear', [UserController::class, 'create'])->name('usuarios.create');
        Route::get('usuarios/conectados', [UserController::class, 'conectados'])->name('usuarios.conectados');

        // 
        Route::get('entrenadores', [UserController::class, 'entrenadores'])->name('entrenadores');

        // 
        Route::get('grupos', [UserController::class, 'indexRoles'])->name('admin.roles.index');

        // anuncios
        Route::get('notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');
        Route::get('notificaciones/create', [NotificacionController::class, 'create'])->name('notificaciones.create');
        Route::post('notificaciones/enviar', [NotificacionController::class, 'send'])->name('notificaciones.send');


        // CRUD de usuarios (excepto create/show)
        Route::resource('users', UserController::class)->except(['create', 'show']);

        // Gestión de roles (grupos)
        Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('roles/crear', [RoleController::class, 'create'])->name('roles.create');
        Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
        Route::get('roles/{id}/editar', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('roles/{id}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');

        // Asignación de roles y cambios de estado
        Route::post('users/{id}/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
        Route::post('users/{id}/change-status', [UserController::class, 'changeStatus'])->name('users.changeStatus');
        Route::post('users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');

        // Suscripciones de usuario
        Route::get('users/{id}/suscripciones', [UserController::class, 'suscripciones'])->name('users.suscripciones');

        // Gestión de charts
        Route::get('/chart-data', [ChartController::class, 'index'])->name('chart.data');
        Route::get('/charts', [ChartController::class, 'index'])->name('charts.index');
    });

// ----------------------
// RUTAS ADMIN ENTRENADOR
// ----------------------
Route::middleware(['auth', 'verified', 'can:admin_entrenador', VerificarUsuarioActivo::class])
    ->prefix('admin-entrenador')
    ->name('admin-entrenador.')
    ->group(function () {
        Route::get('/', [AdminEntrenadorController::class, 'dashboard'])->name('dashboard');

        // Gestión de clases
        Route::get('clases', [AdminEntrenadorController::class, 'verClases'])->name('clases.index');
        Route::get('clases/create', [AdminEntrenadorController::class, 'create'])->name('clases.create');
        Route::post('clases', [AdminEntrenadorController::class, 'store'])->name('clases.store');
        Route::get('clases/{clase}/edit', [AdminEntrenadorController::class, 'edit'])->name('clases.edit');
        Route::put('clases/{clase}', [AdminEntrenadorController::class, 'update'])->name('clases.update');
        Route::delete('clases/{clase}', [AdminEntrenadorController::class, 'destroy'])->name('clases.destroy');
        Route::put('clase/{id}/aprobar', [AdminEntrenadorController::class, 'aprobarCambios'])->name('clases.aprobar');

        // Gestión de entrenadores
        Route::get('entrenadores', [AdminEntrenadorController::class, 'verEntrenadores'])->name('entrenadores.index');
        Route::get('entrenadores/create', [AdminEntrenadorController::class, 'create'])->name('entrenadores.create');
        Route::post('entrenadores', [AdminEntrenadorController::class, 'store'])->name('entrenadores.store');
        Route::get('entrenadores/{entrenador}/edit', [AdminEntrenadorController::class, 'editarEntrenador'])->name('entrenadores.edit');
        Route::put('entrenadores/{entrenador}', [AdminEntrenadorController::class, 'actualizarEntrenador'])->name('entrenadores.update');
        Route::delete('entrenadores/{entrenador}', [AdminEntrenadorController::class, 'destroy'])->name('entrenadores.destroy');
        Route::post('entrenadores/{user}/dar-baja', [AdminEntrenadorController::class, 'darBajaEntrenador'])->name('entrenadores.darBaja');

        // Gestión de alumnos
        Route::get('alumnos', [AdminEntrenadorController::class, 'verAlumnos'])->name('alumnos.index');
        Route::get('alumnos/{user}/edit', [AdminEntrenadorController::class, 'editarAlumno'])->name('alumnos.edit');
        Route::put('alumnos/{user}', [AdminEntrenadorController::class, 'actualizarAlumno'])->name('alumnos.update');
        Route::post('alumnos/{user}/quitar-de-clase/{claseId}', [AdminEntrenadorController::class, 'quitarDeClase'])->name('alumnos.quitarDeClase');

        // Solicitudes de clases
        Route::get('solicitudes', [AdminEntrenadorController::class, 'verSolicitudesClases'])->name('solicitudes.index');
        Route::post('solicitudes/{claseId}/aceptar/{usuarioId}', [AdminEntrenadorController::class, 'aceptarSolicitud'])->name('solicitudes.aceptar');
        Route::post('solicitudes/{claseId}/rechazar/{usuarioId}', [AdminEntrenadorController::class, 'rechazarSolicitud'])->name('solicitudes.rechazar');

        // Gestión de entrenamientos
        Route::get('entrenamientos', [AdminEntrenamientoController::class, 'index'])->name('entrenamientos.index');
        Route::get('entrenamientos/create', [AdminEntrenamientoController::class, 'create'])->name('entrenamientos.create');
        Route::post('entrenamientos', [AdminEntrenamientoController::class, 'store'])->name('entrenamientos.store');
        Route::get('entrenamientos/{entrenamiento}/edit', [AdminEntrenamientoController::class, 'edit'])->name('entrenamientos.edit');
        Route::put('entrenamientos/{entrenamiento}', [AdminEntrenamientoController::class, 'update'])->name('entrenamientos.update');
        Route::delete('entrenamientos/{entrenamiento}', [AdminEntrenamientoController::class, 'destroy'])->name('entrenamientos.destroy');

        // Gestión de usuarios en los entrenamientos
        Route::get('entrenamientos/{entrenamiento}/usuarios', [AdminEntrenamientoController::class, 'usuarios'])->name('entrenamientos.usuarios');
        Route::post('entrenamientos/{entrenamiento}/usuarios/agregar', [AdminEntrenamientoController::class, 'agregarUsuario'])->name('entrenamientos.usuarios.agregar');
        Route::delete('entrenamientos/{entrenamiento}/usuarios/{usuario}', [AdminEntrenamientoController::class, 'quitarUsuario'])->name('entrenamientos.usuarios.quitar');
        Route::post('entrenamientos/{entrenamiento}/usuarios/agregar-masivos', [AdminEntrenamientoController::class, 'agregarUsuariosMasivos'])->name('entrenamientos.usuarios.agregar-masivos');


        // Suscripciones de usuarios
        Route::get('users/{id}/suscripciones', [SuscripcionController::class, 'index'])->name('users.suscripciones');
        Route::get('/charts', [ChartController::class, 'index'])->name('charts');
    });

// ----------------------
// RUTAS DEL ENTRENADOR
// ----------------------
Route::middleware(['auth', 'verified', 'can:entrenador-access', VerificarUsuarioActivo::class])
    ->prefix('entrenador')
    ->name('entrenador.')
    ->group(function () {
        Route::get('/dashboard', [EntrenadorController::class, 'index'])->name('dashboard');

        // Gestión de clases
        Route::get('clases', [EntrenadorController::class, 'misClases'])->name('clases.index');
        Route::get('clases/{clase}/alumnos', [EntrenadorController::class, 'verAlumnos'])->name('clases.alumnos');
        Route::get('clases/{clase}/edit', [EntrenadorController::class, 'edit'])->name('clases.edit');
        Route::put('clases/{clase}', [EntrenadorController::class, 'updateClase'])->name('clases.update');
        Route::delete('clases/{clase}/quitar/{userId}', [EntrenadorController::class, 'quitarUsuario'])->name('clases.quitarUsuario');

        Route::get('solicitudes', [EntrenadorController::class, 'verSolicitudesPendientes'])->name('solicitudes.index');
        Route::post('solicitudes/aceptar/{id}', [EntrenadorController::class, 'aceptarSolicitud'])->name('solicitudes.aceptar');
        Route::post('solicitudes/rechazar/{id}', [EntrenadorController::class, 'rechazarSolicitud'])->name('solicitudes.rechazar');
    });

// ----------------------
// RUTAS DEL CLIENTE
// ----------------------
Route::middleware('auth', VerificarUsuarioActivo::class)
    ->prefix('cliente')
    ->name('cliente.')
    ->group(function () {
        // Nueva ruta del dashboard principal
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Clases
        Route::get('clases', [ClaseGrupalController::class, 'index'])->name('clases.index');
        Route::post('clases/{clase}/unirse', [ClaseGrupalController::class, 'unirse'])->name('clases.unirse');
        // Entrenamientos
        Route::get('entrenamientos', [EntrenamientoController::class, 'index'])->name('entrenamientos.index');
        Route::post('entrenamientos/{entrenamientoId}/unirse', [EntrenamientoController::class, 'unirseEntrenamiento'])->name('entrenamientos.unirse');
        Route::get('perfil-historial', function () {
            return view('perfil.historial');
        })->name('perfil.historial');
    });

Route::middleware('auth', VerificarUsuarioActivo::class)
    ->prefix('perfil')
    ->name('perfil.')
    ->group(function () {
        // Ruta para completar el perfil
        Route::get('completar', [PerfilController::class, 'completar'])->name('completar');
        Route::post('completar', [PerfilController::class, 'guardarPerfil'])->name('guardar');
        Route::get('editar', [PerfilController::class, 'editar'])->name('editar');
        Route::put('actualizar', [PerfilController::class, 'actualizar'])->name('actualizar');
        Route::post('notificaciones/{id}/marcar-leida', [PerfilController::class, 'marcarNotificacionLeida'])->name('notificaciones.marcarLeida');
        Route::post('notificaciones/marcar-todas-leidas', [PerfilController::class, 'marcarTodasNotificacionesLeidas'])->name('notificaciones.marcarTodasLeidas');
    });
// ----------------------
// RUTAS DE COMPRA
// ----------------------
Route::middleware(['auth'])
    ->group(function () {
        Route::get('/mis-compras', [CompraController::class, 'index'])->name('compras.index');
        Route::get('/compras/{compra}', [CompraController::class, 'show'])->name('compras.show');
        Route::get('/compras/{compra}/factura', [CompraController::class, 'downloadFactura'])->name('compras.factura.download');

        Route::prefix('admin/compras')
        ->name('admin.compras.')
        ->group(function () {
            Route::get('/', [CompraController::class, 'adminIndex'])->name('index')->middleware('can:admin-access'); 
            Route::get('/{compra}', [CompraController::class, 'adminShow'])->name('show')->middleware('can:admin-access'); 
       
    });
});
Route::middleware('auth') 
    ->prefix('tienda')
    ->name('tienda.')
    ->group(function () {
        Route::get('/', [AlmacenController::class, 'tiendaIndex'])->name('index');
    });
Route::middleware('auth')
    ->prefix('carrito') 
    ->name('carrito.')   
    ->controller(CarritoController::class) 
    ->group(function(){
        Route::post('/agregar/{almacen_id}', 'agregar')->name('agregar');
        Route::get('/', 'view')->name('view'); 
        Route::post('/actualizar/{almacen_id}', 'actualizar')->name('actualizar');
        Route::post('/eliminar/{almacen_id}', 'eliminar')->name('eliminar');
        Route::post('/vaciar', 'vaciar')->name('vaciar');
    });
Route::middleware('auth')
    ->prefix('checkout')          
    ->name('checkout.')          
    ->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index'); 
        Route::post('/procesar', [CheckoutController::class, 'procesar'])->name('procesar'); 
    });

