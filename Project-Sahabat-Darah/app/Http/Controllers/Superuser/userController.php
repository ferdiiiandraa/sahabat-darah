<?php

namespace App\Http\Controllers\Superuser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users.manajemenuser', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
    
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

    return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
    public function resetPassword($id)
{
    $user = User::findOrFail($id);
    $user->password = Hash::make('password123'); // Password default baru
    $user->save();

    return redirect()->back()->with('success', 'Password berhasil direset ke "password123"');
}

public function toggleStatus($id)
{
    $user = User::findOrFail($id);
    $user->status = $user->status === 'enabled' ? 'disabled' : 'enabled';
    $user->save();

    return redirect()->back()->with('success', 'Status user berhasil diubah.');
}


    public function search(Request $request)
{
    $query = \App\Models\User::query();

    if ($request->filled('id_name')) {
        $query->where('id_name', 'like', '%' . $request->id_name . '%');
    }

    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    $users = $query->get();

    return view('users.manajemenuser', compact('users'));
}

public function pmi()
{
    $users = User::where('role', 'PMI')->get(); // contoh filter
    return view('users.pmi', compact('users'));
}
}
