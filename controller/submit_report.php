<?php
require_once '../config/db.php';
require_once '../model/ReportModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target     = $_POST['target'];
    $region     = $_POST['region'];
    $district   = $_POST['district'];
    $chiefdom   = $_POST['chiefdom'];
    $type       = $_POST['type'];
    $location   = $_POST['location'];
    $date       = $_POST['date'];

    // ✅ Check for future date
    if (strtotime($date) > time()) {
        header("Location: ../view/report.php?error=future_date");
        exit();
    }

    $description = $_POST['description'];
    $contact     = $_POST['contact'];
    $timestamp   = date('Y-m-d H:i:s');
    $status      = 'Pending';
    $tracking_id = 'CITI-' . strtoupper(uniqid());

    // ✅ Handle file upload
    $evidence_url = '';
    if (isset($_FILES['evidence']) && $_FILES['evidence']['error'] === UPLOAD_ERR_OK) {
        $targetDir = '../uploads/';
        if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

        $fileName   = time() . '_' . basename($_FILES['evidence']['name']);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['evidence']['tmp_name'], $targetFile)) {
            $evidence_url = $targetFile;
        } else {
            // Optional: redirect with file error
            // header("Location: ../view/report.php?error=file_upload");
            // exit();
            $evidence_url = '';
        }
    }

    // ✅ Insert report into the database
    $stmt = $conn->prepare("
        INSERT INTO reports (
            tracking_id, target, region, district, chiefdom,
            type, location, date, description, contact,
            evidence, status, timestamp
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssiiissssssss",
        $tracking_id, $target, $region, $district, $chiefdom,
        $type, $location, $date, $description, $contact,
        $evidence_url, $status, $timestamp
    );

    // 💾 Execute and redirect
    if ($stmt->execute()) {
        header("Location: ../view/thank_you.php?id=$tracking_id");
        exit;
    } else {
        echo "❌ Error saving report: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    echo "⛔ Invalid request method.";
}
?>
