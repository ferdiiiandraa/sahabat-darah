<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $roles = Role::whereNotIn('slug', ['super-admin'])->get();
        return view('Auth.register', compact('roles'));
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,id'],
            'document_type' => ['required', 'string'],
            'document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Attach role
        $user->roles()->attach($validated['role']);

        // Store document
        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('documents', 'public');
            
            UserDocument::create([
                'user_id' => $user->id,
                'document_type' => $validated['document_type'],
                'file_path' => $path,
                'is_verified' => false,
            ]);
        }

        // Fire registered event
        event(new Registered($user));

        // Redirect to before-login page with success message
        return redirect()->route('before-login')
            ->with('success', 'Registrasi berhasil! Dokumen Anda sedang diverifikasi. Silakan login setelah verifikasi selesai.');
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        // Custom logic after registration if needed
        return null; // Let the register method handle the redirect
    }
}