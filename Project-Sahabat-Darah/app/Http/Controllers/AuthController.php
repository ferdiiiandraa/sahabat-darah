<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // Import Str class

class AuthController extends Controller
{
    // Definisikan konstanta untuk role (atau gunakan variabel lingkungan)
    const ROLE_RS = 'rs';
    const ROLE_PMI = 'pmi';
    const ROLE_SUPERUSER = 'superuser';

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

        $credentials = $request->only('email', 'password', 'role');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            if ($request->role === self::ROLE_SUPERUSER) {
                return redirect()->intended('/superuser/dashboard'); // Sesuaikan
            } elseif ($request->role === self::ROLE_RS) {
                return redirect()->intended('/rs/dashboard'); // Sesuaikan
            } elseif ($request->role === self::ROLE_PMI) {
                return redirect()->intended('/pmi/dashboard'); // Sesuaikan
            }
        }

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
        $credentials['role'] = self::ROLE_SUPERUSER;
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/superuser/dashboard'); // Sesuaikan
        }

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
        $credentials = $request->only('email', 'password');
        $credentials['role'] = self::ROLE_RS;
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/rs/dashboard'); // Sesuaikan
        }

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
        $credentials['role'] = self::ROLE_PMI;
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/pmi/dashboard'); // Sesuaikan
        }

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
