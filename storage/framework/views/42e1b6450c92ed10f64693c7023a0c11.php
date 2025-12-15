<?php $__env->startSection('title', 'Change Dispatch Location - Step 1'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-exchange-alt text-warning"></i>
            Change Dispatch Location - Step 1
        </h1>
        <a href="<?php echo e(route('pm.dispatch.index')); ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Dispatches
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
                        <div class="step-item active">
                            <div class="step-number bg-primary text-white">1</div>
                            <div class="step-title">Enter Necklabel</div>
                        </div>
                        <div class="step-line"></div>
                        <div class="step-item">
                            <div class="step-number bg-secondary text-white">2</div>
                            <div class="step-title">Enter Barcode</div>
                        </div>
                        <div class="step-line"></div>
                        <div class="step-item">
                            <div class="step-number bg-secondary text-white">3</div>
                            <div class="step-title">Select New Office</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Necklabel Input Form -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-search"></i> Enter Dispatch Necklabel
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-tags fa-3x text-warning mb-3"></i>
                        <h5>Search Dispatch by Necklabel</h5>
                        <p class="text-muted">Enter the necklabel of the dispatch whose destination office you want to change.</p>
                    </div>

                    <form method="POST" action="<?php echo e(route('pm.dispatch.search-by-necklabel')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="necklabel" class="form-label font-weight-bold">
                                <i class="fas fa-tag"></i> Necklabel
                            </label>
                            <input type="text"
                                   class="form-control form-control-lg <?php $__errorArgs = ['necklabel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="necklabel"
                                   name="necklabel"
                                   value="<?php echo e(old('necklabel')); ?>"
                                   placeholder="Enter dispatch necklabel..."
                                   required
                                   autocomplete="off">
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
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="fas fa-search"></i> Search Dispatch
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Information Card -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-info-circle"></i> Important Information
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Only dispatches from your location can be modified</li>
                        <li>You will need to verify the barcode of an item in the dispatch</li>
                        <li>The dispatch destination office will be changed for all items in the dispatch</li>
                        <li>This action cannot be undone</li>
                    </ul>
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

.step-item.active .step-number {
    background-color: #007bff !important;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modern-pm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\NEW_ONE-main\resources\views/pm/dispatch/change-location-step1.blade.php ENDPATH**/ ?>