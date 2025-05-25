@extends('layouts.super-admin')

@section('content')
<div class="verification-section">
    <div class="verification-header mb-3">
        <h5>
            @if($status === 'all')
                All Users
            @elseif($status === 'pending')
                Pending Users
            @elseif($status === 'approved')
                Approved Users
            @elseif($status === 'rejected')
                Rejected Users
            @endif
        </h5>
        <p>List of users with status: <b>{{ ucfirst($status) }}</b></p>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0 bg-white rounded shadow-sm">
            <thead class="bg-light">
                <tr>
                    <th>USER</th>
                    <th>ROLE</th>
                    <th>EMAIL</th>
                    <th>PHONE</th>
                    <th>DOCUMENTS</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
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
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->telepon }}</td>
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
                        @if($user->status === 'pending')
                            <span class="badge" style="background:#fef3c7;color:#b45309;font-weight:500;">Pending</span>
                        @elseif($user->status === 'approved')
                            <span class="badge" style="background:#d1fae5;color:#059669;font-weight:500;">Approved</span>
                        @elseif($user->status === 'rejected')
                            <span class="badge" style="background:#fee2e2;color:#dc2626;font-weight:500;">Rejected</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <p>No users found</p>
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