<?php $__env->startSection('title', 'Receive Items by Necklabel'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-inbox text-success"></i>
            Receive Items by Necklabel
        </h1>
        <div class="d-flex">
            <a href="<?php echo e(route('pm.dispatch.index')); ?>" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Dispatches
            </a>
        </div>
    </div>

    <!-- Success Message -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Error Message -->
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Main Card -->
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-tag"></i> Enter Necklabel to Find Items
                    </h6>
                </div>
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-inbox text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h4 class="text-gray-800 mb-2">Mark Items as Received</h4>
                        <p class="text-muted">Enter the necklabel to view all items in the dispatch and mark them as received.</p>
                    </div>

                    <form action="<?php echo e(route('pm.dispatch.find-items-by-necklabel')); ?>" method="POST" id="necklabelForm">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="necklabel" class="font-weight-bold text-gray-800">
                                <i class="fas fa-tag text-success mr-2"></i>Necklabel
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-success text-white">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <input
                                    type="text"
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
                                    placeholder="Enter necklabel (e.g., NCK123456)"
                                    value="<?php echo e(old('necklabel')); ?>"
                                    autocomplete="off"
                                    autocapitalize="characters"
                                    required
                                    autofocus
                                >
                                <?php $__errorArgs = ['necklabel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Enter the necklabel to find all items in the dispatch that can be marked as received.
                            </small>
                        </div>

                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">
                                <i class="fas fa-search mr-2"></i>Find Items
                            </button>
                        </div>
                    </form>

                    <!-- Instructions -->
                    <div class="card border-info bg-light mt-4">
                        <div class="card-body">
                            <h6 class="text-info font-weight-bold mb-3">
                                <i class="fas fa-info-circle"></i> Instructions
                            </h6>
                            <ul class="mb-0 text-muted">
                                <li class="mb-2">Enter the necklabel to find all dispatched items for your location</li>
                                <li class="mb-2">You can only receive items that are dispatched to your current office location</li>
                                <li class="mb-2">Select the items you want to mark as received</li>
                                <li>The system will update the dispatch status to "received" for selected items</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('necklabel').addEventListener('input', function() {
    this.value = this.value.toUpperCase();
});

document.getElementById('necklabelForm').addEventListener('submit', function() {
    const button = this.querySelector('button[type="submit"]');
    const icon = button.querySelector('i');

    button.disabled = true;
    icon.className = 'fas fa-spinner fa-spin mr-2';
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Searching...';
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modern-pm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\NEW_ONE-main\resources\views/pm/dispatch/receive-by-necklabel.blade.php ENDPATH**/ ?>