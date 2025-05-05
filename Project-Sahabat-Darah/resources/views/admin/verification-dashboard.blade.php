@extends('layouts.super-admin')

@section('content')
<!-- Stats Cards -->
<div class="row">
    <div class="col-md-3">
        <a href="{{ route('admin.users', ['status' => 'all']) }}" style="text-decoration:none;">
            <div class="card">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h6>Total Users</h6>
                        <h3>{{ $totalUsers }}</h3>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('admin.users', ['status' => 'pending']) }}" style="text-decoration:none;">
            <div class="card">
                <div class="stat-card">
                    <div class="stat-icon yellow">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h6>Pending Verification</h6>
                        <h3>{{ $pendingVerification }}</h3>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('admin.users', ['status' => 'approved']) }}" style="text-decoration:none;">
            <div class="card">
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h6>Approved Users</h6>
                        <h3>{{ $approvedUsers }}</h3>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('admin.users', ['status' => 'rejected']) }}" style="text-decoration:none;">
            <div class="card">
                <div class="stat-card">
                    <div class="stat-icon red">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h6>Rejected Users</h6>
                        <h3>{{ $rejectedUsers }}</h3>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Pending User Verifications -->
<div class="verification-section">
    <div class="verification-header">
        <h5>Pending User Verifications</h5>
        <p>Review and verify user registrations</p>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table align-middle mb-0 bg-white rounded shadow-sm">
            <thead class="bg-light">
                <tr>
                    <th>USER</th>
                    <th>ROLE</th>
                    <th>CONTACT</th>
                    <th>DOCUMENTS</th>
                    <th>STATUS</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingUsers as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar me-3">
                                <i class="fas fa-user text-secondary"></i>
                            </div>
                            <div>
                                <div class="fw-bold">{{ $user->name }}</div>
                                <div class="text-muted small">Registered: {{ $user->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @foreach($user->roles as $role)
                            <span class="badge" style="background:#e5d8fa;color:#7c3aed;font-weight:500;">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <div>{{ $user->email }}</div>
                        <div>{{ $user->telepon }}</div>
                    </td>
                    <td>
                        @if($user->documents->count() > 0)
                            <a href="{{ route('admin.document-verification', $user->id) }}" class="text-decoration-none small" style="color:#3b82f6;">
                                <i class="fas fa-file-alt me-1"></i>identification
                            </a>
                        @else
                            <span class="badge bg-secondary">No documents</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge" style="background:#fef3c7;color:#b45309;font-weight:500;">Pending</span>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <form action="{{ route('admin.verify-user', $user->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="btn btn-sm" style="background:#d1fae5;color:#059669;font-weight:500;min-width:80px;">Approve</button>
                            </form>
                            <form action="{{ route('admin.verify-user', $user->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="btn btn-sm" style="background:#fee2e2;color:#dc2626;font-weight:500;min-width:80px;">Reject</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <p>No pending verifications found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('styles')
<style>
    .avatar {
        width: 40px;
        height: 40px;
        background-color: #f3f4f6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .table {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .card {
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .stat-card {
        border-radius: 16px;
    }
    .btn-sm {
        border-radius: 8px !important;
        font-size: 14px !important;
        padding: 6px 18px !important;
    }
    .badge {
        border-radius: 8px;
        font-size: 13px;
        padding: 6px 14px;
    }
    .empty-state {
        padding: 20px;
        text-align: center;
        color: #858796;
        background-color: white;
        border-radius: 8px;
    }
</style>
@endsection
