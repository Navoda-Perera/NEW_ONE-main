<?php $__env->startSection('title', 'Dispatch Details - ' . $dispatch->manifest_id); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-eye text-primary"></i>
            Dispatch Details: <?php echo e($dispatch->manifest_id); ?>

        </h1>
        <div>
            <a href="<?php echo e(route('pm.dispatch.add-items', $dispatch->id)); ?>"
               class="btn btn-sm btn-success shadow-sm mr-2">
                <i class="fas fa-plus fa-sm text-white-50"></i> Add Items
            </a>
            <a href="<?php echo e(route('pm.dispatch.manifest', $dispatch->id)); ?>"
               class="btn btn-sm btn-info shadow-sm mr-2">
                <i class="fas fa-file-alt fa-sm text-white-50"></i> View Manifest
            </a>
            <a href="<?php echo e(route('pm.dispatch.print-manifest', $dispatch->id)); ?>"
               class="btn btn-sm btn-secondary shadow-sm mr-2" target="_blank">
                <i class="fas fa-print fa-sm text-white-50"></i> Print
            </a>
            <a href="<?php echo e(route('pm.dispatch.index')); ?>" class="btn btn-sm btn-light shadow-sm">
                <i class="fas fa-arrow-left fa-sm"></i> Back
            </a>
        </div>
    </div>

    <!-- Dispatch Information Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Manifest ID
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($dispatch->manifest_id); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-id-card fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Items Count
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($dispatch->dispatchAssociates->count()); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Value
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                LKR <?php echo e(number_format($dispatch->dispatchAssociates->sum('item.amount'), 2)); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Created Date
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($dispatch->created_at->format('d/m/Y')); ?>

                            </div>
                            <div class="text-xs text-gray-600">
                                <?php echo e($dispatch->created_at->format('H:i:s')); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dispatch Details -->
    <div class="row">
        <div class="col-lg-8">
            <!-- Items in Dispatch -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list"></i> Items in Dispatch
                    </h6>
                </div>
                <div class="card-body">
                    <?php if($dispatch->dispatchAssociates->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Barcode</th>
                                        <th>Receiver Name</th>
                                        <th>Address</th>
                                        <th>Amount</th>
                                        <th>Weight</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $dispatch->dispatchAssociates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $associate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($index + 1); ?></td>
                                            <td>
                                                <span class="badge badge-info"><?php echo e($associate->item->barcode); ?></span>
                                            </td>
                                            <td><?php echo e($associate->item->receiver_name); ?></td>
                                            <td><?php echo e(Str::limit($associate->item->receiver_address, 40)); ?></td>
                                            <td class="text-right">LKR <?php echo e(number_format($associate->item->amount, 2)); ?></td>
                                            <td class="text-center"><?php echo e($associate->item->weight ?? 'N/A'); ?>g</td>
                                            <td>
                                                <span class="badge badge-primary"><?php echo e(ucfirst($associate->status)); ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="4" class="text-right">Total:</th>
                                        <th class="text-right">
                                            LKR <?php echo e(number_format($dispatch->dispatchAssociates->sum('item.amount'), 2)); ?>

                                        </th>
                                        <th colspan="2" class="text-center">
                                            <?php echo e($dispatch->dispatchAssociates->count()); ?> items
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-3x text-gray-300"></i>
                            <h5 class="mt-3 text-gray-600">No items in this dispatch</h5>
                            <p class="text-gray-500">Add items to this dispatch using the barcode scanner.</p>
                            <a href="<?php echo e(route('pm.dispatch.add-items', $dispatch->id)); ?>" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Items
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Dispatch Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle"></i> Dispatch Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <strong>Manifest ID:</strong>
                        </div>
                        <div class="col-sm-6">
                            <span class="badge badge-primary"><?php echo e($dispatch->manifest_id); ?></span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <strong>Neck Label:</strong>
                        </div>
                        <div class="col-sm-6">
                            <?php echo e($dispatch->necklabel); ?>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <strong>From Office:</strong>
                        </div>
                        <div class="col-sm-6">
                            <?php echo e($dispatch->location->name); ?>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <strong>To Office:</strong>
                        </div>
                        <div class="col-sm-6">
                            <?php echo e($dispatch->destinationOffice->name); ?>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <strong>Created By:</strong>
                        </div>
                        <div class="col-sm-6">
                            <?php echo e($dispatch->creator->name); ?>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <strong>Created:</strong>
                        </div>
                        <div class="col-sm-6">
                            <?php echo e($dispatch->created_at->format('d/m/Y H:i')); ?>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <strong>Last Updated:</strong>
                        </div>
                        <div class="col-sm-6">
                            <?php echo e($dispatch->updated_at->format('d/m/Y H:i')); ?>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt"></i> Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?php echo e(route('pm.dispatch.add-items', $dispatch->id)); ?>"
                           class="btn btn-success btn-block mb-2">
                            <i class="fas fa-plus"></i> Add More Items
                        </a>

                        <a href="<?php echo e(route('pm.dispatch.manifest', $dispatch->id)); ?>"
                           class="btn btn-info btn-block mb-2">
                            <i class="fas fa-file-alt"></i> View Manifest
                        </a>

                        <a href="<?php echo e(route('pm.dispatch.print-manifest', $dispatch->id)); ?>"
                           class="btn btn-secondary btn-block mb-2" target="_blank">
                            <i class="fas fa-print"></i> Print Manifest
                        </a>

                        <a href="<?php echo e(route('pm.dispatch.edit', $dispatch->id)); ?>"
                           class="btn btn-warning btn-block mb-2">
                            <i class="fas fa-edit"></i> Edit Dispatch
                        </a>

                        <button type="button"
                                class="btn btn-danger btn-block"
                                data-toggle="modal"
                                data-target="#deleteModal">
                            <i class="fas fa-trash"></i> Delete Dispatch
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this dispatch?</p>
                    <div class="alert alert-warning">
                        <strong>Warning:</strong> This action will:
                        <ul class="mb-0 mt-2">
                            <li>Delete the dispatch record</li>
                            <li>Revert all items back to "accept" status</li>
                            <li>Remove all dispatch associations</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form action="<?php echo e(route('pm.dispatch.destroy', $dispatch->id)); ?>" method="POST" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger">Delete Dispatch</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }

    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }

    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }

    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }

    .badge {
        font-size: 0.75rem;
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .table th {
        background-color: #f8f9fc;
        border-top: none;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .btn-block {
        width: 100%;
        margin-bottom: 0.5rem;
    }

    .text-xs {
        font-size: 0.7rem;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modern-pm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\NEW_ONE-main\resources\views/pm/dispatch/show.blade.php ENDPATH**/ ?>