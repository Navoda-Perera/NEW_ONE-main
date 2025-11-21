<?php $__env->startSection('title', 'Bulk Upload Management'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-cloud-upload me-2 text-primary"></i>
                    Bulk Upload Management
                </h2>
                <p class="text-muted mb-0">Upload multiple postal items using CSV files for SLP Courier, COD, and Register Post services.</p>
            </div>
            <div class="text-end">
                <div class="badge bg-light text-dark fs-6 px-3 py-2">
                    <i class="bi bi-geo-alt text-danger me-1"></i>
                    <?php echo e($location ? $location->name : 'No location'); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Service Cards -->
<div class="row g-4">
    <!-- SLP Courier Card -->
    <div class="col-lg-4 col-md-6">
        <div class="card border-0 shadow-sm h-100 service-card courier-card">
            <div class="card-body text-center p-4">
                <div class="service-icon mb-3">
                    <i class="bi bi-truck display-4 text-primary"></i>
                </div>
                <h4 class="card-title text-primary fw-bold mb-3">SLP Courier Bulk</h4>
                <p class="card-text text-muted mb-3">
                    Upload multiple courier items from CSV file with weight-based pricing calculation.
                </p>

                <div class="features-list mb-4">
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>CSV Upload</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>Batch Processing</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>Auto Pricing</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>Bulk Receipt</span>
                    </div>
                </div>

                <a href="<?php echo e(route('pm.bulk-upload.slp-form')); ?>" class="btn btn-primary btn-lg w-100 service-btn">
                    <i class="bi bi-cloud-upload me-2"></i>Upload SLP Bulk
                </a>
            </div>
        </div>
    </div>

    <!-- COD Card -->
    <div class="col-lg-4 col-md-6">
        <div class="card border-0 shadow-sm h-100 service-card cod-card">
            <div class="card-body text-center p-4">
                <div class="service-icon mb-3">
                    <i class="bi bi-cash-coin display-4 text-warning"></i>
                </div>
                <h4 class="card-title text-warning fw-bold mb-3">COD Bulk Upload</h4>
                <p class="card-text text-muted mb-3">
                    Upload multiple COD items with amount collection and postage calculation.
                </p>

                <div class="features-list mb-4">
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>COD Processing</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>Amount Validation</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>Bulk Receipt</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>SMS Notifications</span>
                    </div>
                </div>

                <a href="<?php echo e(route('pm.bulk-upload.cod-form')); ?>" class="btn btn-warning btn-lg w-100 service-btn">
                    <i class="bi bi-cloud-upload me-2"></i>Upload COD Bulk
                </a>
            </div>
        </div>
    </div>

    <!-- Register Post Card -->
    <div class="col-lg-4 col-md-6">
        <div class="card border-0 shadow-sm h-100 service-card register-card">
            <div class="card-body text-center p-4">
                <div class="service-icon mb-3">
                    <i class="bi bi-envelope-check display-4 text-danger"></i>
                </div>
                <h4 class="card-title text-danger fw-bold mb-3">Register Post Bulk</h4>
                <p class="card-text text-muted mb-3">
                    Upload multiple registered postal items with tracking and delivery confirmation.
                </p>

                <div class="features-list mb-4">
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>Registered Tracking</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>Bulk Processing</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>CSV Template</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>Official Receipt</span>
                    </div>
                </div>

                <a href="<?php echo e(route('pm.bulk-upload.register-form')); ?>" class="btn btn-danger btn-lg w-100 service-btn">
                    <i class="bi bi-cloud-upload me-2"></i>Upload Register Bulk
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Information Cards -->
<div class="row mt-5">
    <div class="col-12">
        <div class="card border-0 shadow-sm bg-light">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="card-title text-primary mb-2">
                            <i class="bi bi-info-circle me-2"></i>
                            How Bulk Upload Works
                        </h5>
                        <p class="card-text text-muted mb-0">
                            1. Choose service type (SLP, COD, or Register Post)<br>
                            2. Fill in company and sender details<br>
                            3. Download CSV template and fill with item data<br>
                            4. Upload the completed CSV file<br>
                            5. Review and process the bulk items
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="location-badge">
                            <i class="bi bi-building text-primary me-2"></i>
                            <span class="fw-bold">Location:</span>
                            <?php echo e($location ? $location->name : 'Not Assigned'); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<?php if($companies->count() > 0): ?>
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h6 class="card-title mb-0">
                    <i class="bi bi-building me-2 text-primary"></i>
                    Active Companies (<?php echo e($companies->count()); ?>)
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4">
                        <div class="badge bg-light text-dark p-2 w-100">
                            <i class="bi bi-dot text-success"></i>
                            <?php echo e($company->name); ?>

                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<style>
.service-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    border-radius: 15px !important;
}

.service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.courier-card:hover {
    border-left: 4px solid #0d6efd !important;
}

.cod-card:hover {
    border-left: 4px solid #ffc107 !important;
}

.register-card:hover {
    border-left: 4px solid #dc3545 !important;
}

.service-icon {
    margin-bottom: 1rem;
}

.features-list {
    text-align: left;
}

.feature-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.service-btn {
    border-radius: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.location-info-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.location-badge {
    background: rgba(255,255,255,0.1);
    padding: 0.5rem 1rem;
    border-radius: 25px;
    backdrop-filter: blur(10px);
    font-size: 0.9rem;
}
</style>

<?php echo $__env->make('layouts.modern-pm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\NEW_ONE-main\resources\views/pm/bulk-upload/index.blade.php ENDPATH**/ ?>