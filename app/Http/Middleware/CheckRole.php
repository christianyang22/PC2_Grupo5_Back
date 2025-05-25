<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    public function handle(Request $request, Closure $next, $requiredRoleId)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if ($user && $user->rol == $requiredRoleId) {
                Log::info('Usuario autorizado con rol ID: ' . $user->rol);
                return $next($request);
            }

            Log::warning('Usuario no autorizado. Rol recibido: ' . ($user->rol ?? 'desconocido'));
            return response()->json(['error' => 'Unauthorized'], 403);

        } catch (JWTException $e) {
            Log::error('Error en middleware CheckRole: ' . $e->getMessage());
            return response()->json(['error' => 'Token inválido o no proporcionado'], 401);
        }
    }
}