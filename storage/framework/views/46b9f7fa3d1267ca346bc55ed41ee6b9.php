

<?php $__env->startSection('title', 'Dispatch Lookup Results'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-search text-info"></i>
            Dispatch Lookup Results
        </h1>
        <div class="d-flex">
            <a href="<?php echo e(route('pm.dispatch.lookup-by-barcode')); ?>" class="btn btn-sm btn-info shadow-sm mr-2">
                <i class="fas fa-search fa-sm text-white-50"></i> Search Again
            </a>
            <a href="<?php echo e(route('pm.dispatch.index')); ?>" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Dispatches
            </a>
        </div>
    </div>

    <!-- Success Message -->
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> Item found! Dispatch information displayed below.
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="row">
        <!-- Item Information -->
        <div class="col-md-6 mb-4">
            <div class="card shadow border-primary">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-box"></i> Item Information
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="font-weight-bold text-primary">Item ID:</td>
                            <td><?php echo e($item->id); ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-primary">Barcode:</td>
                            <td><code class="bg-light px-2 py-1 rounded"><?php echo e($item->barcode); ?></code></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-primary">Receiver Name:</td>
                            <td><?php echo e($item->receiver_name); ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-primary">Receiver Address:</td>
                            <td><?php echo e($item->receiver_address); ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-primary">Weight:</td>
                            <td><?php echo e(number_format($item->weight, 2)); ?> kg</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-primary">Amount:</td>
                            <td>LKR <?php echo e(number_format($item->amount, 2)); ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-primary">Status:</td>
                            <td>
                                <?php if($item->status == 'accept'): ?>
                                    <span class="badge badge-success"><?php echo e(ucfirst($item->status)); ?></span>
                                <?php elseif($item->status == 'dispatch'): ?>
                                    <span class="badge badge-warning"><?php echo e(ucfirst($item->status)); ?></span>
                                <?php elseif($item->status == 'delivered'): ?>
                                    <span class="badge badge-info"><?php echo e(ucfirst($item->status)); ?></span>
                                <?php else: ?>
                                    <span class="badge badge-secondary"><?php echo e(ucfirst($item->status)); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Dispatch Information -->
        <div class="col-md-6 mb-4">
            <div class="card shadow border-success">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-shipping-fast"></i> Dispatch Information
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="font-weight-bold text-success">Necklabel:</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <code class="bg-success text-white px-2 py-1 rounded mr-2"><?php echo e($dispatch->necklabel); ?></code>
                                    <i class="fas fa-tag text-success"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-success">Manifest ID:</td>
                            <td><code class="bg-light px-2 py-1 rounded"><?php echo e($dispatch->manifest_id); ?></code></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-success">Destination Office:</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-info px-3 py-2 mr-2"><?php echo e($dispatch->destinationOffice->name); ?></span>
                                    <i class="fas fa-building text-info"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-success">Dispatch Status:</td>
                            <td>
                                <?php if($dispatchAssociate->status == 'dispatch'): ?>
                                    <span class="badge badge-warning">Dispatched</span>
                                <?php elseif($dispatchAssociate->status == 'received'): ?>
                                    <span class="badge badge-info">Received</span>
                                <?php elseif($dispatchAssociate->status == 'delivered'): ?>
                                    <span class="badge badge-success">Delivered</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary"><?php echo e(ucfirst($dispatchAssociate->status)); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-success">Dispatched From:</td>
                            <td><?php echo e($dispatch->location->name); ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-success">Dispatch Date:</td>
                            <td><?php echo e($dispatch->created_at->format('M d, Y h:i A')); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Cards -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-cogs"></i> Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <a href="<?php echo e(route('pm.dispatch.show', $dispatch->id)); ?>" class="btn btn-outline-primary btn-lg d-block mb-2">
                                    <i class="fas fa-eye fa-2x mb-2"></i><br>
                                    View Full Dispatch
                                </a>
                                <small class="text-muted">See all items in this dispatch</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <a href="<?php echo e(route('pm.dispatch.manifest', $dispatch->id)); ?>" class="btn btn-outline-success btn-lg d-block mb-2">
                                    <i class="fas fa-file-alt fa-2x mb-2"></i><br>
                                    View Manifest
                                </a>
                                <small class="text-muted">See dispatch manifest</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <a href="<?php echo e(route('pm.dispatch.change-location')); ?>" class="btn btn-outline-warning btn-lg d-block mb-2">
                                    <i class="fas fa-exchange-alt fa-2x mb-2"></i><br>
                                    Change Location
                                </a>
                                <small class="text-muted">Change dispatch destination</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <a href="<?php echo e(route('pm.dispatch.lookup-by-barcode')); ?>" class="btn btn-outline-info btn-lg d-block mb-2">
                                    <i class="fas fa-search fa-2x mb-2"></i><br>
                                    Search Again
                                </a>
                                <small class="text-muted">Look up another item</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Information -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="alert alert-light border">
                <div class="row">
                    <div class="col-md-8">
                        <h6 class="text-dark"><i class="fas fa-info-circle text-info"></i> Summary</h6>
                        <p class="mb-0">
                            Item <strong><?php echo e($item->barcode); ?></strong> for receiver <strong><?php echo e($item->receiver_name); ?></strong> 
                            is part of dispatch <strong><?php echo e($dispatch->necklabel); ?></strong> heading to 
                            <strong><?php echo e($dispatch->destinationOffice->name); ?></strong> office.
                        </p>
                    </div>
                    <div class="col-md-4 text-right">
                        <small class="text-muted">
                            Last updated: <?php echo e($dispatch->updated_at->format('M d, Y h:i A')); ?>

                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.modern-pm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\NEW_ONE-main\resources\views/pm/dispatch/lookup-result.blade.php ENDPATH**/ ?>