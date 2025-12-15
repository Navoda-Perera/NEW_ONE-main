

<?php $__env->startSection('title', 'Receive Items - ' . $dispatch->necklabel); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-inbox text-success"></i>
            Receive Items
        </h1>
        <div class="d-flex">
            <a href="<?php echo e(route('pm.dispatch.receive-by-necklabel')); ?>" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Search
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

    <!-- Error Messages -->
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

    <!-- Dispatch Info Card -->
    <div class="card shadow mb-4 border-success">
        <div class="card-header bg-success text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-shipping-fast"></i> Dispatch Information
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <strong class="text-success">Necklabel:</strong>
                    <div class="d-flex align-items-center">
                        <code class="bg-success text-white px-2 py-1 rounded mr-2"><?php echo e($dispatch->necklabel); ?></code>
                        <i class="fas fa-tag text-success"></i>
                    </div>
                </div>
                <div class="col-md-3">
                    <strong class="text-success">Manifest ID:</strong>
                    <div><?php echo e($dispatch->manifest_id); ?></div>
                </div>
                <div class="col-md-3">
                    <strong class="text-success">From Location:</strong>
                    <div><?php echo e($dispatch->location->name); ?></div>
                </div>
                <div class="col-md-3">
                    <strong class="text-success">Total Items:</strong>
                    <div><span class="badge badge-info"><?php echo e($dispatchAssociates->count()); ?></span> items to receive</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Items Selection Form -->
    <form action="<?php echo e(route('pm.dispatch.mark-items-received')); ?>" method="POST" id="receiveItemsForm">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="dispatch_id" value="<?php echo e($dispatch->id); ?>">
        
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list"></i> Select Items to Receive
                </h6>
                <div>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="selectAll">
                        <i class="fas fa-check-square"></i> Select All
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAll">
                        <i class="fas fa-square"></i> Deselect All
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <?php if($dispatchAssociates->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" width="60">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="masterCheckbox">
                                            <label class="form-check-label" for="masterCheckbox"></label>
                                        </div>
                                    </th>
                                    <th width="100">Item #</th>
                                    <th width="100">ID</th>
                                    <th>Barcode</th>
                                    <th class="text-center" width="100">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $dispatchAssociates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $associate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="item-row" data-item-id="<?php echo e($associate->item_id); ?>">
                                        <td class="text-center">
                                            <div class="form-check">
                                                <input 
                                                    type="checkbox" 
                                                    name="item_ids[]" 
                                                    value="<?php echo e($associate->item_id); ?>" 
                                                    class="form-check-input item-checkbox"
                                                    id="item_<?php echo e($associate->item_id); ?>"
                                                >
                                                <label class="form-check-label" for="item_<?php echo e($associate->item_id); ?>"></label>
                                            </div>
                                        </td>
                                        <td class="font-weight-bold text-primary">
                                            Item #<?php echo e($index + 1); ?>

                                        </td>
                                        <td class="text-muted">
                                            <?php echo e($associate->item_id); ?>

                                        </td>
                                        <td>
                                            <code class="bg-light px-2 py-1 rounded text-danger"><?php echo e($associate->item->barcode); ?></code>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-warning"><?php echo e(ucfirst($associate->status)); ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Action Section -->
                    <div class="card-footer bg-light">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div id="selectionCount" class="text-muted">
                                    <i class="fas fa-info-circle"></i> Select items to mark as received
                                </div>
                            </div>
                            <div class="col-md-6 text-center">
                                <button type="button" class="btn btn-success btn-lg px-5 mr-2" id="receiveButton" onclick="alert('Button clicked!'); submitForm();">
                                    <i class="fas fa-save mr-2"></i>Store
                                </button>
                                <button type="submit" class="btn btn-outline-success btn-lg px-3" onclick="return confirm('Direct submit - are you sure?');">
                                    <i class="fas fa-upload mr-2"></i>Direct Submit
                                </button>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center p-5">
                        <div class="text-muted mb-3">
                            <i class="fas fa-info-circle fa-3x"></i>
                        </div>
                        <h5 class="text-muted">No Items to Receive</h5>
                        <p class="text-muted">All items in this dispatch have already been received.</p>
                        <a href="<?php echo e(route('pm.dispatch.receive-by-necklabel')); ?>" class="btn btn-primary">
                            <i class="fas fa-search mr-2"></i>Search Another Necklabel
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <!-- Summary Card -->
    <?php if($dispatchAssociates->count() > 0): ?>
        <div class="row mt-4">
            <div class="col-12">
                <div class="alert alert-info border">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle text-info mr-3 fa-2x"></i>
                        <div>
                            <h6 class="text-info font-weight-bold mb-1">Instructions</h6>
                            <p class="mb-0">
                                Select the items you want to mark as received and click the "Mark Selected as Received" button. 
                                Only items with status "dispatch" can be received. The status will change to "received" in the system.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<style>
.item-row {
    transition: all 0.2s ease;
}

.item-row:hover {
    background-color: #f8f9fa !important;
    cursor: pointer;
}

.item-row.table-success {
    background-color: #e8f5e8 !important;
}

.form-check-input:checked {
    background-color: #1cc88a;
    border-color: #1cc88a;
}

.thead-light th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    color: #5a5c69;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}

.form-check {
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>

<script>
// Simple global function to handle form submission
function submitForm() {
    try {
        console.log('submitForm() called');
        
        const checkedItems = document.querySelectorAll('.item-checkbox:checked');
        console.log('Checked items:', checkedItems.length);
        console.log('Checked item values:', Array.from(checkedItems).map(item => item.value));
        
        if (checkedItems.length === 0) {
            alert('Please select at least one item to mark as received.');
            return false;
        }

        const confirmed = confirm(`Are you sure you want to mark ${checkedItems.length} item(s) as received?`);
        console.log('User confirmed:', confirmed);
        
        if (confirmed) {
            const button = document.getElementById('receiveButton');
            if (button) {
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Storing...';
            }
            
            const form = document.getElementById('receiveItemsForm');
            if (form) {
                console.log('Form found:', form);
                console.log('Form action:', form.action);
                console.log('Form method:', form.method);
                
                // Log all form data
                const formData = new FormData(form);
                console.log('Form data:');
                for (let [key, value] of formData.entries()) {
                    console.log(key, value);
                }
                
                console.log('Submitting form...');
                form.submit();
            } else {
                console.error('Form not found!');
                alert('Error: Form not found!');
            }
        }
    } catch (error) {
        console.error('Error in submitForm:', error);
        alert('Error: ' + error.message);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    try {
        console.log('DOM loaded, initializing receive items page');
        
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const selectAllBtn = document.getElementById('selectAll');
        const deselectAllBtn = document.getElementById('deselectAll');
        
        console.log('Found elements:', {
            itemCheckboxes: itemCheckboxes.length,
            selectAllBtn: !!selectAllBtn,
            deselectAllBtn: !!deselectAllBtn
        });

        // Select all button
        if (selectAllBtn) {
            selectAllBtn.addEventListener('click', function() {
                console.log('Select all clicked');
                itemCheckboxes.forEach(checkbox => {
                    checkbox.checked = true;
                });
            });
        }

        // Deselect all button
        if (deselectAllBtn) {
            deselectAllBtn.addEventListener('click', function() {
                console.log('Deselect all clicked');
                itemCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
            });
        }

        console.log('Page initialization complete');
    } catch (error) {
        console.error('Error in DOM ready:', error);
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.modern-pm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\NEW_ONE-main\resources\views/pm/dispatch/receive-items.blade.php ENDPATH**/ ?>