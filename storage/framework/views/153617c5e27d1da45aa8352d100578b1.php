<?php $__env->startSection('title', 'My Items'); ?>

<?php $__env->startSection('nav-links'); ?>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo e(route('customer.dashboard')); ?>">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo e(route('customer.services.index')); ?>">
            <i class="bi bi-box-seam"></i> Postal Services
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo e(route('customer.profile')); ?>">
            <i class="bi bi-person"></i> Profile
        </a>
    </li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <a href="<?php echo e(route('customer.services.index')); ?>" class="btn btn-outline-secondary me-3">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h2 class="fw-bold text-dark mb-0">My Items</h2>
                </div>
                <div>
                    <a href="<?php echo e(route('customer.services.add-single-item')); ?>" class="btn btn-success">
                        <i class="bi bi-plus-circle me-2"></i>Add New Item
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Buttons -->
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="btn-group" role="group">
                <a href="<?php echo e(route('customer.services.items')); ?>"
                   class="btn <?php echo e(!request('status') ? 'btn-primary' : 'btn-outline-primary'); ?>">
                    All Items
                    <span class="badge bg-light text-dark ms-1"><?php echo e($statusCounts['total']); ?></span>
                </a>
                <a href="<?php echo e(route('customer.services.items', ['status' => 'pending'])); ?>"
                   class="btn <?php echo e(request('status') === 'pending' ? 'btn-warning' : 'btn-outline-warning'); ?>">
                    Pending
                    <span class="badge bg-light text-dark ms-1"><?php echo e($statusCounts['pending']); ?></span>
                </a>
                <a href="<?php echo e(route('customer.services.items', ['status' => 'accept'])); ?>"
                   class="btn <?php echo e(request('status') === 'accept' ? 'btn-success' : 'btn-outline-success'); ?>">
                    Accepted
                    <span class="badge bg-light text-dark ms-1"><?php echo e($statusCounts['accepted']); ?></span>
                </a>
                <a href="<?php echo e(route('customer.services.items', ['status' => 'reject'])); ?>"
                   class="btn <?php echo e(request('status') === 'reject' ? 'btn-danger' : 'btn-outline-danger'); ?>">
                    Rejected
                    <span class="badge bg-light text-dark ms-1"><?php echo e($statusCounts['rejected']); ?></span>
                </a>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?php if($uploads->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Upload ID</th>
                                        <th>Service Type</th>
                                        <th>Item Quantity</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $uploads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $upload): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <strong>#<?php echo e($upload->id); ?></strong>
                                            </td>
                                            <td>
                                                <?php
                                                    // Get service type from the first associate since all items in an upload have the same service type
                                                    $firstAssociate = $upload->associates->first();
                                                    $serviceType = $firstAssociate ? ($serviceTypeLabels[$firstAssociate->service_type] ?? $firstAssociate->service_type) : 'Not specified';
                                                ?>
                                                <?php if($firstAssociate && $firstAssociate->service_type): ?>
                                                    <span class="badge bg-info"><?php echo e($serviceType); ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Not specified</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary fs-6"><?php echo e($upload->total_items ?? $upload->associates_count); ?></span>
                                                <?php if($upload->total_items == 1): ?>
                                                    <br><small class="text-muted">Single Item</small>
                                                <?php else: ?>
                                                    <br><small class="text-muted">List Items</small>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($upload->created_at->format('M d, Y H:i')); ?></td>
                                            <td>
                                                <button class="btn btn-outline-primary btn-sm"
                                                        onclick="viewUploadDetails(<?php echo e($upload->id); ?>)"
                                                        title="View Items">
                                                    <i class="bi bi-eye"></i> View
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            <?php echo e($uploads->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1"></i>
                            <p class="mt-3">No uploads found.</p>
                            <a href="<?php echo e(route('customer.services.bulk-upload')); ?>" class="btn btn-success me-2">
                                <i class="bi bi-upload me-2"></i>Bulk Upload
                            </a>
                            <a href="<?php echo e(route('customer.services.add-single-item')); ?>" class="btn btn-outline-success">
                                <i class="bi bi-plus-circle me-2"></i>Add Single Item
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Item Details Modal -->
<div class="modal fade" id="itemDetailsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Item Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="itemDetailsContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function viewUploadDetails(uploadId) {
    // Redirect to a dedicated page to view upload details
    window.location.href = `/customer/services/view-upload/${uploadId}`;
}

function showItemDetails(itemId) {
    // For now, just show a placeholder
    const modal = new bootstrap.Modal(document.getElementById('itemDetailsModal'));
    document.getElementById('itemDetailsContent').innerHTML = '<p>Item details will be loaded here...</p>';
    modal.show();
}

function editItem(itemId) {
    // Redirect to edit form or show edit modal
    alert('Edit functionality will be implemented');
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\NEW_ONE-main\resources\views/customer/services/items.blade.php ENDPATH**/ ?>