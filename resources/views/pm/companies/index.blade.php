@extends('layouts.modern-pm')

@section('title', 'Companies Management')

@section('content')
<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="mb-2">
                    <a href="{{ route('pm.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>
                        Back to Dashboard
                    </a>
                </div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-building me-2 text-primary"></i>
                    Companies Management
                </h2>
                <p class="text-muted mb-0">Manage companies, their balances and settings</p>
            </div>
            <div>
                <a href="{{ route('pm.companies.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>
                    Add New Company
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

<!-- Companies Table -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-list me-2"></i>
                            Companies List
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('pm.companies.index') }}" class="d-flex gap-2">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input
                                    type="text"
                                    name="search"
                                    class="form-control border-start-0"
                                    placeholder="Search companies..."
                                    value="{{ request('search') }}"
                                    autocomplete="off"
                                >
                                @if(request('search'))
                                    <a href="{{ route('pm.companies.index') }}" class="btn btn-outline-secondary" title="Clear search">
                                        <i class="bi bi-x-lg"></i>
                                    </a>
                                @endif
                            </div>
                            @if(request()->hasAny(['type', 'status']))
                                @foreach(request()->only(['type', 'status']) as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Advanced Filters -->
                <div class="row mt-3">
                    <div class="col-12">
                        <form method="GET" action="{{ route('pm.companies.index') }}" class="d-flex flex-wrap gap-2 align-items-center">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif

                            <div class="filter-group">
                                <label class="form-label small text-muted mb-1">Type:</label>
                                <select name="type" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                    <option value="">All Types</option>
                                    <option value="cash" {{ request('type') === 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="credit" {{ request('type') === 'credit' ? 'selected' : '' }}>Credit</option>
                                    <option value="franking" {{ request('type') === 'franking' ? 'selected' : '' }}>Franking</option>
                                    <option value="prepaid" {{ request('type') === 'prepaid' ? 'selected' : '' }}>Prepaid</option>
                                </select>
                            </div>

                            <div class="filter-group">
                                <label class="form-label small text-muted mb-1">Status:</label>
                                <select name="status" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                    <option value="">All Status</option>
                                    <option value="ACTIVE" {{ request('status') === 'ACTIVE' ? 'selected' : '' }}>Active</option>
                                    <option value="INACTIVE" {{ request('status') === 'INACTIVE' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            @if(request()->hasAny(['search', 'type', 'status']))
                                <a href="{{ route('pm.companies.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-arrow-clockwise me-1"></i>
                                    Reset Filters
                                </a>
                            @endif
                        </form>
                    </div>
                </div>

                @if(request()->hasAny(['search', 'type', 'status']))
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="bi bi-funnel me-1"></i>
                            Showing filtered results
                            @if(request('search'))
                                for "{{ request('search') }}"
                            @endif
                        </small>
                    </div>
                @endif
            </div>
            <div class="card-body p-0">
                @if($companies->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Company Name</th>
                                    <th>Telephone</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Balance</th>
                                    <th>Created By</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($companies as $company)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $company->name }}</div>
                                        <small class="text-muted">{{ Str::limit($company->address, 50) }}</small>
                                    </td>
                                    <td>{{ $company->telephone }}</td>
                                    <td>
                                        <span class="badge
                                            @if($company->type === 'cash') bg-success
                                            @elseif($company->type === 'credit') bg-warning text-dark
                                            @elseif($company->type === 'franking') bg-info
                                            @else bg-primary
                                            @endif">
                                            {{ ucfirst($company->type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $company->status === 'ACTIVE' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $company->status }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($company->type === 'prepaid')
                                            <span class="fw-bold text-{{ $company->balance > 0 ? 'success' : 'danger' }}">
                                                LKR {{ number_format($company->balance, 2) }}
                                            </span>
                                        @else
                                            <span class="text-muted small">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $company->creator?->name ?? 'System' }}
                                        </small>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $company->created_at ? $company->created_at->format('M d, Y') : 'N/A' }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('pm.companies.show', $company) }}" class="btn btn-outline-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('pm.companies.edit', $company) }}" class="btn btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('pm.companies.destroy', $company) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this company?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($companies->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3 px-3 py-2 bg-light rounded">
                            <div class="text-muted small">
                                Showing {{ $companies->firstItem() }} to {{ $companies->lastItem() }} of {{ $companies->total() }} results
                            </div>
                            <div class="pagination-wrapper">
                                <nav>
                                    <ul class="pagination pagination-sm mb-0">
                                        {{-- Previous Page Link --}}
                                        @if($companies->onFirstPage())
                                            <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                        @else
                                            <li class="page-item"><a class="page-link" href="{{ $companies->previousPageUrl() }}">Previous</a></li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @foreach($companies->getUrlRange(1, $companies->lastPage()) as $page => $url)
                                            @if($page == $companies->currentPage())
                                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                            @else
                                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach

                                        {{-- Next Page Link --}}
                                        @if($companies->hasMorePages())
                                            <li class="page-item"><a class="page-link" href="{{ $companies->nextPageUrl() }}">Next</a></li>
                                        @else
                                            <li class="page-item disabled"><span class="page-link">Next</span></li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="no-results">
                        @if(request()->hasAny(['search', 'type', 'status']))
                            <i class="bi bi-search display-6 text-muted"></i>
                            <h5 class="text-muted mt-3">No Companies Match Your Search</h5>
                            <p class="text-muted mb-3">
                                @if(request('search'))
                                    No companies found for "{{ request('search') }}"
                                @else
                                    No companies found with the selected filters
                                @endif
                            </p>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('pm.companies.index') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-arrow-clockwise me-2"></i>
                                    Clear Filters
                                </a>
                                <a href="{{ route('pm.companies.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i>
                                    Add New Company
                                </a>
                            </div>
                        @else
                            <i class="bi bi-building display-6 text-muted"></i>
                            <h5 class="text-muted mt-3">No Companies Found</h5>
                            <p class="text-muted">Start by adding your first company</p>
                            <a href="{{ route('pm.companies.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>
                                Add First Company
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit search form when typing (with debounce)
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (this.value.length >= 2 || this.value.length === 0) {
                    this.form.submit();
                }
            }, 500); // Wait 500ms after user stops typing
        });

        // Focus search input if there's a search parameter
        @if(request('search'))
            searchInput.focus();
            searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
        @endif
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl+K or Cmd+K to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
            }
        }

        // Escape to clear search
        if (e.key === 'Escape' && searchInput && document.activeElement === searchInput) {
            if (searchInput.value) {
                searchInput.value = '';
                searchInput.form.submit();
            }
        }
    });

    // Add search result count
    const tableBody = document.querySelector('.table tbody');
    if (tableBody && tableBody.children.length > 0) {
        const resultCount = tableBody.children.length;
        const cardTitle = document.querySelector('.card-title');
        if (cardTitle) {
            const countSpan = document.createElement('span');
            countSpan.className = 'badge bg-primary ms-2';
            countSpan.textContent = `{{ $companies->total() }}`;
            cardTitle.appendChild(countSpan);
        }
    }

    // Highlight search terms
    @if(request('search'))
        const searchTerm = @json(request('search'));
        if (searchTerm) {
            const tableRows = document.querySelectorAll('.table tbody tr');
            tableRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                cells.forEach(cell => {
                    if (!cell.querySelector('button, a, .btn')) {
                        const regex = new RegExp(`(${searchTerm})`, 'gi');
                        cell.innerHTML = cell.innerHTML.replace(regex, '<span class="search-highlight">$1</span>');
                    }
                });
            });
        }
    @endif
});
</script>
@endsection
