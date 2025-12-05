@extends('layouts.modern-pm')

@section('title', 'Add Items to Dispatch')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-barcode text-primary"></i>
            Add Items to Dispatch: {{ $dispatch->manifest_id }}
        </h1>
        <div>
            <a href="{{ route('pm.dispatch.manifest', $dispatch->id) }}" class="btn btn-sm btn-info shadow-sm mr-2">
                <i class="fas fa-file-alt fa-sm text-white-50"></i> Generate Manifest
            </a>
            <a href="{{ route('pm.dispatch.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Dispatches
            </a>
        </div>
    </div>

    <!-- Dispatch Information -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-left-primary shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Manifest ID
                            </div>
                            <div class="h6 mb-0 text-gray-900">{{ $dispatch->manifest_id }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Neck Label
                            </div>
                            <div class="h6 mb-0 text-gray-900">{{ $dispatch->necklabel }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Destination Office
                            </div>
                            <div class="h6 mb-0 text-gray-900">{{ $dispatch->destinationOffice->name }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Items Added
                            </div>
                            <div class="h6 mb-0 text-gray-900">
                                <span id="itemsCount">{{ $dispatch->dispatchAssociates->count() }}</span> items
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Barcode Scanner Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-scan"></i> Barcode Scanner
                    </h6>
                </div>
                <div class="card-body">
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
                                   autocomplete="off"
                                   autofocus>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="addItemBtn">
                                    <i class="fas fa-plus"></i> Add Item
                                </button>
                            </div>
                        </div>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i>
                            Use a barcode scanner or type the barcode manually. Press Enter or click Add Item.
                        </small>
                    </div>

                    <!-- Status Messages -->
                    <div id="barcodeMessage" class="mt-3" style="display: none;"></div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-left-success shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Scanner Status
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="scannerStatus">
                                <i class="fas fa-check-circle text-success"></i> Ready
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-qrcode fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Added Items List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list"></i> Items Added to Dispatch
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dispatchItemsTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Barcode</th>
                            <th>Receiver Name</th>
                            <th>Address</th>
                            <th>Amount (LKR)</th>
                            <th>Weight (g)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dispatch->dispatchAssociates as $index => $associate)
                            <tr data-item-id="{{ $associate->item->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $associate->item->barcode }}</span>
                                </td>
                                <td>{{ $associate->item->receiver_name }}</td>
                                <td>{{ Str::limit($associate->item->receiver_address, 50) }}</td>
                                <td>{{ number_format($associate->item->amount, 2) }}</td>
                                <td>{{ $associate->item->weight ?? 'N/A' }}</td>
                                <td>
                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger remove-item-btn"
                                            data-item-id="{{ $associate->item->id }}"
                                            title="Remove from dispatch">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($dispatch->dispatchAssociates->count() === 0)
                <div class="text-center py-5" id="emptyState">
                    <i class="fas fa-box-open fa-3x text-gray-300"></i>
                    <h5 class="mt-3 text-gray-600">No items added yet</h5>
                    <p class="text-gray-500">Start scanning barcodes to add items to this dispatch.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Available Items for Reference -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-secondary">
                <i class="fas fa-search"></i> Available Items for Dispatch
            </h6>
        </div>
        <div class="card-body">
            @if($availableItems->count() > 0)
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Barcode</th>
                                <th>Receiver Name</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($availableItems as $item)
                                <tr>
                                    <td>
                                        <code>{{ $item->barcode }}</code>
                                        <button type="button"
                                                class="btn btn-xs btn-outline-primary ml-2 copy-barcode"
                                                data-barcode="{{ $item->barcode }}"
                                                title="Copy barcode">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </td>
                                    <td>{{ $item->receiver_name }}</td>
                                    <td>LKR {{ number_format($item->amount, 2) }}</td>
                                    <td>
                                        <span class="badge badge-success">{{ ucfirst($item->status) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-3">
                    <i class="fas fa-inbox fa-2x text-gray-300"></i>
                    <p class="mt-2 text-gray-500">No items available for dispatch</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        let itemCounter = {{ $dispatch->dispatchAssociates->count() }};

        // Focus on barcode input
        $('#barcodeInput').focus();

        // Handle barcode input (Enter key or Add button)
        $('#barcodeInput').on('keypress', function(e) {
            if (e.which === 13) { // Enter key
                e.preventDefault();
                addItemByBarcode();
            }
        });

        $('#addItemBtn').on('click', function() {
            addItemByBarcode();
        });

        // Add item by barcode function
        function addItemByBarcode() {
            const barcode = $('#barcodeInput').val().trim();

            if (!barcode) {
                showMessage('Please enter or scan a barcode', 'warning');
                return;
            }

            // Update scanner status
            $('#scannerStatus').html('<i class="fas fa-spinner fa-spin text-primary"></i> Processing...');

            $.ajax({
                url: '{{ route("pm.dispatch.add-item-barcode", $dispatch->id) }}',
                type: 'POST',
                data: {
                    barcode: barcode,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Add item to table
                        addItemToTable(response.item);

                        // Update counter
                        itemCounter++;
                        $('#itemsCount').text(itemCounter);

                        // Clear input
                        $('#barcodeInput').val('').focus();

                        // Hide empty state
                        $('#emptyState').hide();

                        showMessage('Item added successfully: ' + response.item.barcode, 'success');

                        // Play success sound (optional)
                        playSuccessSound();
                    } else {
                        showMessage(response.message, 'error');
                    }

                    $('#scannerStatus').html('<i class="fas fa-check-circle text-success"></i> Ready');
                },
                error: function(xhr) {
                    let message = 'Error adding item';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    showMessage(message, 'error');
                    $('#scannerStatus').html('<i class="fas fa-exclamation-circle text-danger"></i> Error');

                    // Reset after 2 seconds
                    setTimeout(function() {
                        $('#scannerStatus').html('<i class="fas fa-check-circle text-success"></i> Ready');
                    }, 2000);
                }
            });
        }

        // Add item to table
        function addItemToTable(item) {
            const newRow = `
                <tr data-item-id="${item.id}">
                    <td>${itemCounter + 1}</td>
                    <td><span class="badge badge-info">${item.barcode}</span></td>
                    <td>${item.receiver_name}</td>
                    <td>${item.receiver_address.substring(0, 50)}${item.receiver_address.length > 50 ? '...' : ''}</td>
                    <td>${parseFloat(item.amount).toFixed(2)}</td>
                    <td>${item.weight || 'N/A'}</td>
                    <td>
                        <button type="button"
                                class="btn btn-sm btn-outline-danger remove-item-btn"
                                data-item-id="${item.id}"
                                title="Remove from dispatch">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;

            $('#dispatchItemsTable tbody').append(newRow);
        }

        // Remove item from dispatch
        $(document).on('click', '.remove-item-btn', function() {
            const itemId = $(this).data('item-id');
            const row = $(this).closest('tr');

            if (confirm('Are you sure you want to remove this item from the dispatch?')) {
                $.ajax({
                    url: '{{ route("pm.dispatch.remove-item", $dispatch->id) }}',
                    type: 'DELETE',
                    data: {
                        item_id: itemId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            row.remove();
                            itemCounter--;
                            $('#itemsCount').text(itemCounter);
                            showMessage('Item removed from dispatch', 'success');

                            // Show empty state if no items
                            if (itemCounter === 0) {
                                $('#emptyState').show();
                            }

                            // Update row numbers
                            updateRowNumbers();
                        }
                    },
                    error: function() {
                        showMessage('Error removing item', 'error');
                    }
                });
            }
        });

        // Update row numbers
        function updateRowNumbers() {
            $('#dispatchItemsTable tbody tr').each(function(index) {
                $(this).find('td:first').text(index + 1);
            });
        }

        // Copy barcode to input
        $('.copy-barcode').on('click', function() {
            const barcode = $(this).data('barcode');
            $('#barcodeInput').val(barcode).focus();
            showMessage('Barcode copied to input', 'info');
        });

        // Show message function
        function showMessage(message, type) {
            const alertClass = {
                'success': 'alert-success',
                'error': 'alert-danger',
                'warning': 'alert-warning',
                'info': 'alert-info'
            }[type] || 'alert-info';

            const icon = {
                'success': 'fa-check-circle',
                'error': 'fa-exclamation-triangle',
                'warning': 'fa-exclamation-circle',
                'info': 'fa-info-circle'
            }[type] || 'fa-info-circle';

            $('#barcodeMessage').html(`
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    <i class="fas ${icon}"></i> ${message}
                    <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            `).show();

            // Auto-hide after 5 seconds
            setTimeout(function() {
                $('#barcodeMessage .alert').alert('close');
            }, 5000);
        }

        // Play success sound (optional)
        function playSuccessSound() {
            // You can add a success sound here if needed
            // const audio = new Audio('/sounds/beep-success.mp3');
            // audio.play();
        }

        // Auto-focus on barcode input when clicking anywhere
        $(document).on('click', function() {
            if (!$(event.target).is('input, button, select, textarea, a')) {
                $('#barcodeInput').focus();
            }
        });

        // Prevent form submission on Enter
        $(document).on('keypress', function(e) {
            if (e.which === 13 && !$(e.target).is('textarea')) {
                e.preventDefault();
            }
        });
    });
</script>
@endsection

@section('styles')
<style>
    .table th {
        background-color: #f8f9fc;
        border-top: none;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .badge {
        font-size: 0.75rem;
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    #barcodeInput {
        font-family: 'Courier New', monospace;
        font-size: 1.1rem;
    }

    .copy-barcode {
        font-size: 0.7rem;
        padding: 0.15rem 0.3rem;
    }

    .btn-xs {
        padding: 0.15rem 0.3rem;
        font-size: 0.7rem;
        line-height: 1.2;
        border-radius: 0.15rem;
    }

    .alert {
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    code {
        background-color: #f1f3f4;
        padding: 0.2rem 0.4rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
    }
</style>
@endsection
