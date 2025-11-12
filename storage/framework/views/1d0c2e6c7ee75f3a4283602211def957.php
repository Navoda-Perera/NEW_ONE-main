<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">Welcome back, <?php echo e(auth('admin')->user()->name); ?>!</h2>
                <p class="text-muted mb-0">Here's what's happening with your postal system today.</p>
            </div>
            <div class="text-muted">
                <i class="bi bi-calendar3"></i> <?php echo e(now()->format('M d, Y')); ?>

            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-number stat-primary"><?php echo e($totalUsers); ?></div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="stat-icon stat-primary">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-number stat-success"><?php echo e($adminUsers); ?></div>
                    <div class="stat-label">Admin Users</div>
                </div>
                <div class="stat-icon stat-success">
                    <i class="bi bi-shield-check"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-number stat-info"><?php echo e($pmUsers); ?></div>
                    <div class="stat-label">Postmasters</div>
                </div>
                <div class="stat-icon stat-info">
                    <i class="bi bi-briefcase"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-number stat-secondary"><?php echo e($postmanUsers); ?></div>
                    <div class="stat-label">Postmen</div>
                </div>
                <div class="stat-icon stat-secondary">
                    <i class="bi bi-truck"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Second Row -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-number stat-warning"><?php echo e($customerUsers); ?></div>
                    <div class="stat-label">Customers</div>
                </div>
                <div class="stat-icon stat-warning">
                    <i class="bi bi-person-badge"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="quick-actions">
    <h3 class="section-title">Quick Actions</h3>
    <div class="row g-3">
        <div class="col-xl-3 col-md-6">
            <a href="<?php echo e(route('admin.users.create')); ?>" class="action-btn">
                <i class="bi bi-person-plus"></i>
                <span>Create New User</span>
            </a>
        </div>

        <div class="col-xl-3 col-md-6">
            <a href="<?php echo e(route('admin.users.index')); ?>" class="action-btn">
                <i class="bi bi-people"></i>
                <span>Manage Users</span>
            </a>
        </div>

        <div class="col-xl-3 col-md-6">
            <a href="#" class="action-btn">
                <i class="bi bi-graph-up"></i>
                <span>View Reports</span>
            </a>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modern-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\NEW_ONE-main\resources\views/admin/modern-dashboard.blade.php ENDPATH**/ ?>