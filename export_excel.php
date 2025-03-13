<?php
require 'vendor/autoload.php'; // Load PhpSpreadsheet
require 'config.php'; // Database connection

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();

// Function to add data to a sheet
function addSheet($spreadsheet, $pdo, $sheetIndex, $sheetName, $query, $headers) {
    $pdoStmt = $pdo->query($query);
    $data = $pdoStmt->fetchAll(PDO::FETCH_ASSOC);

    $sheet = $spreadsheet->createSheet($sheetIndex);
    $sheet->setTitle($sheetName);

    // Add headers
    $col = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($col . '1', $header);
        $col++;
    }

    // Add data
    $row = 2;
    foreach ($data as $record) {
        $col = 'A';
        foreach ($record as $value) {
            $sheet->setCellValue($col . $row, $value);
            $col++;
        }
        $row++;
    }
}

// Farmers Data
addSheet(
    $spreadsheet, $conn, 0, "Farmers",
    "SELECT id, farmer_name, farmer_number, farm_location FROM farmers",
    ['ID', 'Name', 'Contact', 'Farm Location']
);

// Workers Data
addSheet(
    $spreadsheet, $conn, 1, "Workers",
    "SELECT id, full_name, job_title FROM workers",
    ['ID', 'Name', 'Role']
);

// Revenue Data
addSheet(
    $spreadsheet, $conn, 2, "Revenue",
    "SELECT id, sale_date, amount FROM revenue",
    ['ID', 'Sale Date', 'Amount']
);

// Livestock Data
addSheet(
    $spreadsheet, $conn, 3, "Livestock",
    "SELECT id, animal_type, quantity FROM livestock",
    ['ID', 'Animal Type', 'Quantity']
);

// Crops Data
addSheet(
    $spreadsheet, $conn, 4, "Crops",
    "SELECT id, crop_name, planted_date, expected_yield FROM crops",
    ['ID', 'Crop Name', 'Planted Date', 'Expected Yield']
);

// Set the active sheet to the first one
$spreadsheet->setActiveSheetIndex(0);

// Export to Excel
$writer = new Xlsx($spreadsheet);
$filename = "farm_reports_" . date("Y-m-d") . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
$writer->save("php://output");
exit;
?>
