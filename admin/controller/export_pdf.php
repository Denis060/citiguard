<?php
require_once '../../config/db.php';
require_once '../../vendor/autoload.php';

use Dompdf\Dompdf;

// Collect filters
$type      = $_GET['type'] ?? '';
$region    = $_GET['region'] ?? '';
$district  = $_GET['district'] ?? '';
$chiefdom  = $_GET['chiefdom'] ?? '';
$location  = $_GET['location'] ?? '';
$from_date = $_GET['from_date'] ?? '';
$to_date   = $_GET['to_date'] ?? '';

// Build filter
$conditions = ["deleted = 0"];
$params = [];
$types = '';

if (!empty($type)) {
    $conditions[] = "type LIKE ?";
    $params[] = "%$type%";
    $types .= 's';
}
if (!empty($region)) {
    $conditions[] = "region LIKE ?";
    $params[] = "%$region%";
    $types .= 's';
}
if (!empty($district)) {
    $conditions[] = "district LIKE ?";
    $params[] = "%$district%";
    $types .= 's';
}
if (!empty($chiefdom)) {
    $conditions[] = "chiefdom LIKE ?";
    $params[] = "%$chiefdom%";
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
$sql = "
    SELECT 
        r.tracking_id, 
        r.type, 
        rg.name AS region_name, 
        d.name AS district_name, 
        c.name AS chiefdom_name, 
        r.location, 
        r.date, 
        r.status 
    FROM reports r
    LEFT JOIN regions rg ON r.region = rg.id
    LEFT JOIN districts d ON r.district = d.id
    LEFT JOIN chiefdoms c ON r.chiefdom = c.id
";
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}
$sql .= " ORDER BY r.date DESC";

// Run Query
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No reports found for the selected filters.";
    exit;
}

// Build PDF
$html = "<style>
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
    .header { text-align: center; font-size: 1.5rem; margin-bottom: 20px; }
    .footer { text-align: center; font-size: 0.8rem; margin-top: 20px; }
</style>";
$html .= "<div class='header'>CitiGuard - Filtered Report Export</div>";
$html .= "<table border='1' width='100%' cellpadding='6' cellspacing='0'>
<thead>
  <tr>
    <th>ID</th>
    <th>Type</th>
    <th>Region</th>
    <th>District</th>
    <th>Chiefdom</th>
    <th>Location</th>
    <th>Date</th>
    <th>Status</th>
  </tr>
</thead><tbody>";

while ($row = $result->fetch_assoc()) {
    $formattedDate = date('F j, Y', strtotime($row['date']));
    $statusColor = $row['status'] === 'Pending' ? 'orange' : 'green';
    $html .= "<tr>
      <td>{$row['tracking_id']}</td>
      <td>{$row['type']}</td>
      <td>{$row['region_name']}</td>
      <td>{$row['district_name']}</td>
      <td>{$row['chiefdom_name']}</td>
      <td>{$row['location']}</td>
      <td>{$formattedDate}</td>
      <td style='color: {$statusColor};'>{$row['status']}</td>
    </tr>";
}

$html .= "</tbody></table>";

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("test.pdf", ["Attachment" => false]);
exit;
