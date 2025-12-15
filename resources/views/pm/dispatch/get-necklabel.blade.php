@extends('layouts.modern-pm')

@section('title', 'Get Necklabel by Barcode')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-search text-info"></i>
            Get Necklabel by Item Barcode
        </h1>
        <a href="{{ route('pm.dispatch.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Dispatches
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

    <!-- Barcode Input Form -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-barcode"></i> Enter Item Barcode
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-search fa-3x text-info mb-3"></i>
                        <h5>Get Necklabel Information</h5>
                        <p class="text-muted">Enter an item barcode to find which dispatch it belongs to and view the necklabel and destination office.</p>
                    </div>

                    <form method="POST" action="{{ route('pm.dispatch.search-by-barcode') }}">
                        @csrf
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
                                   autocomplete="off"
                                   autofocus>
                            @error('barcode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-info btn-lg">
                                <i class="fas fa-search"></i> Get Necklabel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Information Card -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card border-info">
                <div class="card-header bg-light">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-info-circle"></i> What You'll See
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Item Information:</h6>
                            <ul class="mb-3">
                                <li>Item ID and Barcode</li>
                                <li>Receiver Name and Address</li>
                                <li>Weight and Amount</li>
                                <li>Current Status</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-success">Dispatch Information:</h6>
                            <ul class="mb-3">
                                <li>Necklabel</li>
                                <li>Manifest ID</li>
                                <li>Destination Office</li>
                                <li>Dispatch Status</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
