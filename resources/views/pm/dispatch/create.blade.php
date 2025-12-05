@extends('layouts.modern-pm')

@section('title', 'Create Postal Bag Dispatch')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus text-primary"></i>
            Create Postal Bag Dispatch
        </h1>
        <a href="{{ route('pm.dispatch.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Dispatches
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</h6>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Main Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-shipping-fast"></i> Complete Dispatch Creation
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('pm.dispatch.store') }}" method="POST" id="dispatchForm">
                @csrf
                
                <!-- Step 1: Destination Office -->
                <div class="step-section mb-4" id="step1">
                    <h5 class="step-title">
                        <span class="step-number">1</span>
                        Select Destination Office
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="destination_office" class="form-label">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                    Destination Office <span class="text-danger">*</span>
                                </label>
                                <select class="form-control @error('destination_office') is-invalid @enderror" 
                                        id="destination_office" 
                                        name="destination_office" 
                                        required>
                                    <option value="">Select Delivery Office</option>
                                    @foreach($deliveryOffices as $office)
                                        <option value="{{ $office->id }}" 
                                                {{ old('destination_office') == $office->id ? 'selected' : '' }}>
                                            {{ $office->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('destination_office')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="button" class="btn btn-primary" id="nextToItems" disabled>
                                <i class="fas fa-arrow-right"></i> Next: Add Items
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Add Items -->
                <div class="step-section mb-4" id="step2" style="display: none;">
                    <h5 class="step-title">
                        <span class="step-number">2</span>
                        Add Items via Barcode
                    </h5>
                    
                    <!-- Barcode Scanner -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="barcodeInput" class="form-label">
                                    <i class="fas fa-barcode text-primary"></i>
                                    Scan or Enter Barcode
                                </label>
                                <div class="input-group">
                                    <input type="text" 
                                           class="form-control form-control-lg" 
                                           id="barcodeInput" 
                                           placeholder="Scan barcode or type manually..."
                                           autocomplete="off">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" id="addItemBtn">
                                            <i class="fas fa-plus"></i> Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="scanMessage" class="mt-2"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="text-primary">Items Added</h6>
                                    <h3 class="text-dark mb-0" id="itemCount">0</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Selected Items List -->
                    <div class="table-responsive mb-3" id="selectedItemsContainer" style="display: none;">
                        <table class="table table-bordered" id="selectedItemsTable">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Barcode</th>
                                    <th>Receiver</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <button type="button" class="btn btn-primary" id="nextToNeckLabel" disabled>
                        <i class="fas fa-arrow-right"></i> Next: Enter Neck Label
                    </button>
                    <button type="button" class="btn btn-secondary" id="backToOffice">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                </div>

                <!-- Step 3: Neck Label -->
                <div class="step-section mb-4" id="step3" style="display: none;">
                    <h5 class="step-title">
                        <span class="step-number">3</span>
                        Enter Neck Label
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="necklabel" class="form-label">
                                    <i class="fas fa-tag text-primary"></i>
                                    Neck Label <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('necklabel') is-invalid @enderror" 
                                       id="necklabel" 
                                       name="necklabel" 
                                       value="{{ old('necklabel') }}" 
                                       placeholder="Enter neck label identifier"
                                       maxlength="255"
                                       required>
                                @error('necklabel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Auto-generated based on destination and date
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle"></i> Summary</h6>
                                <p class="mb-1"><strong>Destination:</strong> <span id="summaryOffice">-</span></p>
                                <p class="mb-0"><strong>Items:</strong> <span id="summaryItems">0</span></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <button type="button" class="btn btn-secondary mr-2" id="backToItems">
                            <i class="fas fa-arrow-left"></i> Back to Items
                        </button>
                        <button type="submit" class="btn btn-success" id="createDispatch" disabled>
                            <i class="fas fa-save"></i> Create Postal Bag
                        </button>
                    </div>
                </div>

                <!-- Hidden input for selected items -->
                <input type="hidden" name="items" id="selectedItemsInput" value="">
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        let selectedItems = [];
        let currentStep = 1;

        // Initialize Select2
        $('#destination_office').select2({
            placeholder: "Search and select delivery office...",
            allowClear: true,
            width: '100%'
        });

        // Step 1: Office selection
        $('#destination_office').on('change', function() {
            if ($(this).val()) {
                $('#nextToItems').prop('disabled', false);
                updateSummary();
            } else {
                $('#nextToItems').prop('disabled', true);
            }
        });

        $('#nextToItems').on('click', function() {
            showStep(2);
            $('#barcodeInput').focus();
        });

        // Step 2: Barcode scanning
        $('#barcodeInput').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                addItemByBarcode();
            }
        });

        $('#addItemBtn').on('click', addItemByBarcode);

        function addItemByBarcode() {
            const barcode = $('#barcodeInput').val().trim();
            
            if (!barcode) {
                showMessage('Please enter or scan a barcode', 'warning');
                return;
            }

            // Find item in available items
            const availableItem = @json($availableItems->keyBy('barcode'));
            
            if (!availableItem[barcode]) {
                showMessage('Item not found or not available for dispatch', 'error');
                $('#barcodeInput').val('').focus();
                return;
            }

            // Check if already added
            if (selectedItems.find(item => item.barcode === barcode)) {
                showMessage('Item already added to dispatch', 'warning');
                $('#barcodeInput').val('').focus();
                return;
            }

            addItemToList(availableItem[barcode]);
        }

        function addItemToList(item) {
            selectedItems.push(item);
            updateItemsTable();
            updateItemCount();
            updateSelectedItemsInput();
            showMessage(`Item added: ${item.barcode}`, 'success');
            $('#barcodeInput').val('').focus();
            
            if (selectedItems.length >= 1) {
                $('#nextToNeckLabel').prop('disabled', false);
            }
        }

        function removeItem(barcode) {
            selectedItems = selectedItems.filter(item => item.barcode !== barcode);
            updateItemsTable();
            updateItemCount();
            updateSelectedItemsInput();
            showMessage('Item removed from dispatch', 'info');
            
            if (selectedItems.length === 0) {
                $('#nextToNeckLabel').prop('disabled', true);
                $('#selectedItemsContainer').hide();
            }
        }

        function updateItemsTable() {
            const tbody = $('#selectedItemsTable tbody');
            tbody.empty();
            
            if (selectedItems.length === 0) {
                $('#selectedItemsContainer').hide();
                return;
            }
            
            $('#selectedItemsContainer').show();
            
            selectedItems.forEach((item, index) => {
                tbody.append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td><span class="badge badge-info">${item.barcode}</span></td>
                        <td>${item.receiver_name}</td>
                        <td>LKR ${parseFloat(item.amount).toFixed(2)}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeItem('${item.barcode}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });
        }

        function updateItemCount() {
            $('#itemCount').text(selectedItems.length);
            updateSummary();
        }

        function updateSelectedItemsInput() {
            const itemIds = selectedItems.map(item => item.id);
            $('#selectedItemsInput').val(JSON.stringify(itemIds));
        }

        function updateSummary() {
            const officeName = $('#destination_office option:selected').text();
            $('#summaryOffice').text(officeName || '-');
            $('#summaryItems').text(selectedItems.length);
        }

        $('#nextToNeckLabel').on('click', function() {
            showStep(3);
            generateNeckLabel();
        });

        $('#backToOffice').on('click', function() {
            showStep(1);
        });

        $('#backToItems').on('click', function() {
            showStep(2);
            $('#barcodeInput').focus();
        });

        // Step 3: Neck label
        $('#necklabel').on('input', function() {
            $('#createDispatch').prop('disabled', $(this).val().trim() === '');
        });

        function generateNeckLabel() {
            const officeName = $('#destination_office option:selected').text();
            const date = new Date();
            const dateStr = date.getFullYear() + 
                          String(date.getMonth() + 1).padStart(2, '0') + 
                          String(date.getDate()).padStart(2, '0');
            const timeStr = String(date.getHours()).padStart(2, '0') + 
                          String(date.getMinutes()).padStart(2, '0');
            
            const suggestedLabel = officeName.substring(0, 3).toUpperCase() + '-' + dateStr + '-' + timeStr;
            $('#necklabel').val(suggestedLabel);
            $('#createDispatch').prop('disabled', false);
        }

        function showStep(step) {
            $('.step-section').hide();
            $(`#step${step}`).show();
            currentStep = step;
            
            // Update step numbers visual state
            $('.step-number').removeClass('active');
            $(`.step-section:visible .step-number`).addClass('active');
        }

        function showMessage(message, type) {
            const alertClass = {
                'success': 'alert-success',
                'error': 'alert-danger', 
                'warning': 'alert-warning',
                'info': 'alert-info'
            }[type] || 'alert-info';
            
            $('#scanMessage').html(`
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            `);
            
            setTimeout(() => {
                $('#scanMessage .alert').alert('close');
            }, 3000);
        }

        // Make removeItem available globally
        window.removeItem = removeItem;

        // Form submission
        $('#dispatchForm').on('submit', function() {
            $('#createDispatch').prop('disabled', true)
                              .html('<i class="fas fa-spinner fa-spin"></i> Creating...');
        });
    });
</script>
@endsection

@section('styles')
<style>
    .step-section {
        border: 2px solid #e3e6f0;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .step-title {
        color: #5a5c69;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }
    
    .step-number {
        background: #4e73df;
        color: white;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 15px;
        font-size: 1.1rem;
    }
    
    .step-number.active {
        background: #1cc88a;
    }
    
    #barcodeInput {
        font-family: 'Courier New', monospace;
        font-size: 1.1rem;
    }
    
    .btn-xs {
        padding: 0.15rem 0.3rem;
        font-size: 0.7rem;
        line-height: 1.2;
        border-radius: 0.15rem;
    }
    
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .badge {
        font-size: 0.75rem;
    }
    
    code {
        background-color: #f1f3f4;
        padding: 0.2rem 0.4rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
    }
</style>
@endsection