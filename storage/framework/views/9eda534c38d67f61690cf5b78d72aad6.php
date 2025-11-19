<?php $__env->startSection('title', 'PM Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">Welcome back, <?php echo e(auth('pm')->user()->name); ?>!</h2>
                <p class="text-muted mb-0">Here's what's happening in your post office today.</p>
            </div>
            <div class="text-muted">
                <i class="bi bi-calendar3"></i> <?php echo e(now()->format('M d, Y')); ?>

            </div>
        </div>
    </div>
</div>

<!-- Location Info Card -->
<?php if(auth('pm')->user()->location): ?>
<div class="location-card mb-4">
    <div class="d-flex align-items-center">
        <i class="bi bi-geo-alt-fill fs-3 me-3"></i>
        <div>
            <h5 class="mb-1"><?php echo e(auth('pm')->user()->location->name); ?></h5>
            <p class="mb-0 opacity-75"><?php echo e(auth('pm')->user()->location->code); ?> - <?php echo e(auth('pm')->user()->location->city); ?></p>
            <?php if(auth('pm')->user()->location->phone): ?>
                <small class="opacity-75">📞 <?php echo e(auth('pm')->user()->location->phone); ?></small>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Statistics Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-number stat-primary"><?php echo e($customerUsers); ?></div>
                    <div class="stat-label">Total Customers</div>
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
                    <div class="stat-number stat-success"><?php echo e($activeCustomers); ?></div>
                    <div class="stat-label">Active Customers</div>
                </div>
                <div class="stat-icon stat-success">
                    <i class="bi bi-person-check"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-number stat-info"><?php echo e($externalCustomers); ?></div>
                    <div class="stat-label">External Customers</div>
                </div>
                <div class="stat-icon stat-info">
                    <i class="bi bi-globe"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-number stat-warning"><?php echo e($pendingItemsCount ?? 0); ?></div>
                    <div class="stat-label">Pending Items</div>
                </div>
                <div class="stat-icon stat-warning">
                    <i class="bi bi-clock"></i>
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
            <a href="<?php echo e(route('pm.customers.index')); ?>" class="action-btn">
                <i class="bi bi-people"></i>
                <span>Manage Customers</span>
            </a>
        </div>

        <div class="col-xl-3 col-md-6">
            <a href="<?php echo e(route('pm.single-item.index')); ?>" class="action-btn">
                <i class="bi bi-box-seam"></i>
                <span>Add Single Item</span>
            </a>
        </div>

        <div class="col-xl-3 col-md-6">
            <a href="<?php echo e(route('pm.item-management.index')); ?>" class="action-btn">
                <i class="bi bi-search"></i>
                <span>Item Management</span>
            </a>
        </div>
    </div>
</div>

<!-- Additional Quick Actions Row -->
<div class="row g-3 mt-2">
    <div class="col-xl-3 col-md-6">
        <a href="<?php echo e(route('pm.customer-uploads')); ?>" class="action-btn">
            <i class="bi bi-inbox"></i>
            <span>Customer Uploads</span>
            <?php if($pendingItemsCount > 0): ?>
                <div class="notification-badge mt-2"><?php echo e($pendingItemsCount); ?> pending</div>
            <?php endif; ?>
        </a>
    </div>

    <div class="col-xl-3 col-md-6">
        <a href="#" class="action-btn">
            <i class="bi bi-graph-up"></i>
            <span>View Reports</span>
        </a>
    </div>

    <div class="col-xl-3 col-md-6">
        <a href="#" class="action-btn">
            <i class="bi bi-gear"></i>
            <span>Settings</span>
        </a>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modern-pm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\NEW_ONE-main\resources\views/pm/modern-dashboard.blade.php ENDPATH**/ ?>