<?php $__env->startSection('title', 'User Management'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-start">
            <div class="d-flex align-items-center">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-secondary me-3" title="Back to Dashboard">
                    <i class="bi bi-arrow-left me-1"></i>Dashboard
                </a>
                <div>
                    <p class="text-muted mb-0">Manage all system users and their permissions</p>
                </div>
            </div>
            <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">
                <i class="bi bi-person-plus me-2"></i>Create New User
            </a>
        </div>
    </div>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Search and Filter Section -->
<div class="stat-card mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-semibold mb-0 text-muted">Search & Filter Users</h6>
        <small class="text-muted">
            <?php if(isset($users)): ?>
                Showing <?php echo e($users->count()); ?> of <?php echo e($users->total()); ?> users
                <?php if(request()->hasAny(['search', 'role', 'type'])): ?>
                    <span class="badge bg-primary bg-opacity-10 text-primary ms-1">Filtered</span>
                <?php endif; ?>
            <?php endif; ?>
        </small>
    </div>
    
    <div class="row g-3">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0 ps-0" id="searchNic" 
                       placeholder="Search by NIC, name, or email..." value="<?php echo e(request('search')); ?>">
            </div>
        </div>
        <div class="col-md-2">
            <select class="form-select" id="filterRole">
                <option value="">All Roles</option>
                <option value="admin" <?php echo e(request('role') === 'admin' ? 'selected' : ''); ?>>Admin</option>
                <option value="pm" <?php echo e(request('role') === 'pm' ? 'selected' : ''); ?>>Postmaster</option>
                <option value="postman" <?php echo e(request('role') === 'postman' ? 'selected' : ''); ?>>Postman</option>
                <option value="customer" <?php echo e(request('role') === 'customer' ? 'selected' : ''); ?>>Customer</option>
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-select" id="filterType">
                <option value="">All Types</option>
                <option value="internal" <?php echo e(request('type') === 'internal' ? 'selected' : ''); ?>>Internal</option>
                <option value="external" <?php echo e(request('type') === 'external' ? 'selected' : ''); ?>>External</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-outline-secondary w-100" onclick="clearFilters()">
                <i class="bi bi-arrow-clockwise me-1"></i>Reset
            </button>
        </div>
        <div class="col-md-2">
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-primary flex-fill" onclick="exportUsers()">
                    <i class="bi bi-download"></i>
                </button>
                <button type="button" class="btn btn-outline-info flex-fill" onclick="refreshUsers()">
                    <i class="bi bi-arrow-clockwise"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="stat-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th class="fw-semibold text-muted">ID</th>
                    <th class="fw-semibold text-muted">User</th>
                    <th class="fw-semibold text-muted">Contact</th>
                    <th class="fw-semibold text-muted">Type & Role</th>
                    <th class="fw-semibold text-muted">Location</th>
                    <th class="fw-semibold text-muted">Status</th>
                    <th class="fw-semibold text-muted">Created</th>
                    <th class="fw-semibold text-muted text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="text-muted">#<?php echo e($user->id); ?></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="user-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 40px; height: 40px; font-size: 0.9rem; font-weight: 600;">
                                <?php echo e(substr($user->name, 0, 1)); ?>

                            </div>
                            <div>
                                <div class="fw-medium"><?php echo e($user->name); ?></div>
                                <div class="text-muted small"><?php echo e($user->nic); ?></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="text-muted small">
                            <?php if($user->email): ?>
                                <div><i class="bi bi-envelope me-1"></i><?php echo e($user->email); ?></div>
                            <?php endif; ?>
                            <?php if($user->mobile): ?>
                                <div><i class="bi bi-phone me-1"></i><?php echo e($user->mobile); ?></div>
                            <?php endif; ?>
                            <?php if(!$user->email && !$user->mobile): ?>
                                <span class="text-muted">No contact info</span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <div>
                            <?php if($user->user_type === 'internal'): ?>
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-20">Internal</span>
                            <?php else: ?>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-20">External</span>
                            <?php endif; ?>
                        </div>
                        <div class="mt-1">
                            <?php if($user->role === 'admin'): ?>
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-20">Admin</span>
                            <?php elseif($user->role === 'pm'): ?>
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-20">Postmaster</span>
                            <?php elseif($user->role === 'postman'): ?>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20">Postman</span>
                            <?php else: ?>
                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-20">Customer</span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <?php if($user->location): ?>
                            <div class="fw-medium"><?php echo e($user->location->name); ?></div>
                            <div class="text-muted small"><?php echo e($user->location->code); ?> - <?php echo e($user->location->city); ?></div>
                        <?php else: ?>
                            <span class="text-muted">Not assigned</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($user->is_active): ?>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20">
                                <i class="bi bi-check-circle me-1"></i>Active
                            </span>
                        <?php else: ?>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-20">
                                <i class="bi bi-x-circle me-1"></i>Inactive
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="text-muted small"><?php echo e($user->created_at->format('M d, Y')); ?></td>
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="<?php echo e(route('admin.users.edit', $user)); ?>" 
                               class="btn btn-outline-primary btn-sm"
                               title="Edit User">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <?php if($user->id !== auth()->id()): ?>
                                <form method="POST" action="<?php echo e(route('admin.users.toggle-status', $user)); ?>" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <button type="submit" 
                                            class="btn btn-outline-<?php echo e($user->is_active ? 'warning' : 'success'); ?> btn-sm"
                                            onclick="return confirm('Are you sure you want to <?php echo e($user->is_active ? 'deactivate' : 'activate'); ?> this user?')"
                                            title="<?php echo e($user->is_active ? 'Deactivate' : 'Activate'); ?> User">
                                        <i class="bi bi-<?php echo e($user->is_active ? 'pause' : 'play'); ?>-circle"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-inbox display-4 d-block mb-3 opacity-25"></i>
                            <h5>No users found</h5>
                            <p class="mb-0">Get started by creating your first user.</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
</div>

<script>
// Real-time search functionality
let searchTimeout;

document.getElementById('searchNic').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        filterUsers();
    }, 500);
});

