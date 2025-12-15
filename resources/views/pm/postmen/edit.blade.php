@extends('layouts.modern-pm')

@section('title', 'Edit Postman - ' . $postman->name)

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
                        <i class="bi bi-pencil me-2"></i>Edit Postman
                    </h1>
                    <p class="text-muted mb-0">
                        Update information for {{ $postman->name }}
                    </p>
                </div>
                <a href="{{ route('pm.postmen.show', $postman->id) }}" class="btn btn-outline-info">
                    <i class="bi bi-eye me-1"></i>View
                </a>
            </div>

            <!-- Error Messages -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <h6><i class="bi bi-exclamation-triangle me-2"></i>Please fix the following errors:</h6>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-person-badge me-2"></i>Postman Information
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pm.postmen.update', $postman->id) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $postman->name) }}" 
                                       placeholder="Enter full name" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="nic" class="form-label">NIC Number <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('nic') is-invalid @enderror" 
                                       id="nic" 
                                       name="nic" 
                                       value="{{ old('nic', $postman->nic) }}" 
                                       placeholder="1234567890" 
                                       maxlength="10" 
                                       required>
                                @error('nic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="mobile" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                <input type="tel" 
                                       class="form-control @error('mobile') is-invalid @enderror" 
                                       id="mobile" 
                                       name="mobile" 
                                       value="{{ old('mobile', $postman->mobile) }}" 
                                       placeholder="0771234567" 
                                       required>
                                @error('mobile')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="paysheet_id" class="form-label">Paysheet ID</label>
                                <input type="text" 
                                       class="form-control @error('paysheet_id') is-invalid @enderror" 
                                       id="paysheet_id" 
                                       name="paysheet_id" 
                                       value="{{ old('paysheet_id', $postman->paysheet_id) }}" 
                                       placeholder="Optional paysheet ID">
                                @error('paysheet_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="postman_type" class="form-label">Postman Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('postman_type') is-invalid @enderror" 
                                        id="postman_type" 
                                        name="postman_type" 
                                        required>
                                    <option value="">Select postman type</option>
                                    <option value="permanent" {{ old('postman_type', $postman->postman_type) === 'permanent' ? 'selected' : '' }}>
                                        Permanent
                                    </option>
                                    <option value="temporary" {{ old('postman_type', $postman->postman_type) === 'temporary' ? 'selected' : '' }}>
                                        Temporary
                                    </option>
                                    <option value="substitute" {{ old('postman_type', $postman->postman_type) === 'substitute' ? 'selected' : '' }}>
                                        Substitute
                                    </option>
                                </select>
                                @error('postman_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status" 
                                        required>
                                    <option value="">Select status</option>
                                    <option value="active" {{ old('status', $postman->status) === 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="inactive" {{ old('status', $postman->status) === 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-info mt-4">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Note:</strong> This postman is assigned to 
                            <strong>{{ $postman->location->name ?? 'Unknown Location' }}</strong>.
                            <br><small class="text-muted">
                                Created by {{ $postman->creator->name ?? 'Unknown' }} on 
                                {{ $postman->created_at->format('F d, Y \a\t h:i A') }}
                                @if($postman->updated_by && $postman->updated_at != $postman->created_at)
                                    <br>Last updated by {{ $postman->updater->name ?? 'Unknown' }} on 
                                    {{ $postman->updated_at->format('F d, Y \a\t h:i A') }}
                                @endif
                            </small>
                        </div>

                        <div class="d-flex gap-2 justify-content-end mt-4">
                            <a href="{{ route('pm.postmen.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>Update Postman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Format NIC input
        const nicInput = document.getElementById('nic');
        nicInput.addEventListener('input', function(e) {
            // Remove non-alphanumeric characters
            e.target.value = e.target.value.replace(/[^a-zA-Z0-9]/g, '').toUpperCase();
        });

        // Format mobile input
        const mobileInput = document.getElementById('mobile');
        mobileInput.addEventListener('input', function(e) {
            // Remove non-numeric characters
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        });

        // Form validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const nic = document.getElementById('nic').value;
            const mobile = document.getElementById('mobile').value;

            // Validate NIC length
            if (nic.length !== 10) {
                e.preventDefault();
                alert('NIC must be exactly 10 characters long.');
                document.getElementById('nic').focus();
                return false;
            }

            // Validate mobile number
            if (mobile.length < 9 || mobile.length > 15) {
                e.preventDefault();
                alert('Mobile number should be between 9 and 15 digits.');
                document.getElementById('mobile').focus();
                return false;
            }
        });
    });
</script>
@endsection

@section('styles')
<style>
    .form-label {
        font-weight: 500;
    }
    
    .text-danger {
        font-size: 0.875em;
    }
</style>
@endsection