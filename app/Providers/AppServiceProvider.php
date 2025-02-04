<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Método para registrar servicios dentro de la aplicación.
     * Se usa cuando necesitamos vincular clases o interfaces dentro del contenedor de servicios de Laravel.
     */
    public function register(): void
    {
        // Aquí se pueden registrar servicios o dependencias en el contenedor de Laravel.
        // Se usa principalmente para inyección de dependencias y configuración de paquetes.
    }

    /**
     * Método que se ejecuta después de que todos los servicios han sido registrados.
     * Se utiliza para inicializar configuraciones adicionales.
     */
    public function boot(): void
    {
        // Aquí se pueden definir configuraciones globales, eventos o ajustes adicionales.
        // Se ejecuta automáticamente al iniciar la aplicación.
    }
}
