<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticatedWithRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

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
