@extends('layouts.modern-pm')

@section('title', 'Change Dispatch Location - Step 2')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-exchange-alt text-warning"></i>
            Change Dispatch Location - Step 2
        </h1>
        <a href="{{ route('pm.dispatch.change-location') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Step 1
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

    <!-- Step Progress -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="step-item completed">
                            <div class="step-number bg-success text-white">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="step-title">Enter Necklabel</div>
                        </div>
                        <div class="step-line completed"></div>
                        <div class="step-item active">
                            <div class="step-number bg-primary text-white">2</div>
                            <div class="step-title">Enter Barcode</div>
                        </div>
                        <div class="step-line"></div>
                        <div class="step-item">
                            <div class="step-number bg-secondary text-white">3</div>
                            <div class="step-title">Select New Office</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dispatch Information -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-success">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-check-circle"></i> Dispatch Found
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Necklabel:</strong> {{ $dispatch->necklabel }}</p>
                            <p><strong>Manifest ID:</strong> {{ $dispatch->manifest_id }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Current Destination:</strong> {{ $dispatch->destinationOffice->name }}</p>
                            <p><strong>Total Items:</strong> {{ $dispatch->dispatchAssociates->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Barcode Verification Form -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-barcode"></i> Verify Item Barcode
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-barcode fa-3x text-warning mb-3"></i>
                        <h5>Enter Item Barcode for Verification</h5>
                        <p class="text-muted">Enter the barcode of any item in this dispatch to proceed with location change.</p>
                    </div>

                    <form method="POST" action="{{ route('pm.dispatch.verify-item-barcode') }}">
                        @csrf
                        <input type="hidden" name="dispatch_id" value="{{ $dispatch->id }}">
                        
                        <div class="form-group">
                            <label for="barcode" class="form-label font-weight-bold">
                                <i class="fas fa-barcode"></i> Item Barcode
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('barcode') is-invalid @enderror" 
                                   id="barcode" 
                                   name="barcode" 
                                   value="{{ old('barcode') }}" 
                                   placeholder="Enter item barcode..." 
                                   required
                                   autocomplete="off">
                            @error('barcode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="fas fa-check"></i> Verify Barcode
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Items List -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-10">
            <div class="card border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-list"></i> Items in this Dispatch
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Item ID</th>
                                    <th>Barcode</th>
                                    <th>Receiver Name</th>
                                    <th>Weight (kg)</th>
                                    <th>Amount (LKR)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dispatch->dispatchAssociates as $associate)
                                    <tr>
                                        <td>{{ $associate->item->id }}</td>
                                        <td><code>{{ $associate->item->barcode }}</code></td>
                                        <td>{{ $associate->item->receiver_name }}</td>
                                        <td>{{ number_format($associate->item->weight, 2) }}</td>
                                        <td>{{ number_format($associate->item->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.step-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex: 1;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-bottom: 8px;
}

.step-title {
    font-size: 14px;
    font-weight: 500;
    text-align: center;
}

.step-line {
    height: 2px;
    background-color: #dee2e6;
    flex: 1;
    margin: 20px 15px 0 15px;
}

.step-line.completed {
    background-color: #28a745;
}

.step-item.active .step-number {
    background-color: #007bff !important;
}

.step-item.completed .step-number {
    background-color: #28a745 !important;
}
</style>
@endsection