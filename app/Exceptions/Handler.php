<?php

namespace App\Exceptions;

use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\InactiveUserException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Lista de tipos de excepciones que no son reportadas.
     * Esto evita que ciertas excepciones aparezcan en los logs.
     */
    protected $dontReport = [
        //
    ];

    /**
     * Lista de inputs que nunca serán guardados en la sesión durante excepciones de validación.
     * Esto protege información sensible como contraseñas.
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Registra los callbacks para el manejo de excepciones personalizadas.
     */
    public function register(): void
    {
        // Manejo de la excepción de credenciales inválidas.
        $this->renderable(function (InvalidCredentialsException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        });

        // Manejo de la excepción de usuario inactivo.
        $this->renderable(function (InactiveUserException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        });

        // Manejo de la misma excepción pero con el namespace completo.
        $this->renderable(function (\App\Exceptions\InactiveUserException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        });
    }
}
