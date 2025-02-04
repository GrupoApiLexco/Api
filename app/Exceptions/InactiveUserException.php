<?php

namespace App\Exceptions;

use Exception;

class InactiveUserException extends Exception {
    // Mensaje de error predeterminado cuando se lanza esta excepción
    protected $message = 'Usuario inactivo';

    // Código de error HTTP asociado a esta excepción (403 - Prohibido)
    protected $code = 403;
}
