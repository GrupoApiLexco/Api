<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica si el usuario autenticado tiene el rol de administrador
        if ($request->user()?->role !== 'admin') {
            // Si el usuario no es administrador, devuelve un error de acceso no autorizado
            return response()->json([
                'message' => 'Acceso no autorizado'
            ], 403);
        }

        // Si el usuario es administrador, permite continuar con la solicitud
        return $next($request);
    }
}
