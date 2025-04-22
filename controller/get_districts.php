<?php
require_once '../config/db.php';

if (isset($_GET['region_id'])) {
    $region_id = intval($_GET['region_id']);
    $stmt = $conn->prepare("SELECT name FROM districts WHERE region_id = ? ORDER BY name ASC");
    $stmt->bind_param("i", $region_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $districts = [];
    while ($row = $result->fetch_assoc()) {
        $districts[] = $row;
    }

    echo json_encode($districts);
}
?>
