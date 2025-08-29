<?php
require_once '../../config/db.php';

header('Content-Type: application/json');

$region_id = $_GET['region_id'] ?? '';
if (!empty($region_id)) {
    $stmt = $conn->prepare("SELECT id, name FROM districts WHERE region_id = ?");
    $stmt->bind_param('s', $region_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $districts = [];
    while ($row = $result->fetch_assoc()) {
        $districts[] = $row;
    }
    echo json_encode($districts);
    exit;
}

// Return empty array if no match
echo json_encode([]);
