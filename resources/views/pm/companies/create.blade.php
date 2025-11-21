@extends('layouts.modern-pm')

@section('title', 'Create Company')

@section('content')
<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="mb-2">
                    <a href="{{ route('pm.companies.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>
                        Back to Companies
                    </a>
                </div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-building-add me-2 text-primary"></i>
                    Create New Company
                </h2>
                <p class="text-muted mb-0">Add a new company to the system</p>
            </div>
        </div>
    </div>
</div>

<!-- Form Card -->
<div class="row">
    <div class="col-lg-8 col-xl-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    Company Information
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('pm.companies.store') }}">
                    @csrf

                    <!-- Error Display -->
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <h6><i class="bi bi-exclamation-triangle"></i> Please fix the following errors:</h6>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Company Basic Information -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Company Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="telephone" class="form-label">Telephone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="telephone" name="telephone"
                                   value="{{ old('telephone') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="{{ old('email') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="type" class="form-label">Company Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="cash" {{ old('type') === 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="credit" {{ old('type') === 'credit' ? 'selected' : '' }}>Credit</option>
                                <option value="franking" {{ old('type') === 'franking' ? 'selected' : '' }}>Franking</option>
                                <option value="prepaid" {{ old('type') === 'prepaid' ? 'selected' : '' }}>Prepaid</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">Select Status</option>
                                <option value="ACTIVE" {{ old('status') === 'ACTIVE' ? 'selected' : '' }}>Active</option>
                                <option value="INACTIVE" {{ old('status') === 'INACTIVE' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="assign_postoffice" class="form-label">Assign Post Office <span class="text-danger">*</span></label>
                            <select class="form-select" id="assign_postoffice" name="assign_postoffice" required>
                                <option value="">Select Post Office</option>
                                @foreach($postoffices as $postoffice)
                                    <option value="{{ $postoffice->id }}" {{ old('assign_postoffice') == $postoffice->id ? 'selected' : '' }}>
                                        {{ $postoffice->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4" id="balance-section" style="display: none;">
                        <div class="col-md-6">
                            <label for="balance" class="form-label">Initial Balance (LKR) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="balance" name="balance"
                                   value="{{ old('balance', '0') }}" step="0.01" min="0">
                            <small class="text-muted">Enter the initial prepaid account balance</small>
                        </div>
                    </div>

                    <!-- Balance Information - Only for Prepaid -->
                    <div class="alert alert-info" id="balance-info" style="display: none;">
                        <h6 class="alert-heading"><i class="bi bi-info-circle"></i> Prepaid Balance Management</h6>
                        <p class="mb-0">
                            <strong>Prepaid Account:</strong> Customer deposits money in advance.
                            When services are used, the amount is deducted from the prepaid balance.
                        </p>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>
                            Create Company
                        </button>
                        <a href="{{ route('pm.companies.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Info Panel -->
    <div class="col-lg-4 col-xl-6">
        <div class="card border-0 bg-light">
            <div class="card-header bg-transparent border-bottom-0">
                <h6 class="card-title text-primary">
                    <i class="bi bi-lightbulb me-2"></i>
                    Company Types
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-success"><i class="bi bi-cash"></i> Cash</h6>
                    <p class="small text-muted mb-2">Pay-as-you-go companies that pay cash for services</p>
                </div>
                <div class="mb-3">
                    <h6 class="text-warning"><i class="bi bi-credit-card"></i> Credit</h6>
                    <p class="small text-muted mb-2">Companies with credit facility for services</p>
                </div>
                <div class="mb-3">
                    <h6 class="text-info"><i class="bi bi-stamp"></i> Franking</h6>
                    <p class="small text-muted mb-2">Companies using franking machine services</p>
                </div>
                <div>
                    <h6 class="text-primary"><i class="bi bi-credit-card-2-front"></i> Prepaid</h6>
                    <p class="small text-muted mb-0">Companies with prepaid account balance</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const balanceSection = document.getElementById('balance-section');
    const balanceInfo = document.getElementById('balance-info');
    const balanceInput = document.getElementById('balance');

    function toggleBalanceField() {
        if (typeSelect.value === 'prepaid') {
            balanceSection.style.display = 'block';
            balanceInfo.style.display = 'block';
            balanceInput.required = true;
            if (!balanceInput.value || balanceInput.value === '0') {
                balanceInput.value = '';
            }
        } else {
            balanceSection.style.display = 'none';
            balanceInfo.style.display = 'none';
            balanceInput.required = false;
            balanceInput.value = '0';
        }
    }

    // Initial check
    toggleBalanceField();

    // Listen for changes
    typeSelect.addEventListener('change', toggleBalanceField);

    // Form validation
    const form = document.getElementById('createCompanyForm');
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

        if (type === 'prepaid') {
            const balance = parseFloat(document.getElementById('balance').value);
            if (!balance || balance <= 0) {
                e.preventDefault();
                alert('Prepaid companies must have an initial balance greater than 0.');
                return false;
            }
        }
    });

    // Telephone validation
    const telephoneInput = document.getElementById('telephone');
    telephoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^\d+\-\s()]/g, '');
        e.target.value = value;
    });
});
</script>
@endsection
