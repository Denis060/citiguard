<?php
require_once '../../config/db.php';

// Collect filters
$type      = $_GET['type'] ?? '';
$location  = $_GET['location'] ?? '';
$from_date = $_GET['from_date'] ?? '';
$to_date   = $_GET['to_date'] ?? '';

$conditions = ["deleted = 0"];
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

$sql = "SELECT tracking_id, type, location, date, status FROM reports";
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}
$sql .= " ORDER BY date DESC";

// Execute query
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Set headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=filtered_reports.csv');

// Write to output
$output = fopen('php://output', 'w');
fputcsv($output, ['Tracking ID', 'Type', 'Location', 'Date', 'Status']);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['tracking_id'],
        $row['type'],
        $row['location'],
        $row['date'],
        $row['status']
    ]);
}

fclose($output);
exit;
?>
