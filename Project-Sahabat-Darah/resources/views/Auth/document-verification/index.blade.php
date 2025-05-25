@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Document Verification</div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Document Type</th>
                                    <th>Document</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingDocuments as $document)
                                    <tr>
                                        <td>{{ $document->user->name }}</td>
                                        <td>{{ $document->user->email }}</td>
                                        <td>
                                            @foreach($document->user->roles as $role)
                                                {{ $role->name }}<br>
                                            @endforeach
                                        </td>
                                        <td>{{ $document->document_type }}</td>
                                        <td>
                                            <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank">
                                                View Document
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('document-verification.verify', $document->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="is_verified" 
                                                           {{ $document->is_verified ? 'checked' : '' }}
                                                           onchange="this.form.submit()">
                                                </div>
                                            </form>
                                            <button class="btn btn-sm btn-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#notesModal{{ $document->id }}">
                                                Add Notes
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal for verification notes -->
                                    <div class="modal fade" id="notesModal{{ $document->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Verification Notes</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('document-verification.verify', $document->id) }}" method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <textarea class="form-control" name="verification_notes" rows="3">{{ $document->verification_notes }}</textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Save Notes</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $pendingDocuments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
