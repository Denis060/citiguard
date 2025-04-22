<?php
require_once '../config/db.php';

if (isset($_GET['district'])) {
    $districtName = $_GET['district'];

    // Get district ID
    $stmt = $conn->prepare("SELECT id FROM districts WHERE name = ? LIMIT 1");
    $stmt->bind_param("s", $districtName);
    $stmt->execute();
    $result = $stmt->get_result();
    $district = $result->fetch_assoc();

    if ($district) {
        $district_id = $district['id'];
        $stmt = $conn->prepare("SELECT name FROM chiefdoms WHERE district_id = ? ORDER BY name ASC");
        $stmt->bind_param("i", $district_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $chiefdoms = [];
        while ($row = $result->fetch_assoc()) {
            $chiefdoms[] = $row;
        }

        echo json_encode($chiefdoms);
    }
}
?>
