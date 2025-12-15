

<?php $__env->startSection('title', 'Change Dispatch Location - Step 3'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-exchange-alt text-warning"></i>
            Change Dispatch Location - Step 3
        </h1>
        <a href="<?php echo e(route('pm.dispatch.change-location')); ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Start Over
        </a>
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

    <!-- Step Progress -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="step-item completed">
                            <div class="step-number bg-success text-white">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="step-title">Enter Necklabel</div>
                        </div>
                        <div class="step-line completed"></div>
                        <div class="step-item completed">
                            <div class="step-number bg-success text-white">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="step-title">Enter Barcode</div>
                        </div>
                        <div class="step-line completed"></div>
                        <div class="step-item active">
                            <div class="step-number bg-primary text-white">3</div>
                            <div class="step-title">Select New Office</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dispatch Information -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-success">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-check-circle"></i> Barcode Verified Successfully
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Necklabel:</strong> <?php echo e($dispatch->necklabel); ?></p>
                            <p><strong>Manifest ID:</strong> <?php echo e($dispatch->manifest_id); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Current Destination:</strong> <span class="badge badge-danger"><?php echo e($dispatch->destinationOffice->name); ?></span></p>
                            <p><strong>Total Items:</strong> <?php echo e($dispatch->dispatchAssociates->count()); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Office Selection Form -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-building"></i> Select New Destination Office
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-exchange-alt fa-3x text-warning mb-3"></i>
                        <h5>Change Destination Office</h5>
                        <p class="text-muted">Select the new destination office for this dispatch. All items will be redirected to the selected office.</p>
                    </div>

                    <form method="POST" action="<?php echo e(route('pm.dispatch.update-location')); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <input type="hidden" name="dispatch_id" value="<?php echo e($dispatch->id); ?>">
                        
                        <div class="form-group">
                            <label for="new_destination_office" class="form-label font-weight-bold">
                                <i class="fas fa-building"></i> New Destination Office
                            </label>
                            <select name="new_destination_office" 
                                    id="new_destination_office" 
                                    class="form-control form-control-lg <?php $__errorArgs = ['new_destination_office'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    required>
                                <option value="">Select new destination office...</option>
                                <?php $__currentLoopData = $deliveryOffices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $office): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($office->id); ?>" 
                                            <?php if($office->id == $dispatch->destination_office): ?> disabled class="text-muted" <?php endif; ?>
                                            <?php echo e(old('new_destination_office') == $office->id ? 'selected' : ''); ?>>
                                        <?php echo e($office->name); ?>

                                        <?php if($office->id == $dispatch->destination_office): ?> (Current Destination) <?php endif; ?>
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['new_destination_office'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Confirmation Section -->
                        <div class="alert alert-warning border-warning">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle fa-2x text-warning mr-3"></i>
                                <div>
                                    <h6 class="alert-heading mb-1">Confirmation Required</h6>
                                    <p class="mb-0">Are you sure you want to change the destination office for dispatch <strong><?php echo e($dispatch->necklabel); ?></strong>? This action will affect all <?php echo e($dispatch->dispatchAssociates->count()); ?> items in this dispatch and cannot be undone.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-warning btn-lg" onclick="return confirm('Are you sure you want to change the dispatch destination office? This action cannot be undone.')">
                                <i class="fas fa-exchange-alt"></i> Update Dispatch Location
                            </button>
                            <a href="<?php echo e(route('pm.dispatch.index')); ?>" class="btn btn-secondary btn-lg ml-2">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Information -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-10">
            <div class="card border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-info-circle"></i> Change Summary
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-danger">Current Details:</h6>
                            <ul class="list-unstyled mb-3">
                                <li><i class="fas fa-tag text-muted"></i> <strong>Necklabel:</strong> <?php echo e($dispatch->necklabel); ?></li>
                                <li><i class="fas fa-file-alt text-muted"></i> <strong>Manifest ID:</strong> <?php echo e($dispatch->manifest_id); ?></li>
                                <li><i class="fas fa-building text-muted"></i> <strong>Current Destination:</strong> <?php echo e($dispatch->destinationOffice->name); ?></li>
                                <li><i class="fas fa-boxes text-muted"></i> <strong>Items Count:</strong> <?php echo e($dispatch->dispatchAssociates->count()); ?></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-success">What will happen:</h6>
                            <ul class="list-unstyled mb-3">
                                <li><i class="fas fa-check text-success"></i> Destination office will be updated</li>
                                <li><i class="fas fa-check text-success"></i> All items will be redirected to new office</li>
                                <li><i class="fas fa-check text-success"></i> Manifest information remains the same</li>
                                <li><i class="fas fa-check text-success"></i> Change will be logged for audit</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.step-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex: 1;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-bottom: 8px;
}

.step-title {
    font-size: 14px;
    font-weight: 500;
    text-align: center;
}

.step-line {
    height: 2px;
    background-color: #dee2e6;
    flex: 1;
    margin: 20px 15px 0 15px;
}

.step-line.completed {
    background-color: #28a745;
}

.step-item.active .step-number {
    background-color: #007bff !important;
}

.step-item.completed .step-number {
    background-color: #28a745 !important;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.modern-pm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\NEW_ONE-main\resources\views/pm/dispatch/change-location-step3.blade.php ENDPATH**/ ?>