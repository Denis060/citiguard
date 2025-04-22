<?php
require_once '../../config/db.php';

header('Content-Type: application/json');

$query = "
  SELECT 
    MONTHNAME(date) AS month, 
    COUNT(*) AS total 
  FROM reports 
  WHERE deleted = 0
  GROUP BY MONTH(date)
  ORDER BY MONTH(date)
";

$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data['months'][] = $row['month'];
    $data['totals'][] = (int)$row['total'];
}

echo json_encode($data);
?>
