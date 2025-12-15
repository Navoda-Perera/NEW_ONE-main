

<?php $__env->startSection('title', 'Mail Redirect'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-mail-bulk text-warning"></i>
            Mail Redirect
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

    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> <strong>Validation Errors:</strong>
            <ul class="mb-0 mt-2">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Redirect Office Selection & Barcode Entry -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow border-warning">
                <div class="card-header bg-warning text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-mail-bulk"></i> Re-Direct to Destination Office
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Select Redirect Office -->
                    <div class="mb-4">
                        <label for="redirect_office" class="font-weight-bold text-gray-800">
                            <i class="fas fa-building text-warning mr-2"></i>Select Redirect Office
                        </label>
                        <select class="form-control form-control-lg" id="redirect_office" name="redirect_office_id" required>
                            <option value="">Choose destination office...</option>
                            <?php $__currentLoopData = $redirectOffices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $office): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($office->id); ?>"><?php echo e($office->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Add Item by Barcode -->
                    <form action="<?php echo e(route('pm.dispatch.add-redirect-item')); ?>" method="POST" id="addItemForm">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="barcode" class="font-weight-bold text-gray-800">
                                <i class="fas fa-barcode text-warning mr-2"></i>Enter Item Barcode
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-warning text-white">
                                        <i class="fas fa-barcode"></i>
                                    </span>
                                </div>
                                <input 
                                    type="text" 
                                    class="form-control form-control-lg <?php $__errorArgs = ['barcode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="barcode" 
                                    name="barcode" 
                                    placeholder="Scan or enter barcode" 
                                    value="<?php echo e(old('barcode')); ?>"
                                    autocomplete="off"
                                    required
                                    autofocus
                                >
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-warning btn-lg">
                                        <i class="fas fa-plus mr-1"></i>Add
                                    </button>
                                </div>
                                <?php $__errorArgs = ['barcode'];
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
                                <i class="fas fa-info-circle"></i> Enter item barcode and click Add to include it in the redirect list.
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Instructions -->
        <div class="col-lg-4 mb-4">
            <div class="card border-info bg-light">
                <div class="card-body">
                    <h6 class="text-info font-weight-bold mb-3">
                        <i class="fas fa-info-circle"></i> Instructions
                    </h6>
                    <ul class="mb-0 text-muted small">
                        <li class="mb-2">Select the destination office for redirection</li>
                        <li class="mb-2">Enter item barcodes one by one and click Add</li>
                        <li class="mb-2">Added items will appear in the list below</li>
                        <li class="mb-2">Click Store to redirect all items to selected office</li>
                        <li>Items status will be updated to "redirect" in the system</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Redirect Items List -->
    <?php if(!empty($redirectItems)): ?>
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list"></i> Items to Redirect (<?php echo e(count($redirectItems)); ?> items)
                </h6>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearRedirectList()">
                    <i class="fas fa-trash"></i> Clear All
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Barcode</th>
                                <th>Receiver Name</th>
                                <th>Address</th>
                                <th>Weight</th>
                                <th>Amount</th>
                                <th>Current Status</th>
                                <th>Current Office</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $redirectItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <code class="bg-light px-2 py-1 rounded"><?php echo e($item['barcode']); ?></code>
                                    </td>
                                    <td class="font-weight-bold"><?php echo e($item['receiver_name']); ?></td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;" title="<?php echo e($item['receiver_address']); ?>">
                                            <?php echo e($item['receiver_address']); ?>

                                        </div>
                                    </td>
                                    <td><?php echo e(number_format($item['weight'], 2)); ?> kg</td>
                                    <td>LKR <?php echo e(number_format($item['amount'], 2)); ?></td>
                                    <td>
                                        <span class="badge badge-info"><?php echo e(ucfirst($item['current_status'])); ?></span>
                                    </td>
                                    <td><?php echo e($item['current_office']); ?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeItem('<?php echo e($item['item_id']); ?>')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Store Button -->
                <div class="card-footer bg-light text-center">
                    <form action="<?php echo e(route('pm.dispatch.store-redirects')); ?>" method="POST" id="storeRedirectsForm">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="redirect_office_id" id="store_redirect_office_id">
                        <button type="button" class="btn btn-success btn-lg px-5" onclick="storeRedirects()">
                            <i class="fas fa-save mr-2"></i>Store
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="card shadow">
            <div class="card-body text-center p-5">
                <div class="text-muted mb-3">
                    <i class="fas fa-inbox fa-3x"></i>
                </div>
                <h5 class="text-muted">No Items Added</h5>
                <p class="text-muted">Start by selecting a redirect office and adding item barcodes.</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function storeRedirects() {
    const redirectOfficeId = document.getElementById('redirect_office').value;
    
    if (!redirectOfficeId) {
        alert('Please select a redirect office first.');
        return;
    }
    
    if (!confirm('Are you sure you want to redirect all items to the selected office?')) {
        return;
    }
    
    document.getElementById('store_redirect_office_id').value = redirectOfficeId;
    document.getElementById('storeRedirectsForm').submit();
}

function clearRedirectList() {
    if (confirm('Are you sure you want to clear all items from the redirect list?')) {
        // Create a form to clear session
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?php echo e(route("pm.dispatch.mail-redirect")); ?>';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '<?php echo e(csrf_token()); ?>';
        
        const clearInput = document.createElement('input');
        clearInput.type = 'hidden';
        clearInput.name = 'clear_session';
        clearInput.value = '1';
        
        form.appendChild(csrfToken);
        form.appendChild(clearInput);
        document.body.appendChild(form);
        form.submit();
    }
}

function removeItem(itemId) {
    if (confirm('Remove this item from redirect list?')) {
        // Create form to remove specific item
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?php echo e(route("pm.dispatch.mail-redirect")); ?>';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '<?php echo e(csrf_token()); ?>';
        
        const removeInput = document.createElement('input');
        removeInput.type = 'hidden';
        removeInput.name = 'remove_item';
        removeInput.value = itemId;
        
        form.appendChild(csrfToken);
        form.appendChild(removeInput);
        document.body.appendChild(form);
        form.submit();
    }
}

// Auto-clear barcode field after adding item
document.getElementById('addItemForm').addEventListener('submit', function() {
    setTimeout(function() {
        document.getElementById('barcode').value = '';
        document.getElementById('barcode').focus();
    }, 100);
});

// Auto-focus barcode field
document.getElementById('barcode').focus();
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.modern-pm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\NEW_ONE-main\resources\views/pm/dispatch/mail-redirect.blade.php ENDPATH**/ ?>