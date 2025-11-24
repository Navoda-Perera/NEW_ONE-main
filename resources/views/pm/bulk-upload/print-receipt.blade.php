<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Upload Receipt - {{ $serviceName }}</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12pt;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 20px;
            background: white;
        }
        
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 2px solid #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24pt;
            font-weight: bold;
        }
        
        .header h2 {
            margin: 5px 0;
            font-size: 18pt;
            color: #555;
        }
        
        .receipt-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .info-section {
            padding: 15px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }
        
        .info-section h3 {
            margin: 0 0 10px 0;
            font-size: 14pt;
            color: #333;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        
        .info-row {
            margin: 8px 0;
            display: flex;
            justify-content: space-between;
        }
        
        .info-label {
            font-weight: bold;
            color: #555;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .items-table th,
        .items-table td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }
        
        .items-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .items-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .totals-section {
            margin-top: 30px;
            padding: 20px;
            border: 2px solid #333;
            background-color: #f0f8ff;
        }
        
        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .totals-table td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        
        .totals-table .total-label {
            font-weight: bold;
            text-align: right;
            width: 70%;
        }
        
        .totals-table .total-amount {
            font-weight: bold;
            text-align: right;
            font-size: 14pt;
        }
        
        .grand-total {
            border-top: 3px solid #333;
            background-color: #e8f5e8;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10pt;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 15px;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .receipt-container {
                border: none;
                padding: 0;
            }
            
            @page {
                margin: 15mm;
            }
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14pt;
            z-index: 1000;
        }
        
        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">🖨️ Print Receipt</button>
    
    <div class="receipt-container">
        <!-- Header -->
        <div class="header">
            <h1>Sri Lanka Post Office</h1>
            <h2>Bulk Upload Receipt</h2>
            <p><strong>Service:</strong> {{ $serviceName }}</p>
        </div>
        
        <!-- Receipt Information -->
        <div class="receipt-info">
            <div class="info-section">
                <h3>Upload Details</h3>
                <div class="info-row">
                    <span class="info-label">Receipt ID:</span>
                    <span>RL{{ str_pad($itemBulk->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date:</span>
                    <span>{{ $itemBulk->created_at->format('Y-m-d H:i:s') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Sender:</span>
                    <span>{{ $itemBulk->sender_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Number of Items:</span>
                    <span><strong>{{ $totalItems }}</strong></span>
                </div>
            </div>
            
            <div class="info-section">
                <h3>Post Office Details</h3>
                <div class="info-row">
                    <span class="info-label">Location:</span>
                    <span>{{ $itemBulk->location->name ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Processed By:</span>
                    <span>{{ $itemBulk->creator->name ?? 'System' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Service Type:</span>
                    <span>{{ $serviceName }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span style="color: green;"><strong>Processed</strong></span>
                </div>
            </div>
        </div>
        
        <!-- Items Table -->
        <h3>Items Summary</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Barcode</th>
                    <th>Receiver Name</th>
                    <th>Address</th>
                    <th>Weight (g)</th>
                    <th>Amount (LKR)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($itemBulk->items->take(10) as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->barcode }}</td>
                    <td>{{ $item->receiver_name }}</td>
                    <td>{{ Str::limit($item->receiver_address, 40) }}</td>
                    <td>{{ $item->weight }}g</td>
                    <td>{{ number_format($item->amount, 2) }}</td>
                </tr>
                @endforeach
                
                @if($itemBulk->items->count() > 10)
                <tr style="background-color: #fff3cd;">
                    <td colspan="6" style="text-align: center; font-style: italic; color: #856404;">
                        ... and {{ $itemBulk->items->count() - 10 }} more items
                        <br><small>Complete item details available in individual receipts</small>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
        
        <!-- Totals Section -->
        <div class="totals-section">
            <h3 style="margin: 0 0 15px 0; text-align: center;">Payment Summary</h3>
            <table class="totals-table">
                <tr>
                    <td class="total-label">Total Items:</td>
                    <td class="total-amount">{{ $totalItems }} items</td>
                </tr>
                <tr>
                    <td class="total-label">Item Values Total:</td>
                    <td class="total-amount">LKR {{ number_format($totalAmount, 2) }}</td>
                </tr>
                <tr>
                    <td class="total-label">Postage Charges:</td>
                    <td class="total-amount">LKR {{ number_format($totalPostage, 2) }}</td>
                </tr>
                <tr class="grand-total">
                    <td class="total-label" style="font-size: 16pt;">GRAND TOTAL:</td>
                    <td class="total-amount" style="font-size: 18pt; color: #006600;">LKR {{ number_format($grandTotal, 2) }}</td>
                </tr>
            </table>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>Thank you for using Sri Lanka Post Office services!</p>
            <p><em>This is a computer-generated receipt. For individual item receipts, please use Item Management.</em></p>
            <p>Receipt generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>
    
    <script>
        // Auto-print when page loads (optional)
        // window.onload = function() {
        //     setTimeout(() => window.print(), 1000);
        // };
    </script>
</body>
</html>