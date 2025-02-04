<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class RateLimitServiceProvider extends ServiceProvider
{
    /**
     * Método boot que se ejecuta automáticamente cuando se inicia la aplicación.
     * Aquí se define la limitación de solicitudes para la API.
     */
    public function boot(): void
    {
        // Definir reglas de limitación para las solicitudes a la API.
        RateLimiter::for('api', function (Request $request) {
            // Permitir hasta 600 solicitudes por minuto por cada dirección IP.
            return Limit::perMinute(600)->by($request->ip());
        });
    }
}
