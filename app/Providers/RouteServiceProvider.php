<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Método boot que se ejecuta automáticamente cuando la aplicación se inicia.
     * Aquí se llama al método para configurar la limitación de tasas.
     */
    public function boot(): void
    {
        // Configura la limitación de solicitudes a la API.
        $this->configureRateLimiting();
    }

    /**
     * Método para configurar la limitación de solicitudes en la API.
     */
    protected function configureRateLimiting(): void
    {
        // Define una regla de limitación para la API.
        RateLimiter::for('api', function (Request $request) {
            // Permite un máximo de 60 solicitudes por minuto por cada dirección IP.
            return Limit::perMinute(60)->by($request->ip());
        });
    }
}
