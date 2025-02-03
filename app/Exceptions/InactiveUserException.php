<?php

namespace App\Exceptions;

use Exception;

class InactiveUserException extends Exception {
    protected $message = 'Usuario inactivo';
    protected $code = 403;
}
