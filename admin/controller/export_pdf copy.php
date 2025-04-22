<?php

require_once '../../config/db.php';
require_once '../../vendor/autoload.php';

use Dompdf\Dompdf;

// Collect filters
$type      = $_GET['type'] ?? '';
$location  = $_GET['location'] ?? '';
$from_date = $_GET['from_date'] ?? '';
$to_date   = $_GET['to_date'] ?? '';

$conditions = ["deleted = 0"]; // Default filter to exclude deleted
$params = [];
$types = '';

if (!empty($type)) {
    $conditions[] = "type LIKE ?";
    $params[] = "%$type%";
    $types .= 's';
}

if (!empty($location)) {
    $conditions[] = "location LIKE ?";
    $params[] = "%$location%";
    $types .= 's';
}

if (!empty($from_date)) {
    $conditions[] = "date >= ?";
    $params[] = $from_date;
    $types .= 's';
}

if (!empty($to_date)) {
    $conditions[] = "date <= ?";
    $params[] = $to_date;
    $types .= 's';
}

// Final SQL
$sql = "SELECT tracking_id, type, location, date, status FROM reports";
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}
$sql .= " ORDER BY date DESC";

// Prepare query
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Build HTML
$html = "<h2 style='text-align: center;'>CitiGuard - Filtered Report Export</h2>";
$html .= "<table border='1' width='100%' cellpadding='6' cellspacing='0'>
            <thead>
              <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Location</th>
                <th>Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>";

while ($row = $result->fetch_assoc()) {
    $html .= "<tr>
                <td>{$row['tracking_id']}</td>
                <td>{$row['type']}</td>
                <td>{$row['location']}</td>
                <td>{$row['date']}</td>
                <td>{$row['status']}</td>
              </tr>";
}

$html .= "</tbody></table>";

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("filtered_reports.pdf", ["Attachment" => false]);
exit;
