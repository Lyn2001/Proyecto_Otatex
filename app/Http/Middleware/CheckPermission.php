<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission)
    {
    //     $user = auth()->user();

    //     if (!$user) {
    //         return response('Unauthorized', 401);
    //     }

    //     if (!$user->hasPermission($permission)) {
    //         return response('Forbidden: You do not have the required permission', 403);
    //     }

    //     return $next($request);
    // }
    }
}
