<?php
require 'db.php';
require 'vendor/autoload.php'; // Load dompdf

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('defaultFont', 'Courier');
$dompdf = new Dompdf($options);

// Fetch Data
$html = '<h2>Farm Reports</h2>';

// Crop Report
$html .= '<h3>📌 Crop Report</h3>';
$html .= '<table border="1" cellpadding="5">
            <tr><th>Crop Name</th><th>Planted Date</th><th>Expected Yield</th><th>Actual Yield</th><th>Status</th></tr>';
$crops = $pdo->query("SELECT * FROM crops");
while ($crop = $crops->fetch(PDO::FETCH_ASSOC)) {
    $html .= "<tr>
                <td>{$crop['crop_name']}</td>
                <td>{$crop['planted_date']}</td>
                <td>{$crop['expected_yield']}</td>
                <td>{$crop['actual_yield']}</td>
                <td>{$crop['status']}</td>
            </tr>";
}
$html .= '</table>';

// Livestock Report
$html .= '<h3>📌 Livestock Report</h3>';
$html .= '<table border="1" cellpadding="5">
            <tr><th>Animal Type</th><th>Breed</th><th>Quantity</th><th>Birth Date</th><th>Status</th></tr>';
$livestock = $pdo->query("SELECT * FROM livestock");
while ($animal = $livestock->fetch(PDO::FETCH_ASSOC)) {
    $html .= "<tr>
                <td>{$animal['animal_type']}</td>
                <td>{$animal['breed']}</td>
                <td>{$animal['quantity']}</td>
                <td>{$animal['birth_date']}</td>
                <td>{$animal['status']}</td>
            </tr>";
}
$html .= '</table>';

// Load HTML and Output PDF
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Farm_Reports.pdf", array("Attachment" => 1));
?>
