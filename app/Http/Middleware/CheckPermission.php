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
     * @param  string  $modulo - El módulo a verificar (ej: 'usuarios', 'perfiles')
     * @param  string  $accion - La acción a verificar (ej: 'crear', 'editar', 'eliminar', 'ver')
     */
    public function handle(Request $request, Closure $next, string $modulo, string $accion = 'ver'): Response
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }

        $user = auth()->user();

        // Si el usuario no tiene perfil asignado, denegar acceso
        if (!$user->perfil) {
            abort(403, 'No tienes permisos para acceder a esta página. Contacta al administrador para que te asigne un perfil.');
        }

        // Si el perfil no está activo, denegar acceso
        if (!$user->perfil->activo) {
            abort(403, 'Tu perfil está inactivo. Contacta al administrador.');
        }

        // Verificar si el usuario tiene el permiso específico
        $hasPermission = $user->tienePermiso($modulo, $accion);

        if (!$hasPermission) {
            abort(403, "No tienes permisos para {$accion} en el módulo de {$modulo}.");
        }

        return $next($request);
    }
}
