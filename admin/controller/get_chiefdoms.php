<?php
require_once '../config/db.php';

$district_id = $_GET['district_id'] ?? '';
if (!empty($district_id)) {
    $stmt = $conn->prepare("SELECT id, name FROM chiefdoms WHERE district_id = ?");
    $stmt->bind_param('s', $district_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $chiefdoms = [];
    while ($row = $result->fetch_assoc()) {
        $chiefdoms[] = $row;
    }
    echo json_encode($chiefdoms);
}
