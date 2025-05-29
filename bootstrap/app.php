<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RequireVerifiedEmail; // Middleware personalizado para verificar correos electrónicos

// Configuración de la aplicación
return Application::configure(basePath: dirname(__DIR__)) // Configura la aplicación con el directorio base
    ->withRouting(
        web: __DIR__.'/../routes/web.php',      // Rutas web
        api: __DIR__.'/../routes/api.php',      // Rutas API
        commands: __DIR__.'/../routes/console.php', // Comandos de consola
        health: '/up',                          // Ruta de verificación de salud del sistema
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Registrar middleware global
        $middleware->append(RequireVerifiedEmail::class); // Agregar middleware que requiere un correo electrónico verificado
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Configuración para manejar excepciones (actualmente vacío)
    })->create();  // Crear instancia de aplicación