<?php
require 'config.php';
require 'vendor/autoload.php'; // Load PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("Farm Reports");

// Set Headers
$sheet->setCellValue("A1", "Crop Name");
$sheet->setCellValue("B1", "Planted Date");
$sheet->setCellValue("C1", "Expected Yield");
$sheet->setCellValue("D1", "Actual Yield");
$sheet->setCellValue("E1", "Status");

$row = 2;
$crops = $pdo->query("SELECT * FROM crops");
while ($crop = $crops->fetch(PDO::FETCH_ASSOC)) {
    $sheet->setCellValue("A$row", $crop['crop_name']);
    $sheet->setCellValue("B$row", $crop['planted_date']);
    $sheet->setCellValue("C$row", $crop['expected_yield']);
    $sheet->setCellValue("D$row", $crop['actual_yield']);
    $sheet->setCellValue("E$row", $crop['status']);
    $row++;
}

// Download Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Farm_Reports.xlsx"');
$writer = new Xlsx($spreadsheet);
$writer->save("php://output");
exit;
?>
