<?php
require_once '../../config/db.php';  // Adjust this path if needed

header('Content-Type: application/json');

$sql = "SELECT type, COUNT(*) as count FROM reports WHERE deleted = 0 GROUP BY type";
$result = $conn->query($sql);

$types = [];
$counts = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $types[] = $row['type'];
        $counts[] = (int)$row['count'];
    }
}

echo json_encode(['types' => $types, 'counts' => $counts]);
exit;
?>
