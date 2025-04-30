<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login.index');
        }

        $user = Auth::user();
        // dd($roles);
        if (!in_array($user->user_role, $roles)) {
            switch ($user->user_role) {
                case 'admin':
                    return redirect()->route('admin.shippings.index');
                case 'korlap':
                    return redirect()->route('admin.couriers.index');
                case 'kurir':
                    return redirect()->route('admin.locations.index');
                default:
                    Auth::logout();
                    abort(403, 'Unauthorized role.');
            }
        }

        return $next($request);
    }
}
