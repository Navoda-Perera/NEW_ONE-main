<?php $__env->startSection('title', 'Postal Bag Dispatch Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-shipping-fast text-primary"></i>
            Postal Bag Dispatch Management
        </h1>
        <div class="d-flex">
            <a href="<?php echo e(route('pm.dispatch.lookup-by-barcode')); ?>" class="btn btn-sm btn-info shadow-sm mr-2">
                <i class="fas fa-search fa-sm text-white-50"></i> Get Necklabel
            </a>
            <a href="<?php echo e(route('pm.dispatch.change-location')); ?>" class="btn btn-sm btn-warning shadow-sm mr-2">
                <i class="fas fa-exchange-alt fa-sm text-white-50"></i> Change Location
            </a>
            <a href="<?php echo e(route('pm.dispatch.create')); ?>" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Create New Dispatch
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> <?php echo e(session('error')); ?>

            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Dispatches Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list"></i> All Dispatches
            </h6>
        </div>
        <div class="card-body">
            <?php if($dispatches->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>Manifest ID</th>
                                <th>Neck Label</th>
                                <th>Destination Office</th>
                                <th>Created By</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $dispatches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dispatch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php if($dispatch->manifest_id && trim($dispatch->manifest_id) !== ''): ?>
                                            <span class="badge bg-info text-white" style="font-size: 11px; font-weight: bold; display: inline-block; min-width: 120px;"><?php echo e(trim($dispatch->manifest_id)); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-danger text-white">Missing ID</span>
                                            <script>console.log('Missing manifest_id for dispatch:', <?php echo e($dispatch->id); ?>);</script>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($dispatch->necklabel); ?></td>
                                    <td><?php echo e($dispatch->destinationOffice->name ?? 'N/A'); ?></td>
                                    <td><?php echo e($dispatch->creator->name ?? 'N/A'); ?></td>
                                    <td><?php echo e($dispatch->created_at->format('Y-m-d H:i')); ?></td>
                                    <td>
                                        <div class="btn-group-vertical btn-group-sm" role="group">
                                            <a href="<?php echo e(route('pm.dispatch.show', $dispatch->id)); ?>"
                                               class="btn btn-sm btn-outline-info mb-1"
                                               title="View Details">
                                                <i class="fas fa-eye"></i> View
                                            </a>

                                            <a href="<?php echo e(route('pm.dispatch.add-items', $dispatch->id)); ?>"
                                               class="btn btn-sm btn-outline-success mb-1"
                                               title="Add Items">
                                                <i class="fas fa-plus"></i> Add Items
                                            </a>

                                            <a href="<?php echo e(route('pm.dispatch.manifest', $dispatch->id)); ?>"
                                               class="btn btn-sm btn-outline-primary mb-1"
                                               title="View Manifest">
                                                <i class="fas fa-file-alt"></i> Manifest
                                            </a>

                                            <a href="<?php echo e(route('pm.dispatch.print-manifest', $dispatch->id)); ?>"
                                               class="btn btn-sm btn-outline-secondary mb-1"
                                               title="Print Manifest" target="_blank">
                                                <i class="fas fa-print"></i> Print
                                            </a>
                                        </div>

                                        <!-- Removed Delete Modal -->
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    <?php echo e($dispatches->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-shipping-fast fa-3x text-gray-300"></i>
                    <h5 class="mt-3 text-gray-600">No dispatches found</h5>
                    <p class="text-gray-500">Create your first postal bag dispatch to get started.</p>
                    <a href="<?php echo e(route('pm.dispatch.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create New Dispatch
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .btn-group .btn {
        margin-right: 2px;
    }

    .table th {
        background-color: #f8f9fc;
        border-top: none;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge {
        font-size: 0.75rem;
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modern-pm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\NEW_ONE-main\resources\views/pm/dispatch/index.blade.php ENDPATH**/ ?>