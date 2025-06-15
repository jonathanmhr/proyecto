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
use App\Http\Controllers\Entrenador\EntrenadorIndividual;
use App\Http\Controllers\Perfil\PerfilController;
use App\Http\Controllers\Perfil\InstructorController;
use App\Http\Controllers\Cliente\DashboardController;
use App\Http\Controllers\General\ClaseGrupalController;
use App\Http\Controllers\General\ClaseIndividualController;
use App\Http\Controllers\General\EntrenamientoController;
use App\Http\Controllers\General\SolicitudClaseController;
use App\Http\Controllers\General\FaseEntrenamientoController;
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

//Setting
use App\Models\Setting;
use App\Http\Controllers\Admin\SettingsController;

// ----------------------
// TERM Y POLICY
// ----------------------
Route::view('/terms', 'terms')->name('terms');
Route::view('/policy', 'policy')->name('policy');
// ----------------------
// RUTA DE BIENVENIDA
// ----------------------
Route::get('/', function () {
    $preferredWelcomeView = Setting::getValue('preferred_welcome_view', 'welcome');

    if (!View::exists($preferredWelcomeView)) {
        $preferredWelcomeView = 'welcome';
    }

    return view($preferredWelcomeView);
})->name('home');

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
        Route::delete('usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');

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

        //settings
        Route::post('settings/update-welcome-view', [SettingsController::class, 'updateWelcomeView'])
            ->name('settings.updateWelcomeView');
        //Almacen
        Route::get('almacen', [AlmacenController::class, 'adminIndex'])->name('almacen.index');
        Route::get('almacen/crear', [AlmacenController::class, 'create'])->name('almacen.create');
        Route::post('almacen', [AlmacenController::class, 'store'])->name('almacen.store');
        Route::get('almacen/{producto}/editar', [AlmacenController::class, 'edit'])->name('almacen.edit');
        Route::put('almacen/{almacen}', [AlmacenController::class, 'update'])->name('almacen.update');
        Route::delete('almacen/{almacen}', [AlmacenController::class, 'destroy'])->name('almacen.destroy');
    });

// ----------------------
// RUTAS ADMIN ENTRENADOR
// ----------------------
Route::middleware(['auth', 'verified', 'can:admin_entrenador', VerificarUsuarioActivo::class])
    ->prefix('admin-entrenador')
    ->name('admin-entrenador.')
    ->group(function () {
        Route::get('/', [AdminEntrenadorController::class, 'dashboard'])->name('dashboard');

        // Gestión de clases grupales
        Route::get('clases', [AdminEntrenadorController::class, 'verClases'])->name('clases.index');
        Route::get('clases/create', [AdminEntrenadorController::class, 'create'])->name('clases.create');
        Route::post('clases', [AdminEntrenadorController::class, 'store'])->name('clases.store');
        Route::get('clases/{clase}/edit', [AdminEntrenadorController::class, 'edit'])->name('clases.edit');
        Route::put('clases/{clase}', [AdminEntrenadorController::class, 'update'])->name('clases.update');
        Route::delete('clases/{clase}', [AdminEntrenadorController::class, 'destroy'])->name('clases.destroy');
        Route::put('clase/{id}/aprobar', [AdminEntrenadorController::class, 'aprobarCambios'])->name('clases.aprobar');

        // Gestión de clases individuales
        Route::get('clases-individuales', [ClaseIndividualController::class, 'index'])->name('clases-individuales.index');
        Route::get('clases-individuales/create', [ClaseIndividualController::class, 'create'])->name('clases-individuales.create');
        Route::post('clases-individuales', [ClaseIndividualController::class, 'store'])->name('clases-individuales.store');
        Route::get('clases-individuales/{claseIndividual}/edit', [ClaseIndividualController::class, 'edit'])->name('clases-individuales.edit');
        Route::put('clases-individuales/{claseIndividual}', [ClaseIndividualController::class, 'update'])->name('clases-individuales.update');
        Route::delete('clases-individuales/{claseIndividual}', [ClaseIndividualController::class, 'destroy'])->name('clases-individuales.destroy');

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
        Route::get('solicitudes', [AdminEntrenadorController::class, 'verTodasSolicitudes'])->name('solicitudes.index');
        Route::post('solicitudes/{id}/aceptar', [AdminEntrenadorController::class, 'aceptarSolicitud'])->name('solicitudes.aceptar');
        Route::post('solicitudes/{id}/rechazar', [AdminEntrenadorController::class, 'rechazarSolicitud'])->name('solicitudes.rechazar');
        Route::get('solicitudes-entrenamientos', [AdminEntrenadorController::class, 'verSolicitudesEntrenamientos'])->name('solicitudes-entrenamientos.index');
        Route::post('solicitudes-entrenamientos/{id}/aceptar', [AdminEntrenadorController::class, 'aceptarSolicitudEntrenamiento'])->name('solicitudes-entrenamientos.aceptar');
        Route::post('solicitudes-entrenamientos/{id}/rechazar', [AdminEntrenadorController::class, 'rechazarSolicitudEntrenamiento'])->name('solicitudes-entrenamientos.rechazar');


        // Gestión de entrenamientos
 Route::resource('entrenamientos', \App\Http\Controllers\AdminEntrenador\AdminEntrenamientoController::class);
        Route::get('entrenamientos/{id}/usuarios', [\App\Http\Controllers\AdminEntrenador\AdminEntrenamientoController::class, 'usuariosGuardaron'])
            ->name('entrenamientos.usuarios');


        // Suscripciones de usuarios
        Route::get('users/{id}/suscripciones', [SuscripcionController::class, 'index'])->name('users.suscripciones');
        Route::get('/charts', [ChartController::class, 'index'])->name('charts');

        //Gestion de dietas
        Route::get('dietas', [AdminEntrenadorController::class, 'indexDietas'])->name('dietas.index');
        Route::get('dietas/crear', [AdminEntrenadorController::class, 'createDieta'])->name('dietas.create');
        Route::post('dietas', [AdminEntrenadorController::class, 'storeDieta'])->name('dietas.store');
        Route::get('dietas/{dieta}/editar', [AdminEntrenadorController::class, 'editDieta'])->name('dietas.edit');
        Route::put('dietas/{dieta}', [AdminEntrenadorController::class, 'updateDieta'])->name('dietas.update');
        Route::delete('dietas/{dieta}', [AdminEntrenadorController::class, 'destroyDieta'])->name('dietas.destroy');
    });

// ----------------------
// RUTAS DEL ENTRENADOR
// ----------------------
Route::middleware(['auth', 'verified', 'can:entrenador-access', VerificarUsuarioActivo::class])
    ->prefix('entrenador')
    ->name('entrenador.')
    ->group(function () {
        Route::get('/dashboard', [EntrenadorController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/estados-clases', [EntrenadorController::class, 'obtenerEstadosClases'])->name('dashboard.clases_estados');

        // Gestión de clases
        Route::get('clases', [EntrenadorIndividual::class, 'index'])->name('clases.index');
        Route::get('clases-individuales/create', [EntrenadorIndividual::class, 'create'])->name('clases-individuales.create');
        Route::post('clases-individuales', [EntrenadorIndividual::class, 'store'])->name('clases-individuales.store');
        Route::get('clases-individuales/{claseIndividual}/edit', [EntrenadorIndividual::class, 'edit'])->name('clases-individuales.edit');
        Route::put('clases-individuales/{claseIndividual}', [EntrenadorIndividual::class, 'update'])->name('clases-individuales.update');
        Route::get('clases/{tipo}/{id}/alumnos', [EntrenadorIndividual::class, 'verAlumnos'])->name('clases.alumnos');
        Route::get('clases/grupales/{id}', [EntrenadorIndividual::class, 'showGrupal'])->name('clases.grupales.show');
        Route::get('clases/individuales/{id}', [EntrenadorIndividual::class, 'showIndividual'])->name('clases.individuales.show');
        // Entrenamientos
        Route::get('entrenamientos', [EntrenamientoController::class, 'index'])->name('entrenamientos.index');
        Route::get('entrenamientos/create', [EntrenamientoController::class, 'create'])->name('entrenamientos.create');
        Route::post('entrenamientos', [EntrenamientoController::class, 'store'])->name('entrenamientos.store');
        Route::get('entrenamientos/{entrenamiento}/edit', [EntrenamientoController::class, 'edit'])->name('entrenamientos.edit');
        Route::put('entrenamientos/{entrenamiento}', [EntrenamientoController::class, 'update'])->name('entrenamientos.update');
        Route::get('entrenamientos/{id}/usuarios', [EntrenamientoController::class, 'usuariosGuardaron'])->name('entrenamientos.usuarios');
        Route::post('entrenamientos/{entrenamiento}/asignar-usuarios', [EntrenamientoController::class, 'asignarUsuarios'])
        ->name('entrenamientos.asignarUsuarios');

        // Solicitudes
        Route::get('solicitudes', [EntrenadorController::class, 'verSolicitudesPendientes'])->name('solicitudes.index');
        Route::post('solicitudes/aceptar/{id}', [EntrenadorController::class, 'aceptarSolicitud'])->name('solicitudes.aceptar');
        Route::post('solicitudes/rechazar/{id}', [EntrenadorController::class, 'rechazarSolicitud'])->name('solicitudes.rechazar');

        // Perfil del entrenador
        Route::get('/perfil', [InstructorController::class, 'show'])->name('profile.show');
        Route::get('/perfil/crear', [InstructorController::class, 'create'])->name('profile.create');
        Route::post('/perfil/crear', [InstructorController::class, 'store'])->name('profile.store');
        Route::get('/perfil/editar', [InstructorController::class, 'edit'])->name('profile.edit');
        Route::post('/perfil/editar', [InstructorController::class, 'update'])->name('profile.update');
    });


// ----------------------
// RUTAS DEL Cliente
// ----------------------
Route::middleware(['auth', VerificarUsuarioActivo::class])
    ->prefix('cliente')
    ->name('cliente.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Clases
        Route::get('clases', [DashboardController::class, 'index'])->name('clases.index');
        Route::post('clases/{clase}/unirse', [DashboardController::class, 'unirse'])->name('clases.unirse');

        // Entrenamientos - listado, guardar, quitar, planificar
        Route::get('entrenamientos', [FaseEntrenamientoController::class, 'index'])->name('entrenamientos.index');
        Route::post('entrenamientos/{id}/guardar', [DashboardController::class, 'guardarEntrenamiento'])->name('entrenamientos.guardar');
        Route::post('entrenamientos/{id}/quitar', [DashboardController::class, 'quitarEntrenamiento'])->name('entrenamientos.quitar');
        Route::get('entrenamientos/{entrenamiento}/planificar', [FaseEntrenamientoController::class, 'planificar'])->name('entrenamientos.planificar');

        // Fases de entrenamiento
        Route::prefix('entrenamientos/{entrenamiento}/fases-dias')->group(function () {
            Route::get('/', [FaseEntrenamientoController::class, 'index'])->name('entrenamientos.fases-dias');
            Route::post('/', [FaseEntrenamientoController::class, 'store'])->name('entrenamientos.fases-dias.store');
        });

        // Operaciones sobre un día específico (fuera del grupo anterior)
        Route::patch('fases-dias/{dia}', [FaseEntrenamientoController::class, 'updateEstado'])->name('entrenamientos.fases-dias.updateEstado');
        Route::delete('fases-dias/{dia}', [FaseEntrenamientoController::class, 'destroy'])->name('entrenamientos.fases-dias.destroy');
        // Perfil historial
        Route::get('perfil-historial', function () {
            return view('perfil.historial');
        })->name('perfil.historial');
        Route::get('perfil/editar', [PerfilController::class, 'editar'])->name('profile.edit');
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
        //Mis compras
        Route::get('/mis-compras', [CompraController::class, 'index'])->name('compras.index');
        //Detalles de compra
        Route::get('/compras/{compra}', [CompraController::class, 'show'])->name('compras.show');
        //factura pdf de compra
        Route::get('/compras/{compra}/factura/pdf', [CheckoutController::class, 'generarFacturaPdf'])->name('factura.pdf.generar');
    });
//Compras admin
Route::prefix('admin/compras')
    ->name('admin.compras.')
    ->group(function () {
        //Compras de usuarios
        Route::get('/', [CompraController::class, 'adminIndex'])->name('index');
        //Detalles de compra para admin
        Route::get('/{compra}', [CompraController::class, 'adminShow'])->name('show');
    });

// ----------------------
// RUTAS DE TIENDA
// ----------------------
Route::prefix('tienda')
    ->name('tienda.')
    ->group(function () {
        Route::get('/', [AlmacenController::class, 'tiendaIndex'])->name('index');
    });
// ----------------------
// RUTAS DE CARRITO
// ----------------------
Route::middleware('auth')
    ->prefix('carrito')
    ->name('carrito.')
    ->controller(CarritoController::class)
    ->group(function () {
        //Añadir producto al carrito
        Route::post('/agregar/{almacen_id}', 'agregar')->name('agregar');
        //ver productos de almacen
        Route::get('/', 'view')->name('view');
        //actualizar productos en carrito
        Route::post('/actualizar/{almacen_id}', 'actualizar')->name('actualizar');
        //eliminar productos de carrito
        Route::post('/eliminar/{almacen_id}', 'eliminar')->name('eliminar');
        //vaciar productos de carrito
        Route::post('/vaciar', 'vaciar')->name('vaciar');
    });
// ----------------------
// RUTAS DE CONFIRMACION DE COMPRA
// ----------------------
Route::middleware('auth')
    ->prefix('checkout')
    ->name('checkout.')
    ->group(function () {
        //vista de validacion de compra
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        //proceso de compra
        Route::post('/procesar', [CheckoutController::class, 'procesar'])->name('procesar');
    });
