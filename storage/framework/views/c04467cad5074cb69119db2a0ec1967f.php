

<?php $__env->startSection('title', 'Edit Postman - ' . $postman->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-6">
            <div class="d-flex align-items-center mb-4">
                <a href="<?php echo e(route('pm.postmen.index')); ?>" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div class="flex-grow-1">
                    <h1 class="h2 mb-1">
                        <i class="bi bi-pencil me-2"></i>Edit Postman
                    </h1>
                    <p class="text-muted mb-0">
                        Update information for <?php echo e($postman->name); ?>

                    </p>
                </div>
                <a href="<?php echo e(route('pm.postmen.show', $postman->id)); ?>" class="btn btn-outline-info">
                    <i class="bi bi-eye me-1"></i>View
                </a>
            </div>

            <!-- Error Messages -->
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i><?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <h6><i class="bi bi-exclamation-triangle me-2"></i>Please fix the following errors:</h6>
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-person-badge me-2"></i>Postman Information
                    </h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('pm.postmen.update', $postman->id)); ?>" method="POST" novalidate>
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="name" 
                                       name="name" 
                                       value="<?php echo e(old('name', $postman->name)); ?>" 
                                       placeholder="Enter full name" 
                                       required>
                                <?php $__errorArgs = ['name'];
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

                            <div class="col-md-6">
                                <label for="nic" class="form-label">NIC Number <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['nic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="nic" 
                                       name="nic" 
                                       value="<?php echo e(old('nic', $postman->nic)); ?>" 
                                       placeholder="1234567890" 
                                       maxlength="10" 
                                       required>
                                <?php $__errorArgs = ['nic'];
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

                            <div class="col-md-6">
                                <label for="mobile" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                <input type="tel" 
                                       class="form-control <?php $__errorArgs = ['mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="mobile" 
                                       name="mobile" 
                                       value="<?php echo e(old('mobile', $postman->mobile)); ?>" 
                                       placeholder="0771234567" 
                                       required>
                                <?php $__errorArgs = ['mobile'];
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

                            <div class="col-md-6">
                                <label for="paysheet_id" class="form-label">Paysheet ID</label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['paysheet_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="paysheet_id" 
                                       name="paysheet_id" 
                                       value="<?php echo e(old('paysheet_id', $postman->paysheet_id)); ?>" 
                                       placeholder="Optional paysheet ID">
                                <?php $__errorArgs = ['paysheet_id'];
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

                            <div class="col-md-6">
                                <label for="postman_type" class="form-label">Postman Type <span class="text-danger">*</span></label>
                                <select class="form-select <?php $__errorArgs = ['postman_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="postman_type" 
                                        name="postman_type" 
                                        required>
                                    <option value="">Select postman type</option>
                                    <option value="permanent" <?php echo e(old('postman_type', $postman->postman_type) === 'permanent' ? 'selected' : ''); ?>>
                                        Permanent
                                    </option>
                                    <option value="temporary" <?php echo e(old('postman_type', $postman->postman_type) === 'temporary' ? 'selected' : ''); ?>>
                                        Temporary
                                    </option>
                                    <option value="substitute" <?php echo e(old('postman_type', $postman->postman_type) === 'substitute' ? 'selected' : ''); ?>>
                                        Substitute
                                    </option>
                                </select>
                                <?php $__errorArgs = ['postman_type'];
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

                            <div class="col-md-6">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="status" 
                                        name="status" 
                                        required>
                                    <option value="">Select status</option>
                                    <option value="active" <?php echo e(old('status', $postman->status) === 'active' ? 'selected' : ''); ?>>
                                        Active
                                    </option>
                                    <option value="inactive" <?php echo e(old('status', $postman->status) === 'inactive' ? 'selected' : ''); ?>>
                                        Inactive
                                    </option>
                                </select>
                                <?php $__errorArgs = ['status'];
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
                        </div>

                        <div class="alert alert-info mt-4">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Note:</strong> This postman is assigned to 
                            <strong><?php echo e($postman->location->name ?? 'Unknown Location'); ?></strong>.
                            <br><small class="text-muted">
                                Created by <?php echo e($postman->creator->name ?? 'Unknown'); ?> on 
                                <?php echo e($postman->created_at->format('F d, Y \a\t h:i A')); ?>

                                <?php if($postman->updated_by && $postman->updated_at != $postman->created_at): ?>
                                    <br>Last updated by <?php echo e($postman->updater->name ?? 'Unknown'); ?> on 
                                    <?php echo e($postman->updated_at->format('F d, Y \a\t h:i A')); ?>

                                <?php endif; ?>
                            </small>
                        </div>

                        <div class="d-flex gap-2 justify-content-end mt-4">
                            <a href="<?php echo e(route('pm.postmen.index')); ?>" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>Update Postman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Format NIC input
        const nicInput = document.getElementById('nic');
        nicInput.addEventListener('input', function(e) {
            // Remove non-alphanumeric characters
            e.target.value = e.target.value.replace(/[^a-zA-Z0-9]/g, '').toUpperCase();
        });

        // Format mobile input
        const mobileInput = document.getElementById('mobile');
        mobileInput.addEventListener('input', function(e) {
            // Remove non-numeric characters
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        });

        // Form validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const nic = document.getElementById('nic').value;
            const mobile = document.getElementById('mobile').value;

            // Validate NIC length
            if (nic.length !== 10) {
                e.preventDefault();
                alert('NIC must be exactly 10 characters long.');
                document.getElementById('nic').focus();
                return false;
            }

            // Validate mobile number
            if (mobile.length < 9 || mobile.length > 15) {
                e.preventDefault();
                alert('Mobile number should be between 9 and 15 digits.');
                document.getElementById('mobile').focus();
                return false;
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .form-label {
        font-weight: 500;
    }
    
    .text-danger {
        font-size: 0.875em;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.modern-pm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\NEW_ONE-main\resources\views/pm/postmen/edit.blade.php ENDPATH**/ ?>