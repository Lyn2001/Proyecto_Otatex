<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $userRole = Auth::user()->rol_id;

            // Permitir acceso al dashboard del administrador para ambos roles
            if ($userRole === 1 || $userRole === 3) {
                return $next($request);
            }
        }

        // Redirigir a una página de error o de inicio si no tiene permisos
        return redirect('/'); // Puedes redirigir a una página de error o de inicio
    }
}
