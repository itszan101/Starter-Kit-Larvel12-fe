<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $permission = null): Response
    {
        // Ambil daftar permission dari session
        $userPermissions = session('user_permissions', []);

        // Jika tidak ada permission tertentu di middleware, lanjut saja
        if (!$permission) {
            return $next($request);
        }

        // Jika user tidak memiliki permission tersebut → abort 403
        if (!in_array($permission, $userPermissions)) {
            abort(403, 'You do not have permission to access this resource.');
        }

        return $next($request);
    }
}
