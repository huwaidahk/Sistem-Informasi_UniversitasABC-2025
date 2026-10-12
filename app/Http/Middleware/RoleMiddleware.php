<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param string $role Role yang disyaratkan dari route (e.g., 'administrator' atau 'tendik').
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Periksa apakah pengguna sudah login
        if (!Auth::check()) {
            // Jika belum login, arahkan ke halaman login
            return redirect('/login'); 
        }

        // Ambil role pengguna saat ini dan pastikan ia lowercase untuk perbandingan yang aman
        $userRole = strtolower(Auth::user()->role);
        
        // 2. IZINKAN AKSES PENUH UNTUK ADMINISTRATOR
        // Administrator berhak mengakses route apapun, termasuk route Tendik.
        if ($userRole === 'administrator') {
            return $next($request);
        }

        // 3. Jika bukan Admin, cek apakah role pengguna cocok dengan role yang disyaratkan di route
        // Bandingkan role pengguna dengan role yang disyaratkan (juga di lowercase)
        if ($userRole !== strtolower($role)) {
            // Akses ditolak jika role pengguna tidak cocok
            abort(403, 'Akses Ditolak. Anda tidak memiliki hak akses untuk halaman ini.');
        }

        return $next($request);
    }
}