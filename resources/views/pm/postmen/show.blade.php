@extends('layouts.modern-pm')

@section('title', 'View Postman - ' . $postman->name)

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-6">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('pm.postmen.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div class="flex-grow-1">
                    <h1 class="h2 mb-1">
                        <i class="bi bi-person-badge me-2"></i>{{ $postman->name }}
                    </h1>
                    <p class="text-muted mb-0">
                        Postman Details - {{ $postman->location->name ?? 'Unknown Location' }}
                    </p>
                </div>
                <div class="btn-group">
                    <a href="{{ route('pm.postmen.edit', $postman->id) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <button type="button"
                            class="btn btn-outline-{{ $postman->status === 'active' ? 'warning' : 'success' }}"
                            onclick="toggleStatus({{ $postman->id }})">
                        <i class="bi bi-{{ $postman->status === 'active' ? 'pause' : 'play' }} me-1"></i>
                        {{ $postman->status === 'active' ? 'Deactivate' : 'Activate' }}
                    </button>
                </div>
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

            <!-- Postman Information Card -->
            <div class="card mb-4">
                <div class="card-header bg-white d-flex align-items-center">
                    <div class="avatar-lg bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                        <i class="bi bi-person text-white fs-3"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-1">{{ $postman->name }}</h5>
                        <div class="d-flex gap-2">
                            @if($postman->postman_type === 'permanent')
                                <span class="badge bg-success">Permanent</span>
                            @elseif($postman->postman_type === 'temporary')
                                <span class="badge bg-warning">Temporary</span>
                            @else
                                <span class="badge bg-info">Substitute</span>
                            @endif

                            @if($postman->status === 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">
                                <i class="bi bi-card-text me-2"></i>NIC Number
                            </h6>
                            <p class="mb-0 fs-5">{{ $postman->nic }}</p>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">
                                <i class="bi bi-telephone me-2"></i>Mobile Number
                            </h6>
                            <p class="mb-0 fs-5">
                                <a href="tel:{{ $postman->mobile }}" class="text-decoration-none">
                                    {{ $postman->mobile }}
                                </a>
                            </p>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">
                                <i class="bi bi-file-earmark-text me-2"></i>Paysheet ID
                            </h6>
                            <p class="mb-0 fs-5">
                                {{ $postman->paysheet_id ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">
                                <i class="bi bi-geo-alt me-2"></i>Location
                            </h6>
                            <p class="mb-0 fs-5">
                                {{ $postman->location->name ?? 'Unknown Location' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Information Card -->
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history me-2"></i>Activity Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Created</h6>
                            <p class="mb-1">
                                <i class="bi bi-calendar3 me-2"></i>
                                {{ $postman->created_at->format('F d, Y') }}
                            </p>
                            <p class="mb-0">
                                <i class="bi bi-clock me-2"></i>
                                {{ $postman->created_at->format('h:i A') }}
                            </p>
                            <small class="text-muted">
                                by {{ $postman->creator->name ?? 'Unknown' }}
                            </small>
                        </div>

                        @if($postman->updated_by && $postman->updated_at != $postman->created_at)
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">Last Updated</h6>
                                <p class="mb-1">
                                    <i class="bi bi-calendar3 me-2"></i>
                                    {{ $postman->updated_at->format('F d, Y') }}
                                </p>
                                <p class="mb-0">
                                    <i class="bi bi-clock me-2"></i>
                                    {{ $postman->updated_at->format('h:i A') }}
                                </p>
                                <small class="text-muted">
                                    by {{ $postman->updater->name ?? 'Unknown' }}
                                </small>
                            </div>
                        @endif

                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Time Since Created</h6>
                            <p class="mb-0">
                                <i class="bi bi-hourglass-split me-2"></i>
                                {{ $postman->created_at->diffForHumans() }}
                            </p>
                        </div>

                        @if($postman->updated_at != $postman->created_at)
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">Time Since Updated</h6>
                                <p class="mb-0">
                                    <i class="bi bi-arrow-repeat me-2"></i>
                                    {{ $postman->updated_at->diffForHumans() }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 justify-content-end mt-4">
                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete({{ $postman->id }})">
                    <i class="bi bi-trash me-1"></i>Delete Postman
                </button>
                <a href="{{ route('pm.postmen.edit', $postman->id) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-1"></i>Edit Details
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>Confirm Delete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{ $postman->name }}</strong>?</p>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Warning:</strong> This action cannot be undone. All data associated with this postman will be permanently removed.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Delete Postman
                    </button>
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
        const currentStatus = '{{ $postman->status }}';
        const newStatus = currentStatus === 'active' ? 'deactivate' : 'activate';

        if (confirm(`Are you sure you want to ${newStatus} this postman?`)) {
            const form = document.getElementById('statusForm');
            form.action = `/pm/postmen/${postmanId}/toggle-status`;
            form.submit();
        }
    }
</script>
@endsection

@section('styles')
<style>
    .avatar-lg {
        width: 60px;
        height: 60px;
    }

    .card-title {
        font-weight: 600;
    }

    .badge {
        font-size: 0.75rem;
    }

    .text-muted {
        font-weight: 500;
    }
</style>
@endsection
