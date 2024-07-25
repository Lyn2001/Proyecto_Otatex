<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     return $next($request);
    // }
    public function handle($request, Closure $next)
    {
        // Obtener la última actividad de la sesión o establecerla en 0 si no existe
        $lastActivity = session('last_activity', 0);
        $sessionLifetime = config('session.lifetime') * 60; // Convertir minutos a segundos

        // Verificar si ha pasado el tiempo de vida de la sesión
        if (time() - $lastActivity > $sessionLifetime) {
            Auth::logout(); // Cerrar sesión
            return redirect('/login')->with('message', 'Sesión caducada. Por favor, inicia sesión nuevamente.');
        }

        // Actualizar la última actividad en la sesión
        session(['last_activity' => time()]);

        return $next($request);
    }
}