document.getElementById('filterRole').addEventListener('change', filterUsers);
document.getElementById('filterType').addEventListener('change', filterUsers);

function filterUsers() {
    const search = document.getElementById('searchNic').value;
    const role = document.getElementById('filterRole').value;
    const type = document.getElementById('filterType').value;
    
    let url = new URL(window.location.href);
    url.searchParams.delete('page'); // Reset pagination
    
    if (search) {
        url.searchParams.set('search', search);
    } else {
        url.searchParams.delete('search');
    }
    
    if (role) {
        url.searchParams.set('role', role);
    } else {
        url.searchParams.delete('role');
    }
    
    if (type) {
        url.searchParams.set('type', type);
    } else {
        url.searchParams.delete('type');
    }
    
    window.location.href = url.toString();
}

function clearFilters() {
    document.getElementById('searchNic').value = '';
    document.getElementById('filterRole').value = '';
    document.getElementById('filterType').value = '';
    
    // Redirect to clean URL
    window.location.href = window.location.pathname;
}

function exportUsers() {
    // Add export functionality
    alert('Export functionality coming soon!');
}

function refreshUsers() {
    window.location.reload();
}

// Highlight search terms in table
document.addEventListener('DOMContentLoaded', function() {
    const searchTerm = '<?php echo e(request("search")); ?>';
    if (searchTerm) {
        highlightSearchTerm(searchTerm);
    }
});

function highlightSearchTerm(term) {
    if (!term) return;
    
    const tableBody = document.querySelector('tbody');
    if (!tableBody) return;
    
    const regex = new RegExp(`(${term})`, 'gi');
    
    tableBody.querySelectorAll('td').forEach(cell => {
        if (cell.textContent.includes(term)) {
            cell.innerHTML = cell.innerHTML.replace(regex, '<mark class="bg-warning bg-opacity-25">$1</mark>');
        }
    });
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.modern-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\NEW_ONE-main\resources\views/admin/users/modern-index.blade.php ENDPATH**/ ?>