<?php
require 'vendor/autoload.php'; // Load Dompdf
require 'config.php'; // Database connection

use Dompdf\Dompdf;
use Dompdf\Options;

// Initialize Dompdf
$options = new Options();
$options->set('defaultFont', 'Arial');
$dompdf = new Dompdf($options);

// Fetch data from the database
function fetchData($pdo, $query)
{
    $stmt = $pdo->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get data
$farmers = fetchData($conn, "SELECT id, farmer_name, farmer_number, farm_location FROM farmers");
$workers = fetchData($conn, "SELECT id, full_name, job_title FROM workers");
$revenue = fetchData($conn, "SELECT id, sale_date, amount FROM revenue");
$livestock = fetchData($conn, "SELECT id, animal_type, quantity FROM livestock");
$crops = fetchData($conn, "SELECT id, crop_name, planted_date, expected_yield FROM crops");

// Generate HTML for PDF
$html = '<h2>Farm Reports</h2>';

// Function to create table HTML
function generateTable($title, $data, $headers)
{
    $html = "<h3>$title</h3><table border='1' width='100%' cellspacing='0' cellpadding='5'><tr>";
    foreach ($headers as $header) {
        $html .= "<th>$header</th>";
    }
    $html .= "</tr>";

    foreach ($data as $row) {
        $html .= "<tr>";
        foreach ($row as $value) {
            $html .= "<td>$value</td>";
        }
        $html .= "</tr>";
    }

    $html .= "</table><br>";
    return $html;
}

// Add each section to the report
$html .= generateTable('Farmers', $farmers, ['ID', 'Name', 'Contact', 'Farm Location']);
$html .= generateTable('Workers', $workers, ['ID', 'Name', 'Job Title']);
$html .= generateTable('Revenue', $revenue, ['ID', 'Sale Date', 'Amount']);
$html .= generateTable('Livestock', $livestock, ['ID', 'Animal Type', 'Quantity']);
$html .= generateTable('Crops', $crops, ['ID', 'Crop Name', 'Planted Date', 'Expected Yield']);

// Load HTML into Dompdf and render PDF
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("farm_reports_" . date("Y-m-d") . ".pdf", ["Attachment" => true]); // Force download
?>
