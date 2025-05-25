@extends('layouts.super-admin')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2>Document Verification</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.verification-dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Document Verification</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Document Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Document Information</h5>
                    <p class="text-muted small mb-0">Document details and verification status</p>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">Document Type</th>
                                    <td>
                                        @if($user->documents->isNotEmpty())
                                            <span class="badge bg-info">Identification</span>
                                        @else
                                            <span class="badge bg-secondary">No document</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Submitted by</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>User Role</th>
                                    <td>
                                        @foreach($user->roles as $role)
                                            <span class="badge bg-primary">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-warning text-dark">Pending Verification</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Submitted on</th>
                                    <td>{{ $user->created_at->format('d M Y, H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="d-flex justify-content-end">
                                <form action="{{ route('admin.verify-user', $user->id) }}" method="POST" class="me-2">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check me-1"></i> Approve User
                                    </button>
                                </form>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i class="fas fa-times me-1"></i> Reject User
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Document Preview -->
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Document Preview</h5>
                            @if($user->documents->isNotEmpty())
                                @foreach($user->documents as $document)
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            @if($document->file_path)
                                                <div class="text-center p-3 border rounded">
                                                    @php
                                                        $ext = pathinfo($document->file_path, PATHINFO_EXTENSION);
                                                    @endphp
                                                    @if(strtolower($ext) === 'pdf')
                                                        <embed src="{{ asset('storage/' . $document->file_path) }}" type="application/pdf" width="100%" height="500px" />
                                                    @elseif(in_array(strtolower($ext), ['jpg','jpeg','png','gif','bmp','webp']))
                                                        <img src="{{ asset('storage/' . $document->file_path) }}" alt="Document" class="img-fluid" style="max-height: 400px;">
                                                    @else
                                                        <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="btn btn-outline-primary">Download Document</a>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="alert alert-warning">
                                                    Document file not found or cannot be displayed.
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-info">
                                    No documents have been uploaded by this user.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Reject User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.verify-user', $user->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="status" value="rejected">
                    <div class="mb-3">
                        <label for="verification_notes" class="form-label">Rejection Reason</label>
                        <textarea class="form-control" id="verification_notes" name="verification_notes" rows="3" 
                                  placeholder="Please provide a reason for rejecting this user"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
