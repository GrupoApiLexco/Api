<?php

namespace App\Exceptions;

use Exception;

class InvalidCredentialsException extends Exception {
    // Mensaje de error predeterminado cuando se lanza esta excepción
    protected $message = 'Credenciales inválidas';

    // Código de error HTTP asociado a esta excepción (422 para errores de validación )
    protected $code = 422;
}
