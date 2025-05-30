<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use App\Models\UserDocument;

class LoginController extends Controller
{
    protected $redirectTo = '/';
    protected $roleRedirects = [
        'admin-rs' => '/rs/dashboard',
        'admin-pmi' => '/pmi/dashboard',
        'super-admin' => '/document-verification'
    ];

    public function __construct()
    {
        // No middleware here, we'll handle auth checks in the routes
    }

    public function showLoginForm()
    {
        return view('Auth.login');
    }

    public function login(Request $request)
    {
        // If role is provided from the role-selection page, show the login form for that role
        if ($request->has('role') && !$request->has('email')) {
            $role = $request->input('role');
            $roleName = '';
            
            switch ($role) {
                case 'hospital_admin':
                    $roleName = 'Hospital Admin';
                    break;
                case 'pmi_admin':
                    $roleName = 'PMI Admin';
                    break;
                case 'super_admin':
                    $roleName = 'Super User';
                    break;
                default:
                    return redirect()->route('login');
            }
            
            return view('Auth.login-form', ['role' => $role, 'roleName' => $roleName]);
        }
        
        // Normal login process with email and password
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Get user roles through the pivot table
            $userRoles = DB::table('user_roles')
                ->join('roles', 'user_roles.role_id', '=', 'roles.id')
                ->where('user_roles.user_id', $user->id)
                ->pluck('roles.slug')
                ->toArray();
            
            // Check if user has the selected role
            if ($request->has('role')) {
                $selectedRole = $request->input('role');
                $hasRole = false;
                
                switch ($selectedRole) {
                    case 'hospital_admin':
                        $hasRole = in_array('admin-rs', $userRoles);
                        break;
                    case 'pmi_admin':
                        $hasRole = in_array('admin-pmi', $userRoles);
                        break;
                    case 'super_admin':
                        $hasRole = in_array('super-admin', $userRoles);
                        break;
                }
                
                if (!$hasRole) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    
                    return redirect()->route('login')
                        ->with('error', 'You do not have permission to access this role.');
                }
            }
            
            // Super admins bypass verification
            if (in_array('super-admin', $userRoles)) {
                return redirect()->intended($this->redirectTo);
            }
            
            // Check document verification status
            $document = UserDocument::where('user_id', $user->id)->first();
            
            if (!$document) {
                // No document found - this shouldn't happen normally
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect()->route('login')
                    ->with('error', 'Dokumen verifikasi tidak ditemukan. Silakan hubungi administrator.');
            }
            
            // Check verification status
            if ($document->verification_status === 'pending' || $document->is_verified === null) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect()->route('login')
                    ->with('warning', 'Akun Anda sedang dalam proses verifikasi. Mohon tunggu persetujuan dari admin.');
            } else if ($document->verification_status === 'rejected' || $document->is_verified === false) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect()->route('login')
                    ->with('error', 'Verifikasi akun Anda ditolak. Silakan hubungi administrator untuk informasi lebih lanjut.');
            }
            
            // If we get here, the account is verified
            // Determine the redirect path based on user role
            $redirectPath = $this->redirectTo; // Default redirect
            
            // Find the first matching role redirect
            foreach ($this->roleRedirects as $role => $path) {
                if (in_array($role, $userRoles)) {
                    $redirectPath = $path;
                    break;
                }
            }
            
            return redirect()->intended($redirectPath)
                ->with('success', 'Login berhasil. Selamat datang di dashboard Sahabat Darah.');
        }

        // Check if the user exists with the provided email
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            // User doesn't exist - they need to register
            return back()->with('error', 'Akun tidak ditemukan. Silakan mendaftar terlebih dahulu.')->onlyInput('email');
        }
        
        // User exists but password is wrong
        return back()->with('error', 'Email atau password yang Anda masukkan salah. Silakan coba lagi.')->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
