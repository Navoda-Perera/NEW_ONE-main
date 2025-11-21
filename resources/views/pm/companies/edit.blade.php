@extends('layouts.modern-pm')

@section('title', 'Edit Company')

@section('content')
<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="mb-2">
                    <a href="{{ route('pm.companies.show', $company) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>
                        Back to Company
                    </a>
                </div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-pencil me-2 text-warning"></i>
                    Edit Company
                </h2>
                <p class="text-muted mb-0">Update {{ $company->name }} details</p>
            </div>
        </div>
    </div>
</div>

<!-- Error Messages -->
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>
        Please fix the following errors:
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-warning text-dark text-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-building-fill me-2"></i>
                    Company Information
                </h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('pm.companies.update', $company) }}" id="editCompanyForm">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Company Name -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label fw-bold">
                                <i class="bi bi-building me-1"></i>
                                Company Name *
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $company->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Telephone -->
                        <div class="col-md-6 mb-3">
                            <label for="telephone" class="form-label fw-bold">
                                <i class="bi bi-telephone me-1"></i>
                                Telephone *
                            </label>
                            <input type="tel" class="form-control @error('telephone') is-invalid @enderror"
                                   id="telephone" name="telephone" value="{{ old('telephone', $company->telephone) }}" required>
                            @error('telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-bold">
                                <i class="bi bi-envelope me-1"></i>
                                Email
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $company->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Type -->
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label fw-bold">
                                <i class="bi bi-tag me-1"></i>
                                Type *
                            </label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Select Type...</option>
                                <option value="cash" {{ old('type', $company->type) === 'cash' ? 'selected' : '' }}>
                                    Cash
                                </option>
                                <option value="credit" {{ old('type', $company->type) === 'credit' ? 'selected' : '' }}>
                                    Credit
                                </option>
                                <option value="franking" {{ old('type', $company->type) === 'franking' ? 'selected' : '' }}>
                                    Franking
                                </option>
                                <option value="prepaid" {{ old('type', $company->type) === 'prepaid' ? 'selected' : '' }}>
                                    Prepaid
                                </option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label fw-bold">
                                <i class="bi bi-toggle-on me-1"></i>
                                Status *
                            </label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">Select Status...</option>
                                <option value="ACTIVE" {{ old('status', $company->status) === 'ACTIVE' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="INACTIVE" {{ old('status', $company->status) === 'INACTIVE' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Assign Post Office -->
                        <div class="col-md-6 mb-3">
                            <label for="assign_postoffice" class="form-label fw-bold">
                                <i class="bi bi-geo-alt me-1"></i>
                                Assign Post Office *
                            </label>
                            <select class="form-select @error('assign_postoffice') is-invalid @enderror"
                                    id="assign_postoffice" name="assign_postoffice" required>
                                <option value="">Select Post Office...</option>
                                @foreach($postoffices as $postoffice)
                                    <option value="{{ $postoffice->id }}"
                                            {{ old('assign_postoffice', $company->assign_postoffice) == $postoffice->id ? 'selected' : '' }}>
                                        {{ $postoffice->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('assign_postoffice')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="col-12 mb-3">
                            <label for="address" class="form-label fw-bold">
                                <i class="bi bi-house me-1"></i>
                                Address *
                            </label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address" name="address" rows="3" required>{{ old('address', $company->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Balance Display - Only for Prepaid Companies -->
                        @if($company->type === 'prepaid')
                        <div class="col-12 mb-4">
                            <div class="alert alert-info d-flex align-items-center">
                                <i class="bi bi-wallet me-2"></i>
                                <div>
                                    <strong>Current Prepaid Balance:</strong> LKR {{ number_format($company->balance, 2) }}
                                    <br>
                                    <small class="text-muted">To modify balance, use the balance management section after saving changes.</small>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="col-12 mb-4">
                            <div class="alert alert-secondary d-flex align-items-center">
                                <i class="bi bi-info-circle me-2"></i>
                                <div>
                                    <strong>{{ ucfirst($company->type) }} Company:</strong> No balance management required.
                                    <br>
                                    <small class="text-muted">
                                        @if($company->type === 'cash')
                                            This company pays cash for each service.
                                        @elseif($company->type === 'credit')
                                            This company uses credit facility.
                                        @elseif($company->type === 'franking')
                                            This company uses franking machine services.
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Form Actions -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('pm.companies.show', $company) }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-2"></i>
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Update Company
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="card border-danger mt-4">
            <div class="card-header bg-danger text-white">
                <h6 class="card-title mb-0">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Danger Zone
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-danger">Delete Company</h6>
                        <p class="text-muted mb-0 small">
                            Permanently delete this company. This action cannot be undone.
                        </p>
                    </div>
                    <form method="POST" action="{{ route('pm.companies.destroy', $company) }}"
                          onsubmit="return confirm('Are you sure you want to delete this company? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>
                            Delete Company
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('editCompanyForm');

    form.addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        const telephone = document.getElementById('telephone').value.trim();
        const address = document.getElementById('address').value.trim();
        const type = document.getElementById('type').value;
        const status = document.getElementById('status').value;
        const postoffice = document.getElementById('assign_postoffice').value;

        if (!name || !telephone || !address || !type || !status || !postoffice) {
            e.preventDefault();
            alert('Please fill in all required fields.');
            return false;
        }
    });

    // Telephone validation
    const telephoneInput = document.getElementById('telephone');
    telephoneInput.addEventListener('input', function(e) {
        // Remove non-numeric characters except +, -, space, parentheses
        let value = e.target.value.replace(/[^\d+\-\s()]/g, '');
        e.target.value = value;
    });
});
</script>
@endsection
