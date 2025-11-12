<?php $__env->startSection('title', 'Customer Uploads'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Modern Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-info text-white p-4 rounded-top">
                <div class="row align-items-center">
                    <div class="col-12 text-center">
                        <h2 class="mb-1">
                            <i class="bi bi-upload"></i>
                            Customer Uploads Management
                        </h2>
                        <p class="mb-0 opacity-75">View and manage customer uploads across all service types</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-header bg-gradient text-white p-4" style="background: linear-gradient(135deg, #17a2b8, #138496);">
                    <div class="row align-items-center">
                        <div class="col-12 text-center">
                            <h4 class="mb-0">
                                <i class="bi bi-funnel fs-3 me-2"></i>
                                Search & Filter
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Search Form -->
                    <form method="GET" action="<?php echo e(route('pm.customer-uploads')); ?>" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-9">
                                <label for="search" class="form-label fw-bold text-dark">
                                    <i class="bi bi-search"></i> Search Customer Uploads
                                </label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-info text-white">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" class="form-control" id="search" name="search"
                                           value="<?php echo e(request('search')); ?>"
                                           placeholder="Search by sender name, email, NIC, or upload ID..."
                                           autocomplete="off">
                                    <?php if(request('service_type')): ?>
                                        <input type="hidden" name="service_type" value="<?php echo e(request('service_type')); ?>">
                                    <?php endif; ?>
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-lightbulb"></i> Enter customer name, email, NIC number, or upload ID to search
                                </small>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-info btn-lg w-100 shadow">
                                    <i class="bi bi-search"></i> Search Uploads
                                </button>
                            </div>
                        </div>
                        <?php if(request('search') || request('service_type')): ?>
                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <a href="<?php echo e(route('pm.customer-uploads')); ?>" class="btn btn-outline-secondary btn-lg">
                                        <i class="bi bi-x-circle"></i> Clear All Filters
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </form>

                    <!-- Service Type Filters -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-dark mb-3">
                                <i class="bi bi-tags"></i> Filter by Service Type
                            </h6>
                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                <a href="<?php echo e(route('pm.customer-uploads', ['search' => request('search')])); ?>"
                                   class="btn <?php echo e(!request('service_type') ? 'btn-primary' : 'btn-outline-primary'); ?> btn-lg shadow-sm">
                                    <i class="bi bi-list-ul"></i> All Service Types
                                </a>
                                <a href="<?php echo e(route('pm.customer-uploads', ['service_type' => 'slp_courier', 'search' => request('search')])); ?>"
                                   class="btn <?php echo e(request('service_type') === 'slp_courier' ? 'btn-success' : 'btn-outline-success'); ?> btn-lg shadow-sm">
                                    <i class="bi bi-truck"></i> SLP Courier
                                </a>
                                <a href="<?php echo e(route('pm.customer-uploads', ['service_type' => 'cod', 'search' => request('search')])); ?>"
                                   class="btn <?php echo e(request('service_type') === 'cod' ? 'btn-warning' : 'btn-outline-warning'); ?> btn-lg shadow-sm">
                                    <i class="bi bi-cash-coin"></i> COD
                                </a>
                                <a href="<?php echo e(route('pm.customer-uploads', ['service_type' => 'register_post', 'search' => request('search')])); ?>"
                                   class="btn <?php echo e(request('service_type') === 'register_post' ? 'btn-info' : 'btn-outline-info'); ?> btn-lg shadow-sm">
                                    <i class="bi bi-envelope-check"></i> Register Post
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Results Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-header bg-light border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-dark">
                            <i class="bi bi-list-check"></i> Customer Uploads
                        </h5>
                        <?php if($uploads->total() > 0): ?>
                            <span class="badge bg-info fs-6">
                                Showing <?php echo e($uploads->firstItem()); ?>-<?php echo e($uploads->lastItem()); ?> of <?php echo e($uploads->total()); ?> uploads
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-body p-0">
                    <?php if($uploads->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-bold text-dark py-3">
                                            <i class="bi bi-hash"></i> Upload ID
                                        </th>
                                        <th class="fw-bold text-dark py-3">
                                            <i class="bi bi-person-circle"></i> Customer Details
                                        </th>
                                        <th class="fw-bold text-dark py-3">
                                            <i class="bi bi-credit-card"></i> NIC
                                        </th>
                                        <th class="fw-bold text-dark py-3">
                                            <i class="bi bi-tag"></i> Service Type
                                        </th>
                                        <th class="fw-bold text-dark py-3">
                                            <i class="bi bi-box"></i> Items
                                        </th>
                                        <th class="fw-bold text-dark py-3">
                                            <i class="bi bi-calendar"></i> Created
                                        </th>
                                        <th class="fw-bold text-dark py-3 text-center">
                                            <i class="bi bi-gear"></i> Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $uploads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $upload): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="border-bottom">
                                            <td class="py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                        <i class="bi bi-upload"></i>
                                                    </div>
                                                    <div class="ms-3">
                                                        <strong class="text-primary">#<?php echo e($upload->id); ?></strong>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                        <?php echo e(strtoupper(substr($upload->user->name, 0, 1))); ?>

                                                    </div>
                                                    <div class="ms-3">
                                                        <strong class="text-dark"><?php echo e($upload->user->name); ?></strong>
                                                        <br><small class="text-muted">
                                                            <i class="bi bi-envelope"></i> <?php echo e($upload->user->email); ?>

                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <?php if($upload->user->nic): ?>
                                                    <code class="bg-light px-2 py-1 rounded"><?php echo e($upload->user->nic); ?></code>
                                                <?php else: ?>
                                                    <span class="text-muted">Not provided</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-3">
                                                <?php
                                                    $firstAssociate = $upload->associates->first();
                                                    $serviceType = $firstAssociate ? ($serviceTypeLabels[$firstAssociate->service_type] ?? $firstAssociate->service_type) : 'Not specified';
                                                ?>
                                                <?php if($firstAssociate && $firstAssociate->service_type): ?>
                                                    <?php switch($firstAssociate->service_type):
                                                        case ('slp_courier'): ?>
                                                            <span class="badge bg-success fs-6 px-3 py-2">
                                                                <i class="bi bi-truck"></i> <?php echo e($serviceType); ?>

                                                            </span>
                                                            <?php break; ?>
                                                        <?php case ('cod'): ?>
                                                            <span class="badge bg-warning fs-6 px-3 py-2">
                                                                <i class="bi bi-cash-coin"></i> <?php echo e($serviceType); ?>

                                                            </span>
                                                            <?php break; ?>
                                                        <?php case ('register_post'): ?>
                                                            <span class="badge bg-info fs-6 px-3 py-2">
                                                                <i class="bi bi-envelope-check"></i> <?php echo e($serviceType); ?>

                                                            </span>
                                                            <?php break; ?>
                                                        <?php default: ?>
                                                            <span class="badge bg-secondary fs-6 px-3 py-2">
                                                                <i class="bi bi-question"></i> <?php echo e($serviceType); ?>

                                                            </span>
                                                    <?php endswitch; ?>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary fs-6 px-3 py-2">
                                                        <i class="bi bi-question"></i> Not specified
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-3">
                                                <div class="d-flex flex-column">
                                                    <span class="badge bg-primary fs-6 mb-1">
                                                        <i class="bi bi-box"></i> <?php echo e($upload->total_items); ?> Total
                                                    </span>
                                                    <?php if($upload->pending_items > 0): ?>
                                                        <span class="badge bg-warning fs-6">
                                                            <i class="bi bi-clock"></i> <?php echo e($upload->pending_items); ?> Pending
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <div class="text-muted">
                                                    <i class="bi bi-calendar3"></i> <?php echo e($upload->created_at->format('M d, Y')); ?>

                                                    <br><small class="text-muted">
                                                        <i class="bi bi-clock"></i> <?php echo e($upload->created_at->format('H:i')); ?>

                                                    </small>
                                                </div>
                                            </td>
                                            <td class="py-3 text-center">
                                                <button class="btn btn-info btn-lg shadow-sm"
                                                        onclick="viewCustomerUploadDetails(<?php echo e($upload->id); ?>)"
                                                        title="View Upload Details">
                                                    <i class="bi bi-eye"></i> View Details
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Modern Pagination -->
                        <?php if($uploads->hasPages()): ?>
                            <div class="d-flex justify-content-center p-4 bg-light">
                                <?php echo e($uploads->appends(request()->query())->links()); ?>

                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <!-- Empty State -->
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                            </div>
                            <h4 class="text-muted mb-2">No Customer Uploads Found</h4>
                            <p class="text-muted">
                                <?php if(request('search') || request('service_type')): ?>
                                    No uploads match your search criteria. Try adjusting your filters.
                                <?php else: ?>
                                    No customer uploads have been submitted yet.
                                <?php endif; ?>
                            </p>
                            <?php if(request('search') || request('service_type')): ?>
                                <div class="mt-4">
                                    <a href="<?php echo e(route('pm.customer-uploads')); ?>" class="btn btn-primary btn-lg shadow">
                                        <i class="bi bi-arrow-clockwise"></i> Clear Filters & Show All
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function viewCustomerUploadDetails(uploadId) {
    // Redirect to view customer upload details
    window.location.href = `/pm/view-customer-upload/${uploadId}`;
}
</script>

<?php echo $__env->make('layouts.modern-pm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\NEW_ONE-main\resources\views/pm/customer-uploads.blade.php ENDPATH**/ ?>