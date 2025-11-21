<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckToken
{
    public function handle(Request $request, Closure $next, $type = null)
    {
        $hasToken = $request->session()->has('api_token');

        if ($type === 'auth' && !$hasToken) {
            // Butuh token tapi tidak ada → redirect login
            return redirect()->route('login');
        }

        if ($type === 'guest' && $hasToken) {
            // Harus guest tapi token ada → redirect dashboard
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
