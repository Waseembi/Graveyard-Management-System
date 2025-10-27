<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;



class RoleAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (Auth::check()) {
            $role = Auth::user()->role_id;

            if ($role == 1) {
                return redirect()->route('admin.dashboard');
            }

            if ($role === 2) {
                return redirect()->route('user.dashboard');
            }
        }


        return $next($request);
    }
}
