<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        Log::info('RoleMiddleware: Checking authentication', ['url' => $request->fullUrl()]);
        if (!Auth::check()) {
            Log::info('RoleMiddleware: User not authenticated, redirecting to login');
            return redirect()->route('login.pmi.form')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        Log::info('RoleMiddleware: User authenticated', ['user_id' => $user->id, 'email' => $user->email]);
        Log::info('RoleMiddleware: Checking role', ['user_id' => $user->id, 'requested_role' => $role]);
        
        // Check if user has the required role through the user_roles table
        $hasRole = DB::table('user_roles')
            ->join('roles', 'user_roles.role_id', '=', 'roles.id')
            ->where('user_roles.user_id', $user->id)
            ->where('roles.slug', $role)
            ->exists();
            
        if (!$hasRole) {
            Log::warning('RoleMiddleware: User does not have required role', ['user_id' => $user->id, 'requested_role' => $role]);
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Redirect based on role
            if ($role === 'admin-pmi') {
                Log::info('RoleMiddleware: Redirecting Admin PMI login form');
                return redirect()->route('login.pmi.form')
                    ->with('error', 'Anda tidak memiliki akses sebagai Admin PMI.');
            } elseif ($role === 'admin-rs') {
                 Log::info('RoleMiddleware: Redirecting Admin RS login form');
                return redirect()->route('login.rs.form')
                    ->with('error', 'Anda tidak memiliki akses sebagai Admin Rumah Sakit.');
            } else {
                 Log::info('RoleMiddleware: Redirecting Super Admin login form');
                return redirect()->route('login.superuser.form')
                    ->with('error', 'Anda tidak memiliki akses sebagai Super Admin.');
            }
        }

        Log::info('RoleMiddleware: User has required role', ['user_id' => $user->id, 'role' => $role]);

        // Check if user is approved
        Log::info('RoleMiddleware: Checking user status', ['user_id' => $user->id, 'status' => $user->status]);
        if ($user->status !== 'approved') {
            Log::warning('RoleMiddleware: User status is not approved', ['user_id' => $user->id, 'status' => $user->status]);
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Log::info('RoleMiddleware: Redirecting to login form due to unapproved status');
            return redirect()->route('login.pmi.form')
                ->with('warning', 'Akun Anda belum disetujui. Silakan tunggu persetujuan admin.');
        }

        Log::info('RoleMiddleware: User has required role and is approved. Proceeding...');
        
        // Clear any existing session data
        $request->session()->forget(['error', 'warning', 'success']);
        
        // Regenerate session to prevent session fixation
        $request->session()->regenerate();
        
        return $next($request);
    }
}
