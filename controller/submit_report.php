<?php
require_once '../config/db.php';
require_once '../model/ReportModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type       = $_POST['type'];
    $region     = $_POST['region'];
    $district   = $_POST['district'];
    $chiefdom   = $_POST['chiefdom'];
    $location   = $_POST['location'];
    $date       = $_POST['date'];
    $description = $_POST['description'];

    $tracking_id = "CITI-" . strtoupper(bin2hex(random_bytes(5)));

    $image  = $_FILES['evidence_image']['name'] ?? '';
    $audio  = $_FILES['evidence_audio']['name'] ?? '';
    $video  = $_FILES['evidence_video']['name'] ?? '';

    // Save uploaded files
    $uploadDir = "../uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir);
    }

    if (!empty($image)) {
        move_uploaded_file($_FILES['evidence_image']['tmp_name'], $uploadDir . $image);
    }

    if (!empty($audio)) {
        move_uploaded_file($_FILES['evidence_audio']['tmp_name'], $uploadDir . $audio);
    }

    if (!empty($video)) {
        move_uploaded_file($_FILES['evidence_video']['tmp_name'], $uploadDir . $video);
    }

    $stmt = $conn->prepare("
        INSERT INTO reports (tracking_id, type, region, district, chiefdom, location, date, description, evidence_image, evidence_audio, evidence_video)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sssssssssss", $tracking_id, $type, $region, $district, $chiefdom, $location, $date, $description, $image, $audio, $video);

    if ($stmt->execute()) {
        $report_id = $conn->insert_id;

        // 🔔 Create notification
        $message = "New report submitted (Tracking ID: $tracking_id)";
        $insert_note = $conn->prepare("INSERT INTO notifications (type, report_id, message) VALUES (?, ?, ?)");
        $type_n = "new_report";
        $insert_note->bind_param("sis", $type_n, $report_id, $message);
        $insert_note->execute();

        header("Location: ../view/thank_you.php?id=$tracking_id");
        exit();
    } else {
        echo "Something went wrong. Please try again.";
    }
}
?>
