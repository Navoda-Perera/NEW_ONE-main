@extends('layouts.modern-pm')

@section('title', 'Postmen Management')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2 mb-1">
                        <i class="bi bi-person-badge me-2"></i>Postmen Management
                    </h1>
                    <p class="text-muted mb-0">
                        Manage postmen for {{ auth()->user()->location->name ?? 'your location' }}
                    </p>
                </div>
                <a href="{{ route('pm.postmen.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>Add New Postman
                </a>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-list me-2"></i>All Postmen
                        <span class="badge bg-secondary ms-2">{{ $postmen->total() }}</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($postmen->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>NIC</th>
                                        <th>Mobile</th>
                                        <th>Paysheet ID</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($postmen as $index => $postman)
                                        <tr>
                                            <td>{{ $postmen->firstItem() + $index }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                        <i class="bi bi-person text-white"></i>
                                                    </div>
                                                    <div>
                                                        <strong>{{ $postman->name }}</strong>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $postman->nic }}</td>
                                            <td>{{ $postman->mobile }}</td>
                                            <td>{{ $postman->paysheet_id ?? 'N/A' }}</td>
                                            <td>
                                                @if($postman->postman_type === 'permanent')
                                                    <span class="badge bg-success">Permanent</span>
                                                @elseif($postman->postman_type === 'temporary')
                                                    <span class="badge bg-warning">Temporary</span>
                                                @else
                                                    <span class="badge bg-info">Substitute</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($postman->status === 'active')
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $postman->created_at->format('Y-m-d') }}<br>
                                                    by {{ $postman->creator->name ?? 'N/A' }}
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('pm.postmen.show', $postman->id) }}" 
                                                       class="btn btn-outline-primary" title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('pm.postmen.edit', $postman->id) }}" 
                                                       class="btn btn-outline-secondary" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-outline-{{ $postman->status === 'active' ? 'warning' : 'success' }}" 
                                                            title="{{ $postman->status === 'active' ? 'Deactivate' : 'Activate' }}"
                                                            onclick="toggleStatus({{ $postman->id }})">
                                                        <i class="bi bi-{{ $postman->status === 'active' ? 'pause' : 'play' }}"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger" 
                                                            title="Delete" onclick="confirmDelete({{ $postman->id }})">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($postmen->hasPages())
                            <div class="card-footer">
                                {{ $postmen->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-person-plus display-4 d-block mb-3"></i>
                                <h5>No postmen found</h5>
                                <p>Get started by adding your first postman.</p>
                                <a href="{{ route('pm.postmen.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i>Add Postman
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this postman? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Status Toggle Form -->
<form id="statusForm" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
</form>

@endsection

@section('scripts')
<script>
    function confirmDelete(postmanId) {
        const form = document.getElementById('deleteForm');
        form.action = `/pm/postmen/${postmanId}`;
        
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }

    function toggleStatus(postmanId) {
        if (confirm('Are you sure you want to change the status of this postman?')) {
            const form = document.getElementById('statusForm');
            form.action = `/pm/postmen/${postmanId}/toggle-status`;
            form.submit();
        }
    }
</script>
@endsection

@section('styles')
<style>
    .avatar-sm {
        width: 32px;
        height: 32px;
    }
    
    .btn-group-sm > .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
</style>
@endsection