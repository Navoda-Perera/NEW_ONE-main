@extends('layouts.modern-pm')

@section('title', 'SLP Courier Bulk Upload')

@section('content')
<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item">
                            <a href="{{ route('pm.bulk-upload.index') }}" class="text-decoration-none">Bulk Upload</a>
                        </li>
                        <li class="breadcrumb-item active">SLP Courier</li>
                    </ol>
                </nav>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-truck me-2 text-primary"></i>
                    SLP Courier Bulk Upload
                </h2>
                <p class="text-muted mb-0">Upload multiple SLP Courier items using CSV file</p>
            </div>
            <div class="text-end">
                <div class="badge bg-light text-dark fs-6 px-3 py-2">
                    <i class="bi bi-geo-alt text-danger me-1"></i>
                    {{ $location ? $location->name : 'No location' }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Upload Form -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-cloud-upload me-2"></i>
                    Upload SLP Courier Items
                </h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('upload_errors') && is_array(session('upload_errors')) && count(session('upload_errors')) > 0)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>File Processing Warnings:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach(session('upload_errors') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('pm.bulk-upload.upload-slp') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Company Selection -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="company_id" class="form-label">Company <span class="text-danger">*</span></label>
                            <select class="form-select @error('company_id') is-invalid @enderror" id="company_id" name="company_id" required>
                                <option value="">Select a company...</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('company_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Sender Information -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="sender_name" class="form-label">Sender Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('sender_name') is-invalid @enderror" id="sender_name" name="sender_name"
                                   placeholder="Enter sender name" value="{{ old('sender_name') }}" required>
                            @error('sender_name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="sender_mobile" class="form-label">Sender Mobile <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('sender_mobile') is-invalid @enderror" id="sender_mobile" name="sender_mobile"
                                   placeholder="Enter sender mobile number" value="{{ old('sender_mobile') }}" required>
                            @error('sender_mobile')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div class="mb-3">
                        <label for="csv_file" class="form-label">CSV File <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv,.txt" required>
                            <label class="input-group-text" for="csv_file">
                                <i class="bi bi-file-earmark-text"></i>
                            </label>
                        </div>
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Upload CSV file with SLP Courier items. Maximum file size: 5MB
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-cloud-upload me-2"></i>
                            Upload SLP Courier Items
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Template Download & Instructions -->
    <div class="col-lg-4">
        <!-- Download Template -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light">
                <h6 class="card-title mb-0">
                    <i class="bi bi-download me-2"></i>
                    Download Template
                </h6>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">Download the CSV template with the correct format for SLP Courier items.</p>
                <div class="d-grid">
                    <a href="{{ route('pm.bulk-upload.template', 'slp') }}" class="btn btn-outline-primary">
                        <i class="bi bi-file-earmark-arrow-down me-2"></i>
                        Download SLP Template
                    </a>
                </div>
            </div>
        </div>

        <!-- Format Instructions -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h6 class="card-title mb-0">
                    <i class="bi bi-list-check me-2"></i>
                    CSV Format Requirements
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Barcode:</strong> Required - provide unique barcode for each item
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Receiver Name:</strong> Required
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Mobile:</strong> Required (receiver's mobile)
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Address:</strong> Optional
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Delivery Post Office:</strong> Optional
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Weight (grams):</strong> Required
                    </li>
                    <li class="mb-0">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Amount:</strong> Optional (postage auto-calculated)
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Uploaded Items Table -->
@if(session('uploaded_items') && count(session('uploaded_items')) > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-check-circle me-2"></i>
                    Uploaded Items ({{ count(session('uploaded_items')) }})
                </h5>
                <button type="button" class="btn btn-light btn-sm" onclick="processBulk({{ session('bulk_id') }}, this)">
                    <i class="bi bi-check-all me-2"></i>
                    Submit & Create Receipts
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Receiver Name</th>
                                <th>Mobile</th>
                                <th>Address</th>
                                <th>Weight (g)</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(session('uploaded_items') as $item)
                            <tr id="item-{{ $item->id }}">
                                <td><code>{{ $item->barcode }}</code></td>
                                <td>{{ $item->receiver_name }}</td>
                                <td>{{ $item->smsSents->first()->receiver_mobile ?? 'N/A' }}</td>
                                <td>{{ $item->receiver_address ?? 'N/A' }}</td>
                                <td>{{ $item->weight }}g</td>
                                <td>LKR {{ number_format($item->amount, 2) }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-danger" onclick="removeItem({{ $item->id }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @if(session('total_amount'))
                        <tfoot>
                            <tr class="table-warning">
                                <td colspan="5" class="text-end fw-bold">Total Amount:</td>
                                <td class="fw-bold">LKR {{ number_format(session('total_amount'), 2) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
function removeItem(itemId) {
    if (!confirm('Are you sure you want to remove this item?')) {
        return;
    }

    fetch(`{{ route('pm.bulk-upload.remove-item', ':id') }}`.replace(':id', itemId), {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('item-' + itemId).remove();

            // Show success message
            const alert = document.createElement('div');
            alert.className = 'alert alert-success alert-dismissible fade show';
            alert.innerHTML = `
                <i class="bi bi-check-circle me-2"></i>
                ${data.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.querySelector('.card-body').prepend(alert);
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error removing item');
    });
}

function processBulk(bulkId, buttonElement) {
    if (!confirm('Are you sure you want to submit all items? This will create receipts and cannot be undone.')) {
        return;
    }

    // Show loading state
    const submitBtn = buttonElement;
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="bi bi-spinner bi-spin me-2"></i>Processing...';
    submitBtn.disabled = true;

    console.log('Processing bulk with ID:', bulkId);

    fetch(`{{ route('pm.bulk-upload.process-bulk', ':id') }}`.replace(':id', bulkId), {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            // Show success message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show';
            alertDiv.innerHTML = `
                <i class="bi bi-check-circle me-2"></i>
                ${data.message}
                <br><small>Created ${data.receipts_created || 0} receipts successfully.</small>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            // Replace the uploaded items section with success message
            const uploadedSection = document.querySelector('.card.border-0.shadow-sm');
            if (uploadedSection) {
                uploadedSection.style.display = 'none';
            }

            // Add success message to top of page
            document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.container-fluid').firstChild);

            // Scroll to top
            window.scrollTo(0, 0);
        } else {
            console.error('Error response:', data);
            alert('Error: ' + data.message);
            // Restore button
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Error processing bulk items: ' + error.message);
        // Restore button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error processing bulk upload');
    });
}
</script>
@endpush
