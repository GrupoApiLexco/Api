<?php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;

// Configuración principal de la aplicación Laravel
return Application::configure(basePath: dirname(__DIR__))
    // Configuración de rutas
    ->withRouting(
        web: __DIR__.'/../routes/web.php',      // Rutas web (vistas)
        api: __DIR__.'/../routes/api.php',      // Rutas API
        commands: __DIR__.'/../routes/console.php', // Comandos de consola
        health: '/up',                          // Endpoint de verificación de salud
    )
    
    // Configuración de middleware
    ->withMiddleware(function (Middleware $middleware) {
        // Grupo de middleware para rutas API
        $middleware->group('api', [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class, // Habilita autenticación stateful para APIs
            \Illuminate\Routing\Middleware\SubstituteBindings::class, // Permite inyección de modelos en rutas
        ]);
        
        // Alias para middlewares personalizados
        $middleware->alias([
            'check_active' => \App\Http\Middleware\CheckActiveUser::class, // Middleware para verificar usuario activo
        ]);
    })
    
    // Configuración de manejo de excepciones (personalizable)
    ->withExceptions(function () {
        //
    })
    
    // Crear la instancia de la aplicación
    ->create();
