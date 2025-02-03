<?php

namespace App\Exceptions;

use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\InactiveUserException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Lista de tipos de excepciones que no son reportadas
     */
    protected $dontReport = [
        //
    ];

    /**
     * Lista de inputs que nunca serán guardados en la sesión durante excepciones de validación
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Registra los callbacks para el manejo de excepciones
     */
    public function register(): void
{
    $this->renderable(function (InvalidCredentialsException $e) { // Sin namespace completo
        return response()->json([
            'error' => $e->getMessage()
        ], $e->getCode());
    });

    $this->renderable(function (InactiveUserException $e) { // Sin namespace completo
        return response()->json([
            'error' => $e->getMessage()
        ], $e->getCode());
    });

    $this->renderable(function (\App\Exceptions\InactiveUserException $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], $e->getCode());
    });
}

}
