<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDocument;
use App\Models\Role;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // No middleware here - we'll handle authentication in each method
    }
    
    /**
     * Check if the authenticated user is a super admin
     *
     * @return bool
     */
    private function isSuperAdmin()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        if (!$user) {
            return false;
        }
        
        return \Illuminate\Support\Facades\DB::table('user_roles')
            ->join('roles', 'user_roles.role_id', '=', 'roles.id')
            ->where('user_roles.user_id', $user->id)
            ->where('roles.slug', 'super-admin')
            ->exists();
    }

    public function dashboard()
    {
        // Check if user is authenticated
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return redirect()->route('login.superuser.form');
        }
        
        // Check if user is a super admin
        if (!$this->isSuperAdmin()) {
            return redirect()->route('before-login')
                ->with('error', 'You do not have permission to access this page');
        }
        
        // Get counts for dashboard cards
        $totalUsers = User::count();
        // Removed queries based on 'status' column as it does not exist
        // $pendingVerification = User::where('status', User::STATUS_PENDING)->count();
        // $approvedUsers = User::where('status', User::STATUS_APPROVED)->count();
        // $rejectedUsers = User::where('status', User::STATUS_REJECTED)->count();

        // Get pending verification users with their roles and documents
        // Removed query based on 'status' column
        // $pendingUsers = User::where('status', User::STATUS_PENDING)
        //     ->with(['roles', 'documents'])
        //     ->get();

        // Pass placeholder or default values for now
        // $pendingVerification = 0;
        // $approvedUsers = 0;
        // $rejectedUsers = 0;
        // $pendingUsers = collect(); // Empty collection

        // Mengaktifkan kembali query berdasarkan kolom 'status'
        $pendingVerification = User::where('status', 'pending')->count(); // Menggunakan string 'pending' langsung jika konstanta belum didefinisikan di model
        $approvedUsers = User::where('status', 'approved')->count(); // Menggunakan string 'approved'
        $rejectedUsers = User::where('status', 'rejected')->count(); // Menggunakan string 'rejected'


        // Get pending verification users with their roles and documents
        // Mengaktifkan kembali query berdasarkan kolom 'status'
        $pendingUsers = User::where('status', 'pending') // Menggunakan string 'pending'
            ->with(['roles', 'documents'])
            ->get();

        return view('admin.verification-dashboard', compact(
            'totalUsers', 
            'pendingVerification', 
            'approvedUsers', 
            'rejectedUsers', 
            'pendingUsers'
        ));
    }

    public function viewDocument($userId)
    {
        // Check if user is authenticated
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return redirect()->route('login.superuser.form');
        }
        
        // Check if user is a super admin
        if (!$this->isSuperAdmin()) {
            return redirect()->route('before-login')
                ->with('error', 'You do not have permission to access this page');
        }
        
        $user = User::with(['roles', 'documents'])->findOrFail($userId);
        
        return view('admin.document-verification', compact('user'));
    }

    public function verifyUser(Request $request, $userId)
    {
        // Check if user is authenticated
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return redirect()->route('login.superuser.form');
        }
        
        // Check if user is a super admin
        if (!$this->isSuperAdmin()) {
            return redirect()->route('before-login')
                ->with('error', 'You do not have permission to access this page');
        }
        
        $user = User::findOrFail($userId);
        
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'verification_notes' => 'nullable|string',
        ]);

        $user->update([
            'status' => $request->status,
            'is_verified' => $request->status === 'approved',
        ]);

        // If user is approved, attach the appropriate role
        if ($request->status === 'approved') {
            $roleSlug = null;
            if ($user->rumah_sakit_id !== null) {
                $roleSlug = 'admin-rs';
            } elseif ($user->pmi_id !== null) {
                $roleSlug = 'admin-pmi';
            }

            if ($roleSlug) {
                $role = Role::where('slug', $roleSlug)->first();
                if ($role) {
                    // Attach the role if it doesn't exist yet
                    $user->roles()->syncWithoutDetaching([$role->id]);
                }
            }
        }

        // Update all user documents
        foreach ($user->documents as $document) {
            $document->update([
                'verification_status' => $request->status,
                'is_verified' => $request->status === User::STATUS_APPROVED,
                'verification_notes' => $request->verification_notes
            ]);
        }

        return redirect()->route('admin.verification-dashboard')
            ->with('success', 'User verification status updated successfully');
    }

    public function listUsers(Request $request)
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return redirect()->route('login.superuser.form');
        }
        if (!$this->isSuperAdmin()) {
            return redirect()->route('before-login')
                ->with('error', 'You do not have permission to access this page');
        }
        $status = $request->query('status', 'all');
        $query = User::with(['roles', 'documents']);
        if ($status === 'pending') {
            $query->where('status', User::STATUS_PENDING);
        } elseif ($status === 'approved') {
            $query->where('status', User::STATUS_APPROVED);
        } elseif ($status === 'rejected') {
            $query->where('status', User::STATUS_REJECTED);
        }
        $users = $query->get();
        return view('admin.users-list', compact('users', 'status'));
    }
}
