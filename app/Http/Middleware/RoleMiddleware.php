<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        $user = Auth::user();
        $usuario = Usuario::where('email', $user->email)->first();
        
        if (!$usuario || $usuario->rol !== $role) {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }
        
        return $next($request);
    }
}
