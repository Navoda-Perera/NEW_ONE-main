@extends('layouts.modern-pm')

@section('title', 'Postal Bag Dispatch Management')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-shipping-fast text-primary"></i>
            Postal Bag Dispatch Management
        </h1>
        <a href="{{ route('pm.dispatch.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Create New Dispatch
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Dispatches Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list"></i> All Dispatches
            </h6>
        </div>
        <div class="card-body">
            @if($dispatches->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>Manifest ID</th>
                                <th>Neck Label</th>
                                <th>Destination Office</th>
                                <th>Created By</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dispatches as $dispatch)
                                <tr>
                                    <td>
                                        @if($dispatch->manifest_id && trim($dispatch->manifest_id) !== '')
                                            <span class="badge bg-info text-white" style="font-size: 11px; font-weight: bold; display: inline-block; min-width: 120px;">{{ trim($dispatch->manifest_id) }}</span>
                                        @else
                                            <span class="badge bg-danger text-white">Missing ID</span>
                                            <script>console.log('Missing manifest_id for dispatch:', {{ $dispatch->id }});</script>
                                        @endif
                                    </td>
                                    <td>{{ $dispatch->necklabel }}</td>
                                    <td>{{ $dispatch->destinationOffice->name ?? 'N/A' }}</td>
                                    <td>{{ $dispatch->creator->name ?? 'N/A' }}</td>
                                    <td>{{ $dispatch->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <div class="btn-group-vertical btn-group-sm" role="group">
                                            <a href="{{ route('pm.dispatch.show', $dispatch->id) }}"
                                               class="btn btn-sm btn-outline-info mb-1"
                                               title="View Details">
                                                <i class="fas fa-eye"></i> View
                                            </a>

                                            <a href="{{ route('pm.dispatch.add-items', $dispatch->id) }}"
                                               class="btn btn-sm btn-outline-success mb-1"
                                               title="Add Items">
                                                <i class="fas fa-plus"></i> Add Items
                                            </a>

                                            <a href="{{ route('pm.dispatch.manifest', $dispatch->id) }}"
                                               class="btn btn-sm btn-outline-primary mb-1"
                                               title="View Manifest">
                                                <i class="fas fa-file-alt"></i> Manifest
                                            </a>

                                            <a href="{{ route('pm.dispatch.print-manifest', $dispatch->id) }}"
                                               class="btn btn-sm btn-outline-secondary mb-1"
                                               title="Print Manifest" target="_blank">
                                                <i class="fas fa-print"></i> Print
                                            </a>

                                            <a href="{{ route('pm.dispatch.edit', $dispatch->id) }}"
                                               class="btn btn-sm btn-outline-warning mb-1"
                                               title="Edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>

                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Delete"
                                                    data-toggle="modal"
                                                    data-target="#deleteModal{{ $dispatch->id }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $dispatch->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirm Delete</h5>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete dispatch <strong>{{ $dispatch->manifest_id }}</strong>?
                                                        <br><small class="text-muted">This will revert all dispatched items back to accepted status.</small>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('pm.dispatch.destroy', $dispatch->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $dispatches->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shipping-fast fa-3x text-gray-300"></i>
                    <h5 class="mt-3 text-gray-600">No dispatches found</h5>
                    <p class="text-gray-500">Create your first postal bag dispatch to get started.</p>
                    <a href="{{ route('pm.dispatch.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create New Dispatch
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .btn-group .btn {
        margin-right: 2px;
    }

    .table th {
        background-color: #f8f9fc;
        border-top: none;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge {
        font-size: 0.75rem;
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
</style>
@endsection
