<?php $__env->startSection('title', 'Create SLP Courier Item'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="bg-pm-secondary text-white p-4 rounded-top">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-0">
                            <i class="bi bi-truck-front-fill"></i>
                            Create SLP Courier Item
                        </h4>
                        <small class="opacity-75">Standard courier service with weight-based pricing</small>
                    </div>
                </div>
            </div>

            <!-- Main Form Card -->
            <div class="card border-0 rounded-top-0 shadow">
                <div class="card-body p-4">
                    <form method="POST" action="<?php echo e(route('pm.single-item.store-slp')); ?>">
                        <?php echo csrf_field(); ?>

                        <!-- Error Display -->
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Sender Information -->
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-person-fill"></i> Sender Information
                        </h6>

                        <div class="row mb-3">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="sender_name" class="form-label">Sender Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="sender_name" name="sender_name"
                                       value="<?php echo e(old('sender_name')); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="sender_mobile" class="form-label">Sender Mobile <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="sender_mobile" name="sender_mobile"
                                       value="<?php echo e(old('sender_mobile')); ?>" placeholder="07XXXXXXXX" required>
                            </div>
                        </div>

                        <!-- Receiver Information -->
                        <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">
                            <i class="bi bi-geo-alt-fill"></i> Receiver Information
                        </h6>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="receiver_name" class="form-label">Receiver Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="receiver_name" name="receiver_name"
                                       value="<?php echo e(old('receiver_name')); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="receiver_mobile" class="form-label">Receiver Mobile <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="receiver_mobile" name="receiver_mobile"
                                       value="<?php echo e(old('receiver_mobile')); ?>" placeholder="07XXXXXXXX" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="receiver_address" class="form-label">Receiver Address <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="receiver_address" name="receiver_address"
                                          rows="3" required><?php echo e(old('receiver_address')); ?></textarea>
                            </div>
                        </div>

                        <!-- Item Information -->
                        <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">
                            <i class="bi bi-box"></i> Item Information
                        </h6>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="weight" class="form-label">Weight (grams) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="weight" name="weight"
                                       value="<?php echo e(old('weight')); ?>" step="0.01" min="0.01" required>
                                <small class="text-muted">Enter weight in grams (e.g., 250 for 250g)</small>
                            </div>
                            <div class="col-md-6">
                                <label for="postage_display" class="form-label">Postage Amount (LKR)</label>
                                <input type="text" class="form-control" id="postage_display" readonly
                                       placeholder="Enter weight to calculate">
                                <small class="text-muted">Automatically calculated based on weight</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="barcode" class="form-label">Barcode <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="barcode" name="barcode"
                                           value="<?php echo e(old('barcode')); ?>" required>
                                    <button type="button" class="btn btn-outline-primary" id="generateBarcode">
                                        <i class="bi bi-arrow-clockwise"></i> Generate
                                    </button>
                                </div>
                                <small class="text-muted">Unique barcode for tracking this courier item</small>
                            </div>
                        </div>

                        <!-- SLP Courier Features -->
                        <div class="alert alert-primary">
                            <h6 class="alert-heading"><i class="bi bi-truck"></i> SLP Courier Features</h6>
                            <ul class="mb-0">
                                <li><i class="bi bi-check text-primary"></i> <strong>Weight-Based Pricing:</strong> Cost calculated based on item weight</li>
                                <li><i class="bi bi-check text-primary"></i> <strong>Standard Delivery:</strong> Regular delivery timeframe</li>
                                <li><i class="bi bi-check text-primary"></i> <strong>Basic Tracking:</strong> Track your item throughout delivery</li>
                                <li><i class="bi bi-check text-primary"></i> <strong>Reliable Service:</strong> Trusted courier network</li>
                            </ul>
                        </div>

                        <!-- Postage Calculation Alert -->
                        <div class="alert alert-info d-none" id="postageAlert">
                            <i class="bi bi-info-circle"></i>
                            <span id="postageMessage">Calculating postage...</span>
                        </div>

                        <!-- Form Actions -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="<?php echo e(route('pm.single-item.index')); ?>" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> Back
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                        <i class="bi bi-check-circle"></i> Create SLP Courier Item
                                    </button>
                                </div>
                            </div>
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
$(document).ready(function() {
    // Generate random barcode
    $('#generateBarcode').click(function() {
        const barcode = 'SLP' + Date.now() + Math.floor(Math.random() * 1000);
        $('#barcode').val(barcode);
    });

    // Calculate postage when weight changes
    $('#weight').on('input', function() {
        const weight = parseFloat($(this).val());

        if (weight && weight > 0) {
            calculatePostage(weight);
        } else {
            $('#postage_display').val('');
            $('#postageAlert').addClass('d-none');
        }
    });

    function calculatePostage(weight) {
        $.ajax({
            url: '<?php echo e(route("pm.single-item.calculate-postage")); ?>',
            method: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                weight: weight,
                service_type: 'slp_courier'
            },
            beforeSend: function() {
                $('#postage_display').val('Calculating...');
                $('#postageAlert').removeClass('d-none alert-danger alert-success')
                    .addClass('alert-info');
                $('#postageMessage').text('Calculating postage...');
            },
            success: function(response) {
                if (response.success) {
                    $('#postage_display').val('LKR ' + response.postage);
                    $('#postageAlert').removeClass('alert-info alert-danger')
                        .addClass('alert-success');
                    $('#postageMessage').text(`Postage calculated: LKR ${response.postage} for ${weight}g`);
                } else {
                    $('#postage_display').val('Error');
                    showError(response.message || 'Failed to calculate postage');
                }
            },
            error: function(xhr) {
                $('#postage_display').val('Error');
                showError('Failed to calculate postage. Please try again.');
            }
        });
    }

    function showError(message) {
        $('#postageAlert').removeClass('alert-info alert-success')
            .addClass('alert-danger');
        $('#postageMessage').text(message);
    }

    // PM must enter or generate barcode manually
    // No automatic barcode generation on page load
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modern-pm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\NEW_ONE-main\resources\views/pm/single-item/slp-form.blade.php ENDPATH**/ ?>