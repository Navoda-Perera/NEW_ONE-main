<?php $__env->startSection('title', 'Item Manifest - ' . $dispatch->manifest_id); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-file-alt text-primary"></i>
            Item Manifest: <?php echo e($dispatch->manifest_id); ?>

        </h1>
        <div>
            <a href="<?php echo e(route('pm.dispatch.print-manifest', $dispatch->id)); ?>" 
               class="btn btn-sm btn-success shadow-sm mr-2" target="_blank">
                <i class="fas fa-print fa-sm text-white-50"></i> Print Manifest
            </a>
            <a href="<?php echo e(route('pm.dispatch.add-items', $dispatch->id)); ?>" 
               class="btn btn-sm btn-info shadow-sm mr-2">
                <i class="fas fa-plus fa-sm text-white-50"></i> Add More Items
            </a>
            <a href="<?php echo e(route('pm.dispatch.index')); ?>" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Dispatches
            </a>
        </div>
    </div>

    <!-- Manifest Document -->
    <div class="card shadow mb-4">
        <div class="card-body p-5">
            <!-- Header of the manifest matching the provided image -->
            <div class="text-center mb-5">
                <h2 class="font-weight-bold text-dark mb-3">ITEM MANIFEST</h2>
                
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-left"><strong>User:</strong> <?php echo e($dispatch->creator->name); ?></td>
                                <td class="text-right"><strong>List Serial No:</strong> <?php echo e($dispatch->manifest_id); ?></td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>Office:</strong> <?php echo e($dispatch->location->name); ?></td>
                                <td class="text-right"><strong>Neck Label:</strong> <?php echo e($dispatch->necklabel); ?></td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>Date:</strong> <?php echo e($dispatch->created_at->format('Y-m-d H:i:s')); ?></td>
                                <td class="text-right"><strong>Number of Item:</strong> <?php echo e($dispatchedItems->count()); ?></td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>To Office:</strong> <?php echo e($dispatch->destinationOffice->name); ?></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 25%;">Identifier</th>
                            <th style="width: 70%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $dispatchedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $dispatchItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td><?php echo e($dispatchItem->item->barcode); ?></td>
                                <td></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    No items added to this dispatch yet.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Print Button at bottom -->
            <div class="text-center mt-5">
                <button type="button" 
                        class="btn btn-primary btn-lg" 
                        onclick="window.open('<?php echo e(route('pm.dispatch.print-manifest', $dispatch->id)); ?>', '_blank')">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>

            <!-- Summary Information -->
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="card border-left-primary">
                        <div class="card-body">
                            <h6 class="font-weight-bold text-primary">Dispatch Summary</h6>
                            <ul class="list-unstyled mb-0">
                                <li><strong>Total Items:</strong> <?php echo e($dispatchedItems->count()); ?></li>
                                <li><strong>Total Amount:</strong> LKR <?php echo e(number_format($dispatchedItems->sum('item.amount'), 2)); ?></li>
                                <li><strong>Created By:</strong> <?php echo e($dispatch->creator->name); ?></li>
                                <li><strong>Created Date:</strong> <?php echo e($dispatch->created_at->format('d/m/Y H:i')); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card border-left-success">
                        <div class="card-body">
                            <h6 class="font-weight-bold text-success">Delivery Information</h6>
                            <ul class="list-unstyled mb-0">
                                <li><strong>From Office:</strong> <?php echo e($dispatch->location->name); ?></li>
                                <li><strong>To Office:</strong> <?php echo e($dispatch->destinationOffice->name); ?></li>
                                <li><strong>Neck Label:</strong> <?php echo e($dispatch->necklabel); ?></li>
                                <li><strong>Manifest ID:</strong> <?php echo e($dispatch->manifest_id); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Item Details Table (Additional Information) -->
    <?php if($dispatchedItems->count() > 0): ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list-alt"></i> Detailed Item Information
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Barcode</th>
                            <th>Receiver Name</th>
                            <th>Receiver Address</th>
                            <th>Amount (LKR)</th>
                            <th>Weight (g)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $dispatchedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $dispatchItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td>
                                    <span class="badge badge-info"><?php echo e($dispatchItem->item->barcode); ?></span>
                                </td>
                                <td><?php echo e($dispatchItem->item->receiver_name); ?></td>
                                <td><?php echo e($dispatchItem->item->receiver_address); ?></td>
                                <td class="text-right"><?php echo e(number_format($dispatchItem->item->amount, 2)); ?></td>
                                <td class="text-center"><?php echo e($dispatchItem->item->weight ?? 'N/A'); ?></td>
                                <td>
                                    <span class="badge badge-primary"><?php echo e(ucfirst($dispatchItem->status)); ?></span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="4" class="text-right">Total:</th>
                            <th class="text-right">LKR <?php echo e(number_format($dispatchedItems->sum('item.amount'), 2)); ?></th>
                            <th colspan="2"><?php echo e($dispatchedItems->count()); ?> items</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .manifest-document {
        background-color: white;
        min-height: 800px;
    }
    
    .manifest-document h2 {
        font-size: 2rem;
        letter-spacing: 2px;
    }
    
    .manifest-document table {
        font-size: 0.95rem;
    }
    
    .manifest-document .table-bordered td,
    .manifest-document .table-bordered th {
        border: 2px solid #000;
    }
    
    .manifest-document .table-borderless td {
        border: none;
        padding: 0.3rem;
    }
    
    @media print {
        .manifest-document {
            box-shadow: none !important;
        }
        
        .btn, .card-header, .navbar, .sidebar {
            display: none !important;
        }
    }
    
    .badge {
        font-size: 0.75rem;
    }
    
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    $(document).ready(function() {
        // Print functionality
        $('.print-manifest').on('click', function() {
            window.print();
        });
        
        // Auto-refresh item count if needed
        setInterval(function() {
            // Optional: Auto-refresh functionality
        }, 30000);
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.modern-pm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\NEW_ONE-main\resources\views/pm/dispatch/manifest.blade.php ENDPATH**/ ?>