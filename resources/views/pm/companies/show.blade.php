@extends('layouts.modern-pm')

@section('title', 'Company Details')

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
                    <i class="bi bi-building me-2 text-primary"></i>
                    {{ $company->name }}
                </h2>
                <p class="text-muted mb-0">Company details and balance management</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('pm.companies.edit', $company) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-2"></i>
                    Edit Company
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
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
        {{ $errors->first() }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <!-- Company Information -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    Company Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">COMPANY NAME</label>
                        <div class="fw-bold fs-5">{{ $company->name }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">TELEPHONE</label>
                        <div class="fw-bold">{{ $company->telephone }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">EMAIL</label>
                        <div class="fw-bold">{{ $company->email ?? 'Not provided' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">TYPE</label>
                        <div>
                            <span class="badge fs-6 
                                @if($company->type === 'cash') bg-success
                                @elseif($company->type === 'credit') bg-warning text-dark
                                @elseif($company->type === 'franking') bg-info
                                @else bg-primary
                                @endif">
                                {{ ucfirst($company->type) }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">STATUS</label>
                        <div>
                            <span class="badge fs-6 {{ $company->status === 'ACTIVE' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $company->status }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">ASSIGNED POST OFFICE</label>
                        <div class="fw-bold">{{ $company->assignedPostoffice->name ?? 'Not assigned' }}</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label text-muted small">ADDRESS</label>
                        <div class="fw-bold">{{ $company->address }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">CREATED BY</label>
                        <div class="fw-bold">{{ $company->creator?->name ?? 'System' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">CREATED AT</label>
                        <div class="fw-bold">{{ $company->created_at ? $company->created_at->format('M d, Y H:i') : 'Not available' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Balance History -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clock-history me-2"></i>
                    Balance History
                </h5>
            </div>
            <div class="card-body">
                @if($company->deposits->count() > 0 || $company->withdraws->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $transactions = collect();
                                    foreach($company->deposits as $deposit) {
                                        $transactions->push([
                                            'type' => 'deposit',
                                            'date' => $deposit->created_at,
                                            'description' => $deposit->description,
                                            'amount' => $deposit->amount
                                        ]);
                                    }
                                    foreach($company->withdraws as $withdraw) {
                                        $transactions->push([
                                            'type' => 'withdraw',
                                            'date' => $withdraw->created_at,
                                            'description' => $withdraw->description,
                                            'amount' => $withdraw->amount
                                        ]);
                                    }
                                    $transactions = $transactions->sortByDesc('date')->take(10);
                                @endphp
                                
                                @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction['date'] ? \Carbon\Carbon::parse($transaction['date'])->format('M d, Y H:i') : 'N/A' }}</td>
                                    <td>
                                        <span class="badge {{ $transaction['type'] === 'deposit' ? 'bg-success' : 'bg-danger' }}">
                                            <i class="bi {{ $transaction['type'] === 'deposit' ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                            {{ ucfirst($transaction['type']) }}
                                        </span>
                                    </td>
                                    <td>{{ $transaction['description'] }}</td>
                                    <td class="text-{{ $transaction['type'] === 'deposit' ? 'success' : 'danger' }}">
                                        {{ $transaction['type'] === 'deposit' ? '+' : '-' }}LKR {{ number_format($transaction['amount'], 2) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="bi bi-clock-history display-4 text-muted"></i>
                        <p class="text-muted mt-2">No balance transactions yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($company->type === 'prepaid')
    <!-- Balance Management Panel -->
    <div class="col-lg-4">
        <!-- Current Balance -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-success text-white text-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-wallet me-2"></i>
                    Current Balance
                </h5>
            </div>
            <div class="card-body text-center">
                <div class="display-4 fw-bold text-{{ $company->balance > 0 ? 'success' : 'danger' }}">
                    LKR {{ number_format($company->balance, 2) }}
                </div>
            </div>
        </div>

        <!-- Add Balance -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h6 class="card-title mb-0">
                    <i class="bi bi-plus-circle me-2"></i>
                    Add Balance
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('pm.companies.add-balance', $company) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="add_amount" class="form-label">Amount (LKR)</label>
                        <input type="number" class="form-control" id="add_amount" name="amount" 
                               step="0.01" min="0.01" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-plus-circle me-2"></i>
                        Add Balance
                    </button>
                </form>
            </div>
        </div>

        <!-- Deduct Balance -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h6 class="card-title mb-0">
                    <i class="bi bi-dash-circle me-2"></i>
                    Deduct Balance
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('pm.companies.deduct-balance', $company) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="deduct_amount" class="form-label">Amount (LKR)</label>
                        <input type="number" class="form-control" id="deduct_amount" name="amount" 
                               step="0.01" min="0.01" max="{{ $company->balance }}" required>
                        <small class="text-muted">Available: LKR {{ number_format($company->balance, 2) }}</small>
                    </div>

                    <button type="submit" class="btn btn-warning w-100" 
                            {{ $company->balance <= 0 ? 'disabled' : '' }}>
                        <i class="bi bi-dash-circle me-2"></i>
                        Deduct Balance
                    </button>
                </form>
            </div>
        </div>
    </div>
    @else
    <!-- Non-Prepaid Company Notice -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-info text-white text-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    {{ ucfirst($company->type) }} Company
                </h5>
            </div>
            <div class="card-body text-center">
                <p class="text-muted">
                    @if($company->type === 'cash')
                        This company pays cash for each service.
                    @elseif($company->type === 'credit')
                        This company uses credit facility for services.
                    @elseif($company->type === 'franking')
                        This company uses franking machine services.
                    @endif
                </p>
                <p class="small text-muted mb-0">
                    No prepaid balance management required.
                </p>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection