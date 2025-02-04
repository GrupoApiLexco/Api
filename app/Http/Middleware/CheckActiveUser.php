<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class CheckActiveUser
{
    /**
     * Maneja la solicitud entrante y verifica si el usuario está activo.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud HTTP.
     * @param  \Closure  $next  La siguiente acción a ejecutar en la aplicación.
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next) {
        $user = $request->user(); //  Obtiene el usuario autenticado desde la solicitud.

        //  Verifica si el usuario está autenticado y si su estado es inactivo
        if (!$user || $user->status != User::STATUS_ACTIVE) {
            return response()->json(['message' => 'Cuenta inactiva'], 403); //  Devuelve error 403 (Forbidden) si el usuario no está activo.
        }

        return $next($request); //  Si el usuario está activo, continúa con la solicitud.
    }
}

//Este middleware se encarga de verificar si el usuario autenticado tiene el estado activo antes de permitir el acceso a ciertas rutas protegidas.
