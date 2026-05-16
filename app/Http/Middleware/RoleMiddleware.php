<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Cek apakah user yang login memiliki role yang sesuai.
     * Jika tidak, redirect ke dashboard sesuai role-nya.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Role yang diizinkan (bisa lebih dari satu)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = Auth::user();

        // Jika role user tidak termasuk dalam daftar yang diizinkan
        if (!in_array($user->role, $roles)) {
            // Redirect ke dashboard sesuai role user yang sebenarnya
            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'mitra' => redirect()->route('mitra.dashboard'),
                default => redirect()->route('user.dashboard'),
            };
        }

        return $next($request);
    }
}
