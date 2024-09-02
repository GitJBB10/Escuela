<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission): Response
    {
        $user = Auth::user();

        // Mostrar qué permisos tiene el usuario y el permiso que se está verificando
    \Log::info('Verificando permiso:', [
        'user_permissions' => $user->getAllPermissions()->pluck('name')->toArray(),
        'checking_for' => $permission,
        'Permiso API' => $user->hasPermissionTo($permission,'api'),
    ]);

    // Revisar el resultado del método can
    if ($user && $user->can($permission, 'api')) {
        \Log::info('Permiso concedido:', ['permission' => $permission]);
        return $next($request);
    }

    //\Log::warning('Permiso denegado:', ['permission' => $permission]);
    return response()->json([
        'message' => 'No tienes permiso para realizar esta acción'
    ], 403);
    }
}
