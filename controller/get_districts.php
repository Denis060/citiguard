<?php
require_once '../config/db.php';

if (isset($_GET['region_id']) && is_numeric($_GET['region_id'])) {
    $region_id = intval($_GET['region_id']);
    $stmt = $conn->prepare("SELECT id, name FROM districts WHERE region_id = ? ORDER BY name ASC");
    $stmt->bind_param("i", $region_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $districts = [];
    while ($row = $result->fetch_assoc()) {
        $districts[] = $row;
    }

    echo json_encode($districts);
} else {
    echo json_encode([]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $district_name = $_POST['district']; // Assuming 'district' is the name from the form
    $stmt = $conn->prepare("SELECT id FROM districts WHERE name = ?");
    $stmt->bind_param("s", $district_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $district = $result->fetch_assoc()['id'];

    // Use $district (the id) in the insert query
    $stmt = $conn->prepare("INSERT INTO reports (district, ...) VALUES (?, ...)");
    $stmt->bind_param("i", $district);
    // Add code to bind other parameters and execute the statement
}
?>
