<?php
require_once '../../config/db.php';

header('Content-Type: application/json');

if (isset($_GET['region']) && !empty($_GET['region'])) {
    $regionName = $_GET['region'];

    // 🧠 Get the region ID based on name
    $stmt = $conn->prepare("SELECT id FROM regions WHERE name = ? LIMIT 1");
    $stmt->bind_param("s", $regionName);
    $stmt->execute();
    $result = $stmt->get_result();
    $region = $result->fetch_assoc();

    if ($region) {
        $region_id = $region['id'];

        // 📦 Fetch districts for that region ID
        $stmt = $conn->prepare("SELECT id, name FROM districts WHERE region_id = ? ORDER BY name ASC");
        $stmt->bind_param("i", $region_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $districts = [];
        while ($row = $result->fetch_assoc()) {
            $districts[] = $row;
        }

        echo json_encode($districts);
        exit;
    }
}

// Return empty array if no match
echo json_encode([]);
?>
