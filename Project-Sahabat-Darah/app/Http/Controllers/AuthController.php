<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RumahSakit;
use App\Models\PMI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // Import Str class
use Illuminate\Support\Facades\Log;
use App\Models\Role; // Pastikan model Role ada
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Definisikan konstanta untuk role (atau gunakan variabel lingkungan)
    const ROLE_RS = 'admin-rs';
    const ROLE_PMI = 'admin-pmi';
    const ROLE_SUPERUSER = 'super-admin';

    /**
     * Fungsi untuk login user (semua role: rs, pmi, superuser)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'role' => [
                'required',
                'string',
                'in:' . implode(',', [self::ROLE_RS, self::ROLE_PMI, self::ROLE_SUPERUSER]),
            ],
            'remember' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');
        $requestedRole = $request->input('role');

        Log::info('Attempting general login', ['email' => $credentials['email'], 'role' => $requestedRole]);

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            Log::info('General login successful', ['email' => $user->email, 'user_id' => $user->id]);

            $userRoles = $user->roles->pluck('slug')->toArray();

            Log::info('User roles from pivot table', ['email' => $user->email, 'roles' => $userRoles]);

            if (!in_array($requestedRole, $userRoles)) {
                Log::warning('User does not have the requested role', ['email' => $user->email, 'requested_role' => $requestedRole, 'user_roles' => $userRoles]);
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->back()->withErrors(['email' => 'Anda tidak memiliki akses untuk role ini.'])->withInput();
            }

            if ($requestedRole === self::ROLE_SUPERUSER) {
                Log::info('Redirecting to superuser dashboard', ['email' => $user->email]);
                return redirect()->intended(route('admin.verification-dashboard'));
            } elseif ($requestedRole === self::ROLE_RS) {
                Log::info('Redirecting to RS dashboard', ['email' => $user->email]);
                return redirect()->intended('/rs/dashboard');
            } elseif ($requestedRole === self::ROLE_PMI) {
                Log::info('Redirecting to PMI dashboard', ['email' => $user->email]);
                return redirect()->intended('/pmi/dashboard');
            }

            Log::warning('User authenticated but requested role not matched, unexpected state', ['email' => $user->email, 'requested_role' => $requestedRole]);
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->back()->withErrors(['email' => 'Terjadi kesalahan otorisasi.'])->withInput();
        }

        Log::warning('General login failed: Invalid credentials', ['email' => $request->input('email')]);
        return redirect()->back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    /**
     * Fungsi untuk menangani registrasi berdasarkan role (web)
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleRegistration(Request $request)
    {
        $role = $request->input('role');

        if ($role === self::ROLE_RS) {
            return $this->registerRumahSakit($request);
        } elseif ($role === self::ROLE_PMI) {
            return $this->registerPMI($request);
        } else {
            return redirect()->route('register.form')->with('error', 'Role registrasi tidak valid.')->withInput();
        }
    }

    /**
     * Fungsi untuk registrasi Rumah Sakit
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerRumahSakit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',  // Gunakan 'name' sesuai dengan form Anda
            'email' => 'required|string|email|max:255|unique:rumah_sakits',
            'password' => 'required|string|min:6|confirmed',
            'alamat' => 'required|string',      // Gunakan 'alamat' sesuai dengan form Anda
            'telepon' => 'required|string',     // Gunakan 'telepon' sesuai dengan form Anda
            'document_imrs' => 'required|file|mimes:pdf|max:2048',
            'agree_terms' => 'required|accepted',
            'role' => 'required|in:rs', // Pastikan role sesuai
        ]);

        if ($validator->fails()) {
            return redirect()->route('register.form')->withErrors($validator)->withInput();
        }

        $path = $request->file('document_imrs')->store('document_rs', 'public');

        $rumahSakit = RumahSakit::create([
            'namainstitusi' => $request->name,      // Gunakan 'name'
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,    // Gunakan 'alamat'
            'telepon' => $request->telepon,   // Gunakan 'telepon'
            'dokumen' => $path, // Sesuaikan dengan nama kolom di database Anda
            'is_verified' => false,
        ]);

        User::create([
            'name' => $request->name,      // Gunakan 'name'
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => self::ROLE_RS,
            'rumah_sakit_id' => $rumahSakit->id,
            'status' => 'pending',
        ]);

        return redirect()->route('before-login')->with('success', 'Registrasi Rumah Sakit berhasil. Menunggu verifikasi admin.');
    }

    /**
     * Fungsi untuk registrasi PMI
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerPMI(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255', // Gunakan 'name' sesuai form
            'email' => 'required|string|email|max:255|unique:pmis',
            'password' => 'required|string|min:6|confirmed',
            'alamat' => 'required|string',     // Gunakan 'alamat' sesuai form
            'telepon' => 'required|string',    // Gunakan 'telepon' sesuai form
            'dokumen' => 'required|file|mimes:pdf|max:2048',
            'agree_terms' => 'required|accepted',
            'role' => 'required|in:pmi', // Pastikan role sesuai
        ]);

        if ($validator->fails()) {
            return redirect()->route('register.form')->withErrors($validator)->withInput();
        }

        $path = $request->file('document')->store('document_pmi', 'public');

        $pmi = PMI::create([
            'namainstitusi' => $request->name,    // Gunakan 'name'
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,       // Gunakan 'alamat'
            'telepon' => $request->telepon,  // Gunakan 'telepon'
            'dokumen' => $path,
            'is_verified' => false,
        ]);

        User::create([
            'namainstitusi' => $request->name,       // Gunakan 'name'
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => self::ROLE_PMI,
            'pmi_id' => $pmi->id,
            'status' => 'pending',
        ]);

        return redirect()->route('before-login')->with('success', 'Registrasi PMI berhasil. Menunggu verifikasi admin.');
    }

    /**
     * Fungsi untuk login superuser (web)
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginSuperuserWeb(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        Log::info('Attempting Super User login', ['email' => $credentials['email']]);

        if (Auth::attempt($credentials, $remember)) {
            Log::info('Super User login successful', ['email' => $credentials['email']]);
            $user = Auth::user();

            // Check if user has super-admin role
            // Use DB facade to check directly in the user_roles table
            $hasRole = \Illuminate\Support\Facades\DB::table('user_roles')
                ->join('roles', 'user_roles.role_id', '=', 'roles.id')
                ->where('user_roles.user_id', $user->id)
                ->where('roles.slug', self::ROLE_SUPERUSER)
                ->exists();

            if ($hasRole) {
                Log::info('User has Super Admin role', ['email' => $credentials['email']]);
                $request->session()->regenerate();
                return redirect()->route('admin.verification-dashboard');
            } else {
                Log::warning('Super User login successful but user does not have Super Admin role', ['email' => $credentials['email']]);
                Auth::logout();
                return redirect()->back()->withErrors(['email' => 'Anda tidak memiliki akses sebagai Super Admin.'])->withInput();
            }
        }

        Log::warning('Super User login failed', ['email' => $request->input('email')]);
        return redirect()->back()->withErrors(['email' => 'Email atau password salah untuk Super User.'])->withInput();
    }

    /**
     * Fungsi untuk login rumah sakit (web)
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginRSWeb(Request $request)
    {
        $credentials = $request->only('email', 'password'); // Hanya email dan password
        $remember = $request->boolean('remember');

        Log::info('Attempting RS login', ['email', $credentials['email']]);

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            Log::info('RS login successful', ['email' => $user->email, 'user_id' => $user->id]);

            // Debug: Log user's roles
            Log::info('User roles after successful RS login', ['email' => $user->email, 'roles' => $user->roles->pluck('slug')->toArray()]);

            // Check if user has the admin-rs role using the relationship
            if ($user->roles->contains('slug', self::ROLE_RS)) {
                 // Check if the user is verified
                 if ($user->status === 'approved') {
                    Log::info('User has RS Admin role and is approved', ['email' => $user->email]);
                    return redirect()->intended('/rs/dashboard');
                 } else {
                    Log::warning('User has RS Admin role but is not approved', ['email' => $user->email, 'status' => $user->status]);
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return redirect()->back()->withErrors(['email' => 'Akun Anda belum diverifikasi. Silakan tunggu verifikasi admin.'])->withInput();
                 }
            } else {
                Log::warning('User logged in but does not have RS Admin role', ['email' => $user->email]);
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->back()->withErrors(['email' => 'Anda tidak memiliki akses sebagai Admin Rumah Sakit.'])->withInput();
            }
        }

        Log::warning('RS login failed: Invalid credentials', ['email' => $request->input('email')]);
        return redirect()->back()->withErrors(['email' => 'Email atau password salah untuk Rumah Sakit.'])->withInput();
    }

    /**
     * Fungsi untuk login pmi (web)
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginPMIWeb(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        Log::info('Attempting PMI login', ['email' => $credentials['email']]);

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            Log::info('PMI login successful', ['email' => $user->email, 'user_id' => $user->id]);

            // Check if user has the admin-pmi role using the relationship
            if ($user->roles->contains('slug', self::ROLE_PMI)) {
                // Check if the user is approved
                if ($user->status === 'approved') {
                    Log::info('User has PMI Admin role and is approved', ['email' => $user->email]);
                    return redirect()->intended('/pmi/dashboard');
                } else {
                    Log::warning('User has PMI Admin role but is not approved', ['email' => $user->email, 'status' => $user->status]);
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return redirect()->back()->withErrors(['email' => 'Akun Anda belum diverifikasi. Silakan tunggu verifikasi admin.'])->withInput();
                }
            } else {
                Log::warning('User logged in but does not have PMI Admin role', ['email' => $user->email]);
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->back()->withErrors(['email' => 'Anda tidak memiliki akses sebagai Admin PMI.'])->withInput();
            }
        }

        Log::warning('PMI login failed: Invalid credentials', ['email' => $request->input('email')]);
        return redirect()->back()->withErrors(['email' => 'Email atau password salah untuk PMI.'])->withInput();
    }

    /**
     * Fungsi untuk logout user (web)
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logoutWeb(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/before-login');
    }

    /**
     * Fungsi untuk mendapatkan user yang sedang login (API)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLoggedInUser()
    {
        $user = Auth::user();
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}