<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class CustomAuthenticateMiddleware extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    protected function redirectTo($request): ?string
    {
        // Hanya redirect jika permintaan bukan JSON (misalnya API)
        if (!$request->expectsJson()) {
            // Jika sudah login, redirect sesuai role, jika belum login, arahkan ke halaman login
            if (!Auth::check()) {
                Session::flash('warning', 'Maaf, anda harus login terlebih dahulu!');
                return route('login.index'); // jika belum login
            }

            // Jika sudah login, redirect berdasarkan role user
            $user = Auth::user();
            switch ($user->user_role) {
                case 'admin':
                    return route('admin.shippings.index'); // admin route
                case 'korlap':
                    return route('admin.assignees.index'); // korlap route
                case 'kurir':
                    return route('admin.assignees.index'); // kurir route
                default:
                    Auth::logout();
                    Session::flash('warning', 'Peran pengguna tidak valid.');
                    return route('login.index');
            }
        }

        return null;
    }
}
