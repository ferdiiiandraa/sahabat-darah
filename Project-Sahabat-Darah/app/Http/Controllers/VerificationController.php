<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class VerificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Middleware will be applied in routes instead
    }

    /**
     * Display the verification dashboard
     */
    public function dashboard()
    {
        // Get counts for dashboard stats
        $totalUsers = User::where('role', '!=', 'super-admin')->count();
        $pendingUsers = User::where('status', User::STATUS_PENDING)->count();
        $approvedUsers = User::where('status', User::STATUS_APPROVED)->count();
        $rejectedUsers = User::where('status', User::STATUS_REJECTED)->count();
        
        // Get pending verification users
        $pendingVerifications = User::where('status', User::STATUS_PENDING)
            ->where('role', '!=', 'super-admin')
            ->with('documents')
            ->latest()
            ->get();
        
        return view('admin.verification.dashboard', compact(
            'totalUsers', 
            'pendingUsers', 
            'approvedUsers', 
            'rejectedUsers', 
            'pendingVerifications'
        ));
    }
    
    /**
     * View document details for verification
     */
    public function viewDocument($userId)
    {
        $user = User::with('documents')->findOrFail($userId);
        
        return view('admin.verification.document', compact('user'));
    }
    
    /**
     * Approve a user registration
     */
    public function approveUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        
        DB::transaction(function() use ($user) {
            // Update user status
            $user->update([
                'status' => User::STATUS_APPROVED,
                'is_verified' => true
            ]);
            
            // Update all user documents
            foreach($user->documents as $document) {
                $document->update([
                    'verification_status' => UserDocument::STATUS_APPROVED,
                    'is_verified' => true
                ]);
            }
        });
        
        return redirect()->route('admin.verification.dashboard')
            ->with('success', 'User has been approved successfully');
    }
    
    /**
     * Reject a user registration
     */
    public function rejectUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        
        DB::transaction(function() use ($user, $request) {
            // Update user status
            $user->update([
                'status' => User::STATUS_REJECTED,
                'is_verified' => false
            ]);
            
            // Update all user documents
            foreach($user->documents as $document) {
                $document->update([
                    'verification_status' => UserDocument::STATUS_REJECTED,
                    'is_verified' => false,
                    'verification_notes' => $request->input('rejection_reason', 'Your registration has been rejected.')
                ]);
            }
        });
        
        return redirect()->route('admin.verification.dashboard')
            ->with('success', 'User has been rejected successfully');
    }
}
