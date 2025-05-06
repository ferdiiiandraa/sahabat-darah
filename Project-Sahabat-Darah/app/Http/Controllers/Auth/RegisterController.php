<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $roles = Role::whereNotIn('slug', ['super-admin'])->get();
        return view('auth.register', compact('roles'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,id',
            'document_type' => 'required|string',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->attach($request->role);

        if ($request->hasFile('document')) {
            $path = $request->document->store('documents', 'public');
            UserDocument::create([
                'user_id' => $user->id,
                'document_type' => $request->document_type,
                'file_path' => $path,
                'is_verified' => false,
            ]);
        }

        return redirect()->route('login')->with('success', 'Registration successful. Please wait for document verification.');
    }
}
