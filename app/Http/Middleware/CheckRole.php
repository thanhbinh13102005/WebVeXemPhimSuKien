<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Dang ky trong bootstrap/app.php (Laravel 11) hoac app/Http/Kernel.php (Laravel 10)
// voi alias "role" => \App\Http\Middleware\CheckRole::class
class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!auth()->check() || auth()->user()->role !== $role) {
            abort(403, 'Ban khong co quyen truy cap trang nay.');
        }

        return $next($request);
    }
}
