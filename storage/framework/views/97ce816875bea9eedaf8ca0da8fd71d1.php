<?php $__env->startSection('title', 'Edit Dispatch - ' . $dispatch->manifest_id); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit text-primary"></i>
            Edit Dispatch: <?php echo e($dispatch->manifest_id); ?>

        </h1>
        <div>
            <a href="<?php echo e(route('pm.dispatch.show', $dispatch->id)); ?>" class="btn btn-sm btn-info shadow-sm mr-2">
                <i class="fas fa-eye fa-sm text-white-50"></i> View Dispatch
            </a>
            <a href="<?php echo e(route('pm.dispatch.index')); ?>" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Dispatches
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</h6>
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Edit Form -->
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-shipping-fast"></i> Edit Dispatch Information
                    </h6>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('pm.dispatch.update', $dispatch->id)); ?>" method="POST" id="editDispatchForm">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="destination_office" class="form-label">
                                        <i class="fas fa-map-marker-alt text-primary"></i>
                                        Destination Office <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control <?php $__errorArgs = ['destination_office'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="destination_office"
                                            name="destination_office"
                                            required>
                                        <option value="">Select Delivery Office</option>
                                        <?php $__currentLoopData = $deliveryOffices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $office): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($office->id); ?>"
                                                    <?php echo e((old('destination_office', $dispatch->destination_office) == $office->id) ? 'selected' : ''); ?>>
                                                <?php echo e($office->name); ?> - <?php echo e($office->location_code ?? $office->id); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['destination_office'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="form-text text-muted">
                                        Select the office where this postal bag will be delivered
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="necklabel" class="form-label">
                                        <i class="fas fa-tag text-primary"></i>
                                        Neck Label <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control <?php $__errorArgs = ['necklabel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="necklabel"
                                           name="necklabel"
                                           value="<?php echo e(old('necklabel', $dispatch->necklabel)); ?>"
                                           placeholder="Enter neck label identifier"
                                           maxlength="255"
                                           required>
                                    <?php $__errorArgs = ['necklabel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="form-text text-muted">
                                        Unique identifier for this postal bag dispatch
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Current Information -->
                        <div class="alert alert-info" role="alert">
                            <h6><i class="fas fa-info-circle"></i> Current Information</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Manifest ID:</strong> <?php echo e($dispatch->manifest_id); ?></p>
                                    <p class="mb-1"><strong>Created:</strong> <?php echo e($dispatch->created_at->format('d/m/Y H:i')); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Items Count:</strong> <?php echo e($dispatch->dispatchAssociates->count()); ?> items</p>
                                    <p class="mb-1"><strong>Total Value:</strong> LKR <?php echo e(number_format($dispatch->dispatchAssociates->sum('item.amount'), 2)); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Warning Alert -->
                        <?php if($dispatch->dispatchAssociates->count() > 0): ?>
                        <div class="alert alert-warning" role="alert">
                            <h6><i class="fas fa-exclamation-triangle"></i> Warning</h6>
                            <p class="mb-0">
                                This dispatch already contains <?php echo e($dispatch->dispatchAssociates->count()); ?> items.
                                Changing the destination office may require updating the manifest and
                                notifying the receiving office.
                            </p>
                        </div>
                        <?php endif; ?>

                        <!-- Submit Buttons -->
                        <div class="form-group text-right">
                            <a href="<?php echo e(route('pm.dispatch.show', $dispatch->id)); ?>" class="btn btn-secondary mr-2">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary" id="updateBtn">
                                <i class="fas fa-save"></i> Update Dispatch
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Related Actions
                            </div>
                            <div class="text-gray-900">
                                <strong>After updating this dispatch:</strong>
                                <br>• Items will remain associated with this dispatch
                                <br>• Manifest will reflect the updated information
                                <br>• You can continue adding or removing items
                                <br>• Print a new manifest with updated details
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-info-circle fa-2x text-info"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="<?php echo e(route('pm.dispatch.add-items', $dispatch->id)); ?>" class="btn btn-sm btn-success mr-2">
                            <i class="fas fa-plus"></i> Add Items
                        </a>
                        <a href="<?php echo e(route('pm.dispatch.manifest', $dispatch->id)); ?>" class="btn btn-sm btn-info mr-2">
                            <i class="fas fa-file-alt"></i> View Manifest
                        </a>
                        <a href="<?php echo e(route('pm.dispatch.print-manifest', $dispatch->id)); ?>" class="btn btn-sm btn-secondary" target="_blank">
                            <i class="fas fa-print"></i> Print Manifest
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    $(document).ready(function() {
        // Form validation
        $('#editDispatchForm').on('submit', function() {
            $('#updateBtn').prop('disabled', true)
                          .html('<i class="fas fa-spinner fa-spin"></i> Updating...');
        });

        // Enhanced select styling
        $('#destination_office').select2({
            placeholder: "Search and select delivery office...",
            allowClear: true,
            width: '100%'
        });

        // Auto-suggest neck label update based on new destination
        $('#destination_office').on('change', function() {
            const currentLabel = $('#necklabel').val();
            const newOffice = $(this).find('option:selected').text().split(' - ')[0];

            // Only suggest if user wants to update
            if (newOffice && confirm('Would you like to update the neck label to reflect the new destination?')) {
                const date = new Date();
                const dateStr = date.getFullYear() +
                              String(date.getMonth() + 1).padStart(2, '0') +
                              String(date.getDate()).padStart(2, '0');
                const timeStr = String(date.getHours()).padStart(2, '0') +
                              String(date.getMinutes()).padStart(2, '0');

                const suggestedLabel = newOffice.substring(0, 3).toUpperCase() + '-' + dateStr + '-' + timeStr;
                $('#necklabel').val(suggestedLabel);
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .form-label {
        font-weight: 600;
        margin-bottom: 8px;
    }

    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .alert-info {
        background-color: #e7f3ff;
        border-color: #b3d9ff;
        color: #0056b3;
    }

    .alert-warning {
        background-color: #fff8e1;
        border-color: #ffd54f;
        color: #bf8f00;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    }

    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }

    .text-xs {
        font-size: 0.7rem;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modern-pm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\NEW_ONE-main\resources\views/pm/dispatch/edit.blade.php ENDPATH**/ ?>