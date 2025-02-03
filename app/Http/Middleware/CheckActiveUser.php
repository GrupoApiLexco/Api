<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class CheckActiveUser
{
    public function handle(Request $request, Closure $next) {
        $user = $request->user();
        
        if (!$user || $user->status != User::STATUS_ACTIVE) { // Usar == en lugar de ===
            return response()->json(['message' => 'Cuenta inactiva'], 403);
        }
        
        return $next($request);
    }
}
