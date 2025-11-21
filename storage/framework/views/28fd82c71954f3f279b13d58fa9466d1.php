<?php $__env->startSection('title', 'Edit Company'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="mb-2">
                    <a href="<?php echo e(route('pm.companies.show', $company)); ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>
                        Back to Company
                    </a>
                </div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-pencil me-2 text-warning"></i>
                    Edit Company
                </h2>
                <p class="text-muted mb-0">Update <?php echo e($company->name); ?> details</p>
            </div>
        </div>
    </div>
</div>

<!-- Error Messages -->
<?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>
        Please fix the following errors:
        <ul class="mb-0 mt-2">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-warning text-dark text-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-building-fill me-2"></i>
                    Company Information
                </h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="<?php echo e(route('pm.companies.update', $company)); ?>" id="editCompanyForm">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row">
                        <!-- Company Name -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label fw-bold">
                                <i class="bi bi-building me-1"></i>
                                Company Name *
                            </label>
                            <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="name" name="name" value="<?php echo e(old('name', $company->name)); ?>" required>
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

                        <!-- Telephone -->
                        <div class="col-md-6 mb-3">
                            <label for="telephone" class="form-label fw-bold">
                                <i class="bi bi-telephone me-1"></i>
                                Telephone *
                            </label>
                            <input type="tel" class="form-control <?php $__errorArgs = ['telephone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="telephone" name="telephone" value="<?php echo e(old('telephone', $company->telephone)); ?>" required>
                            <?php $__errorArgs = ['telephone'];
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

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-bold">
                                <i class="bi bi-envelope me-1"></i>
                                Email
                            </label>
                            <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="email" name="email" value="<?php echo e(old('email', $company->email)); ?>">
                            <?php $__errorArgs = ['email'];
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

                        <!-- Type -->
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label fw-bold">
                                <i class="bi bi-tag me-1"></i>
                                Type *
                            </label>
                            <select class="form-select <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="type" name="type" required>
                                <option value="">Select Type...</option>
                                <option value="cash" <?php echo e(old('type', $company->type) === 'cash' ? 'selected' : ''); ?>>
                                    Cash
                                </option>
                                <option value="credit" <?php echo e(old('type', $company->type) === 'credit' ? 'selected' : ''); ?>>
                                    Credit
                                </option>
                                <option value="franking" <?php echo e(old('type', $company->type) === 'franking' ? 'selected' : ''); ?>>
                                    Franking
                                </option>
                                <option value="prepaid" <?php echo e(old('type', $company->type) === 'prepaid' ? 'selected' : ''); ?>>
                                    Prepaid
                                </option>
                            </select>
                            <?php $__errorArgs = ['type'];
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

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label fw-bold">
                                <i class="bi bi-toggle-on me-1"></i>
                                Status *
                            </label>
                            <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="status" name="status" required>
                                <option value="">Select Status...</option>
                                <option value="ACTIVE" <?php echo e(old('status', $company->status) === 'ACTIVE' ? 'selected' : ''); ?>>
                                    Active
                                </option>
                                <option value="INACTIVE" <?php echo e(old('status', $company->status) === 'INACTIVE' ? 'selected' : ''); ?>>
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

                        <!-- Assign Post Office -->
                        <div class="col-md-6 mb-3">
                            <label for="assign_postoffice" class="form-label fw-bold">
                                <i class="bi bi-geo-alt me-1"></i>
                                Assign Post Office *
                            </label>
                            <select class="form-select <?php $__errorArgs = ['assign_postoffice'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="assign_postoffice" name="assign_postoffice" required>
                                <option value="">Select Post Office...</option>
                                <?php $__currentLoopData = $postoffices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $postoffice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($postoffice->id); ?>"
                                            <?php echo e(old('assign_postoffice', $company->assign_postoffice) == $postoffice->id ? 'selected' : ''); ?>>
                                        <?php echo e($postoffice->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['assign_postoffice'];
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

                        <!-- Address -->
                        <div class="col-12 mb-3">
                            <label for="address" class="form-label fw-bold">
                                <i class="bi bi-house me-1"></i>
                                Address *
                            </label>
                            <textarea class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      id="address" name="address" rows="3" required><?php echo e(old('address', $company->address)); ?></textarea>
                            <?php $__errorArgs = ['address'];
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

                        <!-- Current Balance Display - Only for Prepaid Companies -->
                        <?php if($company->type === 'prepaid'): ?>
                        <div class="col-12 mb-4">
                            <div class="alert alert-info d-flex align-items-center">
                                <i class="bi bi-wallet me-2"></i>
                                <div>
                                    <strong>Current Prepaid Balance:</strong> LKR <?php echo e(number_format($company->balance, 2)); ?>

                                    <br>
                                    <small class="text-muted">To modify balance, use the balance management section after saving changes.</small>
                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="col-12 mb-4">
                            <div class="alert alert-secondary d-flex align-items-center">
                                <i class="bi bi-info-circle me-2"></i>
                                <div>
                                    <strong><?php echo e(ucfirst($company->type)); ?> Company:</strong> No balance management required.
                                    <br>
                                    <small class="text-muted">
                                        <?php if($company->type === 'cash'): ?>
                                            This company pays cash for each service.
                                        <?php elseif($company->type === 'credit'): ?>
                                            This company uses credit facility.
                                        <?php elseif($company->type === 'franking'): ?>
                                            This company uses franking machine services.
                                        <?php endif; ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Form Actions -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="<?php echo e(route('pm.companies.show', $company)); ?>" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-2"></i>
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Update Company
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="card border-danger mt-4">
            <div class="card-header bg-danger text-white">
                <h6 class="card-title mb-0">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Danger Zone
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-danger">Delete Company</h6>
                        <p class="text-muted mb-0 small">
                            Permanently delete this company. This action cannot be undone.
                        </p>
                    </div>
                    <form method="POST" action="<?php echo e(route('pm.companies.destroy', $company)); ?>"
                          onsubmit="return confirm('Are you sure you want to delete this company? This action cannot be undone.')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>
                            Delete Company
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('editCompanyForm');

    form.addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        const telephone = document.getElementById('telephone').value.trim();
        const address = document.getElementById('address').value.trim();
        const type = document.getElementById('type').value;
        const status = document.getElementById('status').value;
        const postoffice = document.getElementById('assign_postoffice').value;

        if (!name || !telephone || !address || !type || !status || !postoffice) {
            e.preventDefault();
            alert('Please fill in all required fields.');
            return false;
        }
    });

    // Telephone validation
    const telephoneInput = document.getElementById('telephone');
    telephoneInput.addEventListener('input', function(e) {
        // Remove non-numeric characters except +, -, space, parentheses
        let value = e.target.value.replace(/[^\d+\-\s()]/g, '');
        e.target.value = value;
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modern-pm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\NEW_ONE-main\resources\views/pm/companies/edit.blade.php ENDPATH**/ ?>