<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permission): Response
    {
        foreach ($permission as $p) {
            if (auth()->user()->hasPermissionTo($p))
            {
                return $next($request);
            }
        }
        Auth::logout();
        abort(403, 'Unauthorized action.');
        // return redirect()->with('error', 'Bạn không có quyền truy cập trang này.');
    }
}
