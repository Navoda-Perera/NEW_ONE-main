@extends('layouts.modern-pm')

@section('title', 'Receive Items by Necklabel')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-inbox text-success"></i>
            Receive Items by Necklabel
        </h1>
        <div class="d-flex">
            <a href="{{ route('pm.dispatch.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Dispatches
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Main Card -->
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-tag"></i> Enter Necklabel to Find Items
                    </h6>
                </div>
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-inbox text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h4 class="text-gray-800 mb-2">Mark Items as Received</h4>
                        <p class="text-muted">Enter the necklabel to view all items in the dispatch and mark them as received.</p>
                    </div>

                    <form action="{{ route('pm.dispatch.find-items-by-necklabel') }}" method="POST" id="necklabelForm">
                        @csrf
                        <div class="form-group">
                            <label for="necklabel" class="font-weight-bold text-gray-800">
                                <i class="fas fa-tag text-success mr-2"></i>Necklabel
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-success text-white">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <input
                                    type="text"
                                    class="form-control form-control-lg @error('necklabel') is-invalid @enderror"
                                    id="necklabel"
                                    name="necklabel"
                                    placeholder="Enter necklabel (e.g., NCK123456)"
                                    value="{{ old('necklabel') }}"
                                    autocomplete="off"
                                    autocapitalize="characters"
                                    required
                                    autofocus
                                >
                                @error('necklabel')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Enter the necklabel to find all items in the dispatch that can be marked as received.
                            </small>
                        </div>

                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">
                                <i class="fas fa-search mr-2"></i>Find Items
                            </button>
                        </div>
                    </form>

                    <!-- Instructions -->
                    <div class="card border-info bg-light mt-4">
                        <div class="card-body">
                            <h6 class="text-info font-weight-bold mb-3">
                                <i class="fas fa-info-circle"></i> Instructions
                            </h6>
                            <ul class="mb-0 text-muted">
                                <li class="mb-2">Enter the necklabel to find all dispatched items for your location</li>
                                <li class="mb-2">You can only receive items that are dispatched to your current office location</li>
                                <li class="mb-2">Select the items you want to mark as received</li>
                                <li>The system will update the dispatch status to "received" for selected items</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
document.getElementById('necklabel').addEventListener('input', function() {
    this.value = this.value.toUpperCase();
});

document.getElementById('necklabelForm').addEventListener('submit', function() {
    const button = this.querySelector('button[type="submit"]');
    const icon = button.querySelector('i');

    button.disabled = true;
    icon.className = 'fas fa-spinner fa-spin mr-2';
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Searching...';
});
</script>
@endpush
@endsection
