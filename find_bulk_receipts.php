<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Receipt;
use App\Models\ItemBulk;
use App\Models\Item;

echo "=== FINDING YOUR BULK UPLOAD RECEIPTS ===\n\n";

// Find the most recent bulk uploads (today's date)
$todayBulks = ItemBulk::where('category', 'bulk_list')
    ->where('created_at', '>=', now()->startOfDay())
    ->with(['receipts', 'items', 'creator'])
    ->orderBy('created_at', 'desc')
    ->get();

if ($todayBulks->count() > 0) {
    echo "📦 RECENT BULK UPLOADS (Today):\n\n";

    foreach ($todayBulks as $bulk) {
        echo "ItemBulk ID: {$bulk->id}\n";
        echo "Service Type: " . strtoupper($bulk->service_type) . "\n";
        echo "Sender: {$bulk->sender_name}\n";
        echo "Items Count: {$bulk->item_quantity}\n";
        echo "Created: {$bulk->created_at}\n";
        echo "PM: " . ($bulk->creator->name ?? 'N/A') . "\n";

        // Check for receipts
        $receipts = $bulk->receipts;
        echo "Receipts: " . $receipts->count() . "\n";

        if ($receipts->count() > 0) {
            foreach ($receipts as $receipt) {
                echo "  └── Receipt ID: {$receipt->id}\n";
                echo "      Passcode: {$receipt->passcode}\n";
                echo "      Amount: LKR " . number_format($receipt->amount, 2) . "\n";
                echo "      Items: {$receipt->item_quantity}\n";
                echo "      Created: {$receipt->created_at}\n";

                // Show how to access this receipt
                echo "\n📋 HOW TO PRINT THIS RECEIPT:\n";
                echo "Option 1 - Item Management:\n";
                echo "  1. Go to PM Dashboard → Item Management\n";
                echo "  2. Search for any barcode from this bulk\n";
                echo "  3. Look for Receipt info in the item details\n\n";

                echo "Option 2 - Direct URL:\n";
                echo "  Visit: http://127.0.0.1:8000/pm/single-item/receipt/{$receipt->id}\n";
                echo "  Print URL: http://127.0.0.1:8000/pm/single-item/print-receipt/{$receipt->id}\n\n";

                echo "Option 3 - Browser Print:\n";
                echo "  1. Navigate to receipt page\n";
                echo "  2. Press Ctrl+P or Cmd+P\n";
                echo "  3. Select printer and print\n\n";
            }
        } else {
            echo "  ❌ No receipts found for this bulk upload!\n";
        }

        echo "Items in this bulk:\n";
        foreach ($bulk->items as $item) {
            echo "  - {$item->barcode}: {$item->receiver_name} (LKR {$item->amount})\n";
        }
        echo "\n" . str_repeat("-", 50) . "\n\n";
    }
} else {
    echo "❌ No bulk uploads found for today.\n";
    echo "Let me check recent uploads from the last few days...\n\n";

    $recentBulks = ItemBulk::where('category', 'bulk_list')
        ->where('created_at', '>=', now()->subDays(3))
        ->with(['receipts', 'items'])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    if ($recentBulks->count() > 0) {
        echo "📦 RECENT BULK UPLOADS (Last 3 days):\n\n";
        foreach ($recentBulks as $bulk) {
            echo "ItemBulk ID: {$bulk->id} | Service: {$bulk->service_type} | Items: {$bulk->item_quantity} | Date: {$bulk->created_at}\n";
        }
    } else {
        echo "❌ No recent bulk uploads found.\n";
    }
}

echo "\n=== QUICK RECEIPT ACCESS GUIDE ===\n";
echo "1. **Best Method**: Go to PM Dashboard → Item Management → Search by Barcode\n";
echo "2. **Direct URLs**: Use the URLs shown above for your receipt IDs\n";
echo "3. **Customer Uploads**: Go to PM Dashboard → Customer Uploads for customer receipts\n";
echo "4. **Print Format**: All receipt pages have optimized print layouts\n";

?>
