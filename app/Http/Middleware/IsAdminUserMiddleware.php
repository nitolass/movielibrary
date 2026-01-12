<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdminUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        //Auth::check -> compruebo si el usuario esta autenticado
        //$request->user() -> obtengo el usuario autenticado

        if(!Auth::check()){
            abort(403, 'Inicia sesion para acceder a esta area');
        }

        if(!$request->user()->isAdmin()){
            abort(403, 'No tienes permisos para acceder a esta area');
        }

        return $next($request);
    }
}
