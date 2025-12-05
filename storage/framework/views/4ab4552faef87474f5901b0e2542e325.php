<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITEM MANIFEST - <?php echo e($dispatch->manifest_id); ?></title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            font-size: 14px;
            line-height: 1.4;
            color: #000;
            background: white;
        }
        
        .manifest-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .manifest-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .manifest-title {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 20px;
            text-decoration: underline;
        }
        
        .manifest-info {
            margin: 20px 0;
        }
        
        .manifest-info table {
            width: 100%;
            margin-bottom: 15px;
        }
        
        .manifest-info td {
            padding: 3px 0;
            vertical-align: top;
        }
        
        .manifest-info td:first-child {
            text-align: left;
        }
        
        .manifest-info td:last-child {
            text-align: right;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .items-table th,
        .items-table td {
            border: 2px solid #000;
            padding: 8px;
            text-align: center;
            vertical-align: middle;
        }
        
        .items-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        .items-table .col-number {
            width: 8%;
        }
        
        .items-table .col-identifier {
            width: 30%;
        }
        
        .items-table .col-empty {
            width: 62%;
        }
        
        .print-button {
            text-align: center;
            margin: 30px 0;
        }
        
        .btn-print {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .btn-print:hover {
            background-color: #0056b3;
        }
        
        @media print {
            .no-print {
                display: none !important;
            }
            
            .manifest-container {
                margin: 0;
                padding: 0;
            }
            
            .items-table {
                page-break-inside: avoid;
            }
            
            body {
                background: white;
            }
        }
        
        .footer-info {
            margin-top: 40px;
            font-size: 12px;
        }
        
        .signature-area {
            margin-top: 50px;
            border-top: 1px solid #000;
            width: 200px;
            text-align: center;
            font-size: 12px;
        }
        
        .page-number {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="manifest-container">
        <!-- Print Button (hidden in print) -->
        <div class="print-button no-print">
            <button type="button" class="btn-print" onclick="window.print()">
                🖨️ Print Manifest
            </button>
            <button type="button" class="btn-print" onclick="window.close()" style="background-color: #6c757d; margin-left: 10px;">
                ❌ Close
            </button>
        </div>

        <!-- Manifest Header -->
        <div class="manifest-header">
            <div class="manifest-title">ITEM MANIFEST</div>
        </div>

        <!-- Manifest Information -->
        <div class="manifest-info">
            <table>
                <tr>
                    <td><strong>User:</strong> <?php echo e($dispatch->creator->name); ?></td>
                    <td><strong>List Serial No:</strong> <?php echo e($dispatch->manifest_id); ?></td>
                </tr>
                <tr>
                    <td><strong>Office:</strong> <?php echo e($dispatch->location->name); ?></td>
                    <td><strong>Neck Label:</strong> <?php echo e($dispatch->necklabel); ?></td>
                </tr>
                <tr>
                    <td><strong>Date:</strong> <?php echo e($dispatch->created_at->format('Y-m-d H:i:s')); ?></td>
                    <td><strong>Number of Item:</strong> <?php echo e($dispatchedItems->count()); ?></td>
                </tr>
                <tr>
                    <td><strong>To Office:</strong> <?php echo e($dispatch->destinationOffice->name); ?></td>
                    <td></td>
                </tr>
            </table>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th class="col-number">#</th>
                    <th class="col-identifier">Identifier</th>
                    <th class="col-empty"></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $dispatchedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $dispatchItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e($dispatchItem->item->barcode); ?></td>
                        <td></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 20px; color: #666;">
                            No items in this manifest
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Print Footer Information -->
        <div class="footer-info">
            <p><strong>Summary:</strong></p>
            <ul style="margin-left: 20px;">
                <li>Total Items: <?php echo e($dispatchedItems->count()); ?></li>
                <li>Total Value: LKR <?php echo e(number_format($dispatchedItems->sum('item.amount'), 2)); ?></li>
                <li>Generated: <?php echo e(now()->format('d/m/Y H:i:s')); ?></li>
            </ul>
        </div>

        <!-- Signature Areas -->
        <div style="display: flex; justify-content: space-between; margin-top: 60px;">
            <div class="signature-area">
                <p style="margin-top: 10px;">Prepared By</p>
            </div>
            <div class="signature-area">
                <p style="margin-top: 10px;">Verified By</p>
            </div>
            <div class="signature-area">
                <p style="margin-top: 10px;">Received By</p>
            </div>
        </div>

        <!-- Page Number -->
        <div class="page-number">
            Page 1 of 1
        </div>
    </div>

    <script>
        // Auto-print when page loads (optional)
        window.onload = function() {
            // Uncomment the line below if you want automatic printing
            // window.print();
        };

        // Print function
        function printManifest() {
            window.print();
        }

        // Handle keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl+P for print
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
            // Escape to close
            if (e.key === 'Escape') {
                window.close();
            }
        });
    </script>
</body>
</html><?php /**PATH C:\Users\User\Desktop\NEW_ONE-main\resources\views/pm/dispatch/print-manifest.blade.php ENDPATH**/ ?>