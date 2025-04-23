<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] !== 'super') {
    header("Location: ../login.php");
    exit();
}

require_once '../../config/db.php';

// Optional search filtering
$search = $_GET['search'] ?? '';
$query = "SELECT admin_email, action, ip_address, user_agent, created_at FROM logs";
if (!empty($search)) {
    $safeSearch = $conn->real_escape_string($search);
    $query .= " WHERE admin_email LIKE '%$safeSearch%' OR action LIKE '%$safeSearch%'";
}
$query .= " ORDER BY created_at DESC";

$result = $conn->query($query);

// Set headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="audit_logs.csv"');

$output = fopen('php://output', 'w');

// CSV header row
fputcsv($output, ['Admin Email', 'Action', 'IP Address', 'Device', 'Timestamp']);

// CSV data rows
while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['admin_email'],
        $row['action'],
        $row['ip_address'],
        $row['user_agent'],
        date('d M Y, g:i a', strtotime($row['created_at']))
    ]);
}

fclose($output);
exit;
