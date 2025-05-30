<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserDocument;
use Illuminate\Http\Request;

class DocumentVerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super-admin');
    }

    public function index()
    {
        $pendingDocuments = UserDocument::where('is_verified', false)
            ->with('user', 'user.roles')
            ->paginate(10);

        return view('Auth.document-verification.index', compact('pendingDocuments'));
    }

    public function verify(Request $request, $id)
    {
        $document = UserDocument::findOrFail($id);
        
        $request->validate([
            'is_verified' => 'required|boolean',
            'verification_notes' => 'nullable|string',
        ]);

        $document->update([
            'is_verified' => $request->is_verified,
            'verification_notes' => $request->verification_notes,
        ]);

        return redirect()->route('document-verification.index')
            ->with('success', 'Document verification status updated successfully');
    }
}
