<?php

// Test CSV parsing with your sample data
$csvContent = 'Barcode *,"Receiver Name",Mobile,Address,"Post Office","Weight (g)",Amount
nm7654,"nav",0809879888,98/"jhgf","badull",250,200
bh9876,"jhgf",0809876555,098/"kjh","jhgf",500,250';

echo "Testing CSV parsing logic:\n";
echo "========================\n";

// Parse the same way as the controller
$fileContent = str_replace("\r\n", "\n", $csvContent);
$fileContent = str_replace("\r", "\n", $fileContent);

$lines = explode("\n", $fileContent);
$csvData = [];

foreach ($lines as $line) {
    $line = trim($line);
    if (!empty($line)) {
        $parsed = str_getcsv($line);
        if (!empty($parsed) && count($parsed) >= 3) {
            $csvData[] = $parsed;
        }
    }
}

echo "Total lines found: " . count($csvData) . "\n";

// Remove header if it exists
if (!empty($csvData)) {
    $firstRow = $csvData[0];
    echo "First row: " . implode(" | ", $firstRow) . "\n";
    
    if (stripos($firstRow[0], 'barcode') !== false || stripos($firstRow[0], 'code') !== false) {
        echo "Removing header row\n";
        array_shift($csvData);
    }
}

echo "\nData rows after header removal: " . count($csvData) . "\n";

// Process each data row
foreach ($csvData as $index => $row) {
    $rowNumber = $index + 1;
    echo "\nRow {$rowNumber}:\n";
    
    // Ensure minimum columns
    while (count($row) < 6) {
        $row[] = '';
    }
    
    // Trim values
    $row = array_map(function($value) { 
        return is_string($value) ? trim($value) : (string)$value; 
    }, $row);
    
    $barcode = $row[0] ?? '';
    $receiverName = $row[1] ?? '';
    $receiverMobile = $row[2] ?? '';
    $address = $row[3] ?? '';
    $postOffice = $row[4] ?? '';
    $weight = $row[5] ?? '';
    $amount = $row[6] ?? '0';
    
    // Combine address
    $fullAddress = trim($address);
    if (!empty($postOffice)) {
        $fullAddress .= (!empty($fullAddress) ? ', ' : '') . trim($postOffice);
    }
    
    echo "  Barcode: '{$barcode}'\n";
    echo "  Name: '{$receiverName}'\n";
    echo "  Mobile: '{$receiverMobile}'\n";
    echo "  Address: '{$address}'\n";
    echo "  Post Office: '{$postOffice}'\n";
    echo "  Full Address: '{$fullAddress}'\n";
    echo "  Weight: '{$weight}'\n";
    echo "  Amount: '{$amount}'\n";
    
    // Validate
    $errors = [];
    if (empty($barcode)) $errors[] = "Barcode is required";
    if (empty($receiverName)) $errors[] = "Receiver Name is required";
    if (empty($receiverMobile)) $errors[] = "Mobile is required";
    if (empty($fullAddress)) $errors[] = "Address is required";
    if (empty($weight) || !is_numeric($weight) || (float)$weight <= 0) $errors[] = "Valid weight is required";
    
    if (!empty($errors)) {
        echo "  ERRORS: " . implode(", ", $errors) . "\n";
    } else {
        echo "  ✓ Row is valid\n";
    }
}