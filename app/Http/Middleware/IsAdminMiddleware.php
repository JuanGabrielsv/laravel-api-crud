<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Comprobamos si el usuario está autenticado Y si su propiedad 'role' es 'admin'.
        if ($request->user() && $request->user()->role === 'admin') {
            // Si es un admin, le dejamos pasar a la siguiente capa (el controlador).
            return $next($request);
        }

        // Si no es un admin, bloqueamos la petición y devolvemos un error 403 Forbidden.
        return response()->json([
            'message' => 'Acceso denegado. Se requiere rol de administrador.'
        ], 403);
    }
}
