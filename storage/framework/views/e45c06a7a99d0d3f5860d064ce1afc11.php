

<?php $__env->startSection('title', 'Companies Management'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="mb-2">
                    <a href="<?php echo e(route('pm.dashboard')); ?>" class="btn btn-outline-secondary btn-sm">
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
                <a href="<?php echo e(route('pm.companies.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>
                    Add New Company
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <?php echo e($errors->first()); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

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
                        <form method="GET" action="<?php echo e(route('pm.companies.index')); ?>" class="d-flex gap-2">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input 
                                    type="text" 
                                    name="search" 
                                    class="form-control border-start-0" 
                                    placeholder="Search companies..." 
                                    value="<?php echo e(request('search')); ?>"
                                    autocomplete="off"
                                >
                                <?php if(request('search')): ?>
                                    <a href="<?php echo e(route('pm.companies.index')); ?>" class="btn btn-outline-secondary" title="Clear search">
                                        <i class="bi bi-x-lg"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <?php if(request()->hasAny(['type', 'status'])): ?>
                                <?php $__currentLoopData = request()->only(['type', 'status']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
                
                <!-- Advanced Filters -->
                <div class="row mt-3">
                    <div class="col-12">
                        <form method="GET" action="<?php echo e(route('pm.companies.index')); ?>" class="d-flex flex-wrap gap-2 align-items-center">
                            <?php if(request('search')): ?>
                                <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                            <?php endif; ?>
                            
                            <div class="filter-group">
                                <label class="form-label small text-muted mb-1">Type:</label>
                                <select name="type" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                    <option value="">All Types</option>
                                    <option value="cash" <?php echo e(request('type') === 'cash' ? 'selected' : ''); ?>>Cash</option>
                                    <option value="credit" <?php echo e(request('type') === 'credit' ? 'selected' : ''); ?>>Credit</option>
                                    <option value="franking" <?php echo e(request('type') === 'franking' ? 'selected' : ''); ?>>Franking</option>
                                    <option value="prepaid" <?php echo e(request('type') === 'prepaid' ? 'selected' : ''); ?>>Prepaid</option>
                                </select>
                            </div>
                            
                            <div class="filter-group">
                                <label class="form-label small text-muted mb-1">Status:</label>
                                <select name="status" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                    <option value="">All Status</option>
                                    <option value="ACTIVE" <?php echo e(request('status') === 'ACTIVE' ? 'selected' : ''); ?>>Active</option>
                                    <option value="INACTIVE" <?php echo e(request('status') === 'INACTIVE' ? 'selected' : ''); ?>>Inactive</option>
                                </select>
                            </div>
                            
                            <?php if(request()->hasAny(['search', 'type', 'status'])): ?>
                                <a href="<?php echo e(route('pm.companies.index')); ?>" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-arrow-clockwise me-1"></i>
                                    Reset Filters
                                </a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
                
                <?php if(request()->hasAny(['search', 'type', 'status'])): ?>
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="bi bi-funnel me-1"></i>
                            Showing filtered results
                            <?php if(request('search')): ?>
                                for "<?php echo e(request('search')); ?>"
                            <?php endif; ?>
                        </small>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-body p-0">
                <?php if($companies->count() > 0): ?>
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
                                <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold"><?php echo e($company->name); ?></div>
                                        <small class="text-muted"><?php echo e(Str::limit($company->address, 50)); ?></small>
                                    </td>
                                    <td><?php echo e($company->telephone); ?></td>
                                    <td>
                                        <span class="badge 
                                            <?php if($company->type === 'cash'): ?> bg-success
                                            <?php elseif($company->type === 'credit'): ?> bg-warning text-dark
                                            <?php elseif($company->type === 'franking'): ?> bg-info
                                            <?php else: ?> bg-primary
                                            <?php endif; ?>">
                                            <?php echo e(ucfirst($company->type)); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge <?php echo e($company->status === 'ACTIVE' ? 'bg-success' : 'bg-secondary'); ?>">
                                            <?php echo e($company->status); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <?php if($company->type === 'prepaid'): ?>
                                            <span class="fw-bold text-<?php echo e($company->balance > 0 ? 'success' : 'danger'); ?>">
                                                LKR <?php echo e(number_format($company->balance, 2)); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted small">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?php echo e($company->creator?->name ?? 'System'); ?>

                                        </small>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?php echo e($company->created_at ? $company->created_at->format('M d, Y') : 'N/A'); ?>

                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?php echo e(route('pm.companies.show', $company)); ?>" class="btn btn-outline-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('pm.companies.edit', $company)); ?>" class="btn btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="<?php echo e(route('pm.companies.destroy', $company)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-outline-danger" title="Delete" 
                                                        onclick="return confirm('Are you sure you want to delete this company?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if($companies->hasPages()): ?>
                        <div class="d-flex justify-content-between align-items-center mt-3 px-3 py-2 bg-light rounded">
                            <div class="text-muted small">
                                Showing <?php echo e($companies->firstItem()); ?> to <?php echo e($companies->lastItem()); ?> of <?php echo e($companies->total()); ?> results
                            </div>
                            <div class="pagination-wrapper">
                                <nav>
                                    <ul class="pagination pagination-sm mb-0">
                                        
                                        <?php if($companies->onFirstPage()): ?>
                                            <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                        <?php else: ?>
                                            <li class="page-item"><a class="page-link" href="<?php echo e($companies->previousPageUrl()); ?>">Previous</a></li>
                                        <?php endif; ?>

                                        
                                        <?php $__currentLoopData = $companies->getUrlRange(1, $companies->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($page == $companies->currentPage()): ?>
                                                <li class="page-item active"><span class="page-link"><?php echo e($page); ?></span></li>
                                            <?php else: ?>
                                                <li class="page-item"><a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a></li>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        
                                        <?php if($companies->hasMorePages()): ?>
                                            <li class="page-item"><a class="page-link" href="<?php echo e($companies->nextPageUrl()); ?>">Next</a></li>
                                        <?php else: ?>
                                            <li class="page-item disabled"><span class="page-link">Next</span></li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="no-results">
                        <?php if(request()->hasAny(['search', 'type', 'status'])): ?>
                            <i class="bi bi-search display-6 text-muted"></i>
                            <h5 class="text-muted mt-3">No Companies Match Your Search</h5>
                            <p class="text-muted mb-3">
                                <?php if(request('search')): ?>
                                    No companies found for "<?php echo e(request('search')); ?>"
                                <?php else: ?>
                                    No companies found with the selected filters
                                <?php endif; ?>
                            </p>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="<?php echo e(route('pm.companies.index')); ?>" class="btn btn-outline-primary">
                                    <i class="bi bi-arrow-clockwise me-2"></i>
                                    Clear Filters
                                </a>
                                <a href="<?php echo e(route('pm.companies.create')); ?>" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i>
                                    Add New Company
                                </a>
                            </div>
                        <?php else: ?>
                            <i class="bi bi-building display-6 text-muted"></i>
                            <h5 class="text-muted mt-3">No Companies Found</h5>
                            <p class="text-muted">Start by adding your first company</p>
                            <a href="<?php echo e(route('pm.companies.create')); ?>" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>
                                Add First Company
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
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
        <?php if(request('search')): ?>
            searchInput.focus();
            searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
        <?php endif; ?>
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
            countSpan.textContent = `<?php echo e($companies->total()); ?>`;
            cardTitle.appendChild(countSpan);
        }
    }

    // Highlight search terms
    <?php if(request('search')): ?>
        const searchTerm = <?php echo json_encode(request('search'), 15, 512) ?>;
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
    <?php endif; ?>
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.modern-pm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\NEW_ONE-main\resources\views/pm/companies/index.blade.php ENDPATH**/ ?>