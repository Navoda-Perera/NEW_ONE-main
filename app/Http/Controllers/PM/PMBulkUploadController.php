<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Item;
use App\Models\ItemBulk;
use App\Models\Receipt;
use App\Models\SmsSent;
use App\Models\Company;
use App\Models\Location;

class PMBulkUploadController extends Controller
{
    public function index()
    {
        $user = Auth::guard('pm')->user();
        $location = $user ? $user->location : null;
        $companies = Company::all();

        return view('pm.bulk-upload.index', compact('location', 'companies'));
    }

    public function showSlpForm()
    {
        $user = Auth::guard('pm')->user();
        $location = $user ? $user->location : null;
        $companies = Company::all();
        return view('pm.bulk-upload.slp-form', compact('companies', 'location'));
    }

    public function showCodForm()
    {
        $user = Auth::guard('pm')->user();
        $location = $user ? $user->location : null;
        $companies = Company::all();
        return view('pm.bulk-upload.cod-form', compact('companies', 'location'));
    }

    public function showRegisterForm()
    {
        $user = Auth::guard('pm')->user();
        $location = $user ? $user->location : null;
        $companies = Company::all();
        return view('pm.bulk-upload.register-form', compact('companies', 'location'));
    }

    public function downloadTemplate($serviceType)
    {
        // Define columns based on service type
        $columns = ['Barcode *', 'Receiver Name', 'Mobile', 'Address', 'Post Office', 'Weight (g)'];

        if ($serviceType === 'cod') {
            $columns[] = 'Amount';
        } elseif ($serviceType === 'register_post') {
            $columns[] = 'Amount';
        } elseif ($serviceType === 'slp') {
            $columns[] = 'Amount';
        }

        $fileName = ucfirst($serviceType) . '_Bulk_Upload_Template.csv';

        return response()->streamDownload(function () use ($columns) {
            $output = fopen('php://output', 'w');
            fputcsv($output, $columns);
            fclose($output);
        }, $fileName, [
            'Content-Type' => 'text/csv',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=' . $fileName,
            'Expires' => '0',
            'Pragma' => 'public',
        ]);
    }

    public function uploadSlp(Request $request)
    {
        return $this->processUpload($request, 'slp_courier');
    }

    public function uploadCod(Request $request)
    {
        return $this->processUpload($request, 'cod');
    }

    public function uploadRegister(Request $request)
    {
        return $this->processUpload($request, 'register_post');
    }

    private function processUpload(Request $request, $serviceType)
    {
        $request->validate([
            'sender_name' => 'required|string|max:255',
            'sender_mobile' => 'required|string|max:15',
            'csv_file' => 'required|file|mimes:csv,txt|max:5120'
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::guard('pm')->user();
            $file = $request->file('csv_file');

            // Read CSV file with better encoding handling
            $fileContent = file_get_contents($file->getPathname());

            // Convert to UTF-8 if needed
            if (!mb_check_encoding($fileContent, 'UTF-8')) {
                $fileContent = mb_convert_encoding($fileContent, 'UTF-8', 'auto');
            }

            // Parse CSV data - fix line ending issues
            $fileContent = str_replace("\r\n", "\n", $fileContent);
            $fileContent = str_replace("\r", "\n", $fileContent);

            // Split into lines and parse each as CSV
            $lines = explode("\n", $fileContent);
            $csvData = [];

            foreach ($lines as $line) {
                $line = trim($line);
                if (!empty($line)) {
                    $parsed = str_getcsv($line);
                    if (!empty($parsed) && count($parsed) >= 3) { // At least barcode, name, mobile
                        $csvData[] = $parsed;
                    }
                }
            }

            // Remove header row if it exists
            if (!empty($csvData)) {
                $firstRow = $csvData[0];
                // Check if first row looks like headers
                if (stripos($firstRow[0], 'barcode') !== false || stripos($firstRow[0], 'code') !== false) {
                    array_shift($csvData);
                }
            }

            $items = [];
            $errors = [];

            // Validate CSV structure
            if (empty($csvData)) {
                DB::rollBack();
                return redirect()->back()
                    ->withErrors(['csv_file' => 'CSV file is empty or has no valid data rows'])
                    ->withInput();
            }

            // Create ItemBulk record
            $itemBulk = ItemBulk::create([
                'sender_name' => $request->sender_name,
                'service_type' => $serviceType,
                'location_id' => $user->location_id,
                'created_by' => $user->id,
                'category' => 'bulk_list',
                'item_quantity' => 0 // Will be updated later
            ]);

            foreach ($csvData as $index => $row) {
                $rowNumber = $index + 1; // Actual row number in CSV data

                // Skip completely empty rows
                if (empty(array_filter($row, function($value) {
                    return !is_null($value) && trim($value) !== '';
                }))) {
                    continue;
                }

                // Ensure row has minimum required columns (pad with empty strings)
                while (count($row) < 6) {
                    $row[] = '';
                }

                // Trim all values
                $row = array_map(function($value) {
                    return is_string($value) ? trim($value) : (string)$value;
                }, $row);

                // Extract fields based on expected CSV format:
                // Barcode, Receiver Name, Mobile, Address, Post Office, Weight(g), Amount
                $barcode = $row[0] ?? '';
                $receiverName = $row[1] ?? '';
                $receiverMobile = $row[2] ?? '';
                $address = $row[3] ?? '';
                $postOffice = $row[4] ?? '';
                $weight = $row[5] ?? '';
                $amount = $row[6] ?? '0';

                // Debug log the extracted data
                Log::info("Processing CSV row {$rowNumber}", [
                    'barcode' => $barcode,
                    'receiverName' => $receiverName,
                    'receiverMobile' => $receiverMobile,
                    'address' => $address,
                    'weight' => $weight,
                    'amount' => $amount
                ]);

                // Validate required fields
                if (empty($barcode)) {
                    $errors[] = "Row {$rowNumber}: Barcode is required";
                    continue;
                }

                if (empty($receiverName)) {
                    $errors[] = "Row {$rowNumber}: Receiver Name is required";
                    continue;
                }

                if (empty($receiverMobile)) {
                    $errors[] = "Row {$rowNumber}: Mobile number is required";
                    continue;
                }

                // Validate mobile number format (basic validation)
                $cleanMobile = preg_replace('/[^0-9]/', '', $receiverMobile);
                if (strlen($cleanMobile) < 9 || strlen($cleanMobile) > 15) {
                    $errors[] = "Row {$rowNumber}: Invalid mobile number format (should be 9-15 digits)";
                    continue;
                }

                if (empty($weight) || !is_numeric($weight) || (float)$weight <= 0) {
                    $errors[] = "Row {$rowNumber}: Weight must be a valid positive number";
                    continue;
                }

                // Additional validation for COD amounts
                if ($serviceType === 'cod') {
                    if (empty($amount) || !is_numeric($amount) || (float)$amount <= 0) {
                        $errors[] = "Row {$rowNumber}: COD Amount must be a valid positive number";
                        continue;
                    }
                }

                // Validate address is provided (combine address and post office if available)
                $fullAddress = trim($address);
                if (!empty($postOffice)) {
                    $fullAddress .= (!empty($fullAddress) ? ', ' : '') . trim($postOffice);
                }

                if (empty($fullAddress)) {
                    $errors[] = "Row {$rowNumber}: Address is required";
                    continue;
                }

                // Calculate postage
                $weight = (float) $weight;
                $postage = $this->calculatePostageForService($serviceType, $weight);
                $amount = (float) ($amount ?: 0);
                $totalAmount = ($serviceType === 'cod') ? $amount : ($amount + $postage);

                // Create Item record
                $item = Item::create([
                    'barcode' => $barcode,
                    'receiver_name' => $receiverName,
                    'receiver_address' => $fullAddress,
                    'weight' => $weight,
                    'amount' => $totalAmount,
                    'status' => 'accept',
                    'created_by' => $user->id,
                    'item_bulk_id' => $itemBulk->id
                ]);

                // Create SMS record
                SmsSent::create([
                    'item_id' => $item->id,
                    'sender_mobile' => $request->sender_mobile,
                    'receiver_mobile' => $receiverMobile,
                    'status' => 'accept'
                ]);

                $items[] = $item;
            }

            if (empty($items) && !empty($errors)) {
                DB::rollBack();
                return redirect()->back()
                    ->withErrors(['upload' => 'No valid items found in the uploaded file.'])
                    ->with('upload_errors', $errors)
                    ->withInput();
            }

            // Update item quantity
            $itemBulk->update(['item_quantity' => count($items)]);

            // Load SMS relations for display and calculate total
            $itemIds = collect($items)->pluck('id');
            $itemsWithSms = Item::whereIn('id', $itemIds)->with('smsSents')->get();
            $totalAmount = $itemsWithSms->sum('amount');

            DB::commit();

            Log::info("Bulk upload completed", [
                'total_items' => count($items),
                'total_errors' => count($errors),
                'bulk_id' => $itemBulk->id
            ]);

            return redirect()->back()
                ->with('success', 'Bulk upload completed successfully! ' . count($items) . ' items uploaded.')
                ->with('uploaded_items', $itemsWithSms)
                ->with('bulk_id', $itemBulk->id)
                ->with('total_amount', $totalAmount)
                ->with('upload_errors', $errors);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['upload' => 'Error processing file: ' . $e->getMessage()])
                ->withInput();
        }
    }

    private function calculatePostageForService($serviceType, $weight)
    {
        switch ($serviceType) {
            case 'slp_courier':
                // Use SLP pricing from slp_pricing table (singular)
                $pricing = DB::table('slp_pricing')
                    ->where('weight_from', '<=', $weight)
                    ->where('weight_to', '>=', $weight)
                    ->where('is_active', true)
                    ->first();
                return $pricing ? $pricing->price : 50; // Default fallback

            case 'cod':
                // Use post_pricing table with service_type filter
                $pricing = DB::table('post_pricing')
                    ->where('service_type', 'cod')
                    ->where('min_weight', '<=', $weight)
                    ->where('max_weight', '>=', $weight)
                    ->first();
                return $pricing ? $pricing->price : 75; // Default fallback

            case 'register_post':
                // Use post_pricing table with service_type filter
                $pricing = DB::table('post_pricing')
                    ->where('service_type', 'register')
                    ->where('min_weight', '<=', $weight)
                    ->where('max_weight', '>=', $weight)
                    ->first();
                return $pricing ? $pricing->price : 60; // Default fallback

            default:
                return 50; // Default price
        }
    }

    public function removeBulkItem(Request $request)
    {
        try {
            DB::beginTransaction();

            $item = Item::find($request->item_id);

            if (!$item) {
                return response()->json(['success' => false, 'message' => 'Item not found.']);
            }

            // Remove associated SMS record
            SmsSent::where('item_id', $item->id)->delete();

            // Remove item
            $item->delete();

            // Update bulk item quantity
            $itemBulk = ItemBulk::find($item->item_bulk_id);
            if ($itemBulk) {
                $remainingItems = Item::where('item_bulk_id', $itemBulk->id)->count();
                $itemBulk->update(['item_quantity' => $remainingItems]);

                // If no items left, remove the bulk record
                if ($remainingItems === 0) {
                    $itemBulk->delete();
                }
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Item removed successfully.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error removing item: ' . $e->getMessage()]);
        }
    }

    public function processBulk($bulkId)
    {
        try {
            DB::beginTransaction();

            // Get all items for this bulk upload
            $itemBulk = ItemBulk::findOrFail($bulkId);
            $items = Item::where('item_bulk_id', $bulkId)->with('smsSents')->get();

            if ($items->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No items found to process.']);
            }

            $receiptsCreated = 0;
            foreach ($items as $item) {
                // Get mobile number from SMS record
                $smsRecord = $item->smsSents->first();
                $receiverMobile = $smsRecord ? $smsRecord->receiver_mobile : null;

                // Create receipt for each item
                Receipt::create([
                    'item_id' => $item->id,
                    'item_bulk_id' => $itemBulk->id,
                    'barcode' => $item->barcode,
                    'receiver_name' => $item->receiver_name,
                    'receiver_mobile' => $receiverMobile,
                    'receiver_address' => $item->receiver_address,
                    'weight' => $item->weight,
                    'postage' => $item->amount - ($item->amount > 50 ? 50 : 0), // Estimate postage
                    'total_amount' => $item->amount,
                    'service_type' => $itemBulk->service_type,
                    'location_id' => $itemBulk->location_id,
                    'created_by' => Auth::guard('pm')->id(),
                    'status' => 'pending'
                ]);

                // Update item status to processed
                $item->update(['status' => 'processed']);

                $receiptsCreated++;
            }

            // Update bulk status
            $itemBulk->update(['category' => 'processed']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Successfully created {$receiptsCreated} receipts from bulk upload.",
                'receipts_created' => $receiptsCreated
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error processing bulk items: ' . $e->getMessage()]);
        }
    }

    public function processBulkItems(Request $request)
    {
        try {
            DB::beginTransaction();

            $bulkId = $request->bulk_id;
            $items = Item::where('item_bulk_id', $bulkId)->get();

            foreach ($items as $item) {
                // Create receipt for each item
                Receipt::create([
                    'item_id' => $item->id,
                    'barcode' => $item->barcode,
                    'receiver_name' => $item->receiver_name,
                    'receiver_address' => $item->receiver_address,
                    'weight' => $item->weight,
                    'amount' => $item->amount,
                    'created_by' => Auth::guard('pm')->id(),
                    'status' => 'pending'
                ]);
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Bulk items processed successfully.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error processing bulk items: ' . $e->getMessage()]);
        }
    }
}
