<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login.superuser.form');
        }

        $user = Auth::user();
        
        // Check if user has the required role through the user_roles table
        $hasRole = DB::table('user_roles')
            ->join('roles', 'user_roles.role_id', '=', 'roles.id')
            ->where('user_roles.user_id', $user->id)
            ->where('roles.slug', $role)
            ->exists();
            
        if ($hasRole) {
            return $next($request);
        }

        return redirect()->route('before-login')->with('error', 'You do not have permission to access this page');
    }
}
