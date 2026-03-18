<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('admin_logged_in')) {
            return redirect()->route('admin.login')
                ->with('error', 'Пожалуйста, войдите в админ-панель');
        }

        return $next($request);
    }
}
