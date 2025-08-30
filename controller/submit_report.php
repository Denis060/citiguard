<?php
require_once '../config/db.php';
require_once '../model/ReportModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF token check
    session_start();
    if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('Invalid CSRF token. Please reload the form and try again.');
    }
    // File size error feedback
    $file_error = '';
    // Validate and sanitize all input
    $type       = isset($_POST['type']) && preg_match('/^[\w\s-]+$/', $_POST['type']) ? trim($_POST['type']) : '';
    $region     = isset($_POST['region']) && ctype_digit($_POST['region']) ? $_POST['region'] : '';
    $district_name   = isset($_POST['district']) && preg_match('/^[\w\s-]+$/', $_POST['district']) ? trim($_POST['district']) : '';
    $chiefdom   = isset($_POST['chiefdom']) && preg_match('/^[\w\s-]+$/', $_POST['chiefdom']) ? trim($_POST['chiefdom']) : '';
    $location   = isset($_POST['location']) && preg_match('/^[\w\s,-]+$/', $_POST['location']) ? trim($_POST['location']) : '';
    $date       = isset($_POST['date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['date']) ? $_POST['date'] : '';
    $description = isset($_POST['description']) ? htmlspecialchars(trim($_POST['description'])) : '';
    $target      = isset($_POST['target']) && preg_match('/^[\w\s-]+$/', $_POST['target']) ? trim($_POST['target']) : '';

    $tracking_id = "CITI-" . strtoupper(bin2hex(random_bytes(5)));

    $image  = $_FILES['evidence_image']['name'] ?? '';
    $audio  = $_FILES['evidence_audio']['name'] ?? '';
    $video  = $_FILES['evidence_video']['name'] ?? '';

    // Save uploaded files with validation
    $uploadDir = "../uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir);
    }

    // Validate and save image
    if (!empty($image)) {
        $allowed_types = ['image/png', 'image/jpeg', 'image/jpg'];
        $filesize = $_FILES['evidence_image']['size'];
        $tmp_name = $_FILES['evidence_image']['tmp_name'];
        $real_mime = mime_content_type($tmp_name);
        if ($filesize >= 4*1024*1024) {
            $file_error = 'Image file is too large (max 4MB).';
        } elseif (in_array($real_mime, $allowed_types)) {
            $safe_name = uniqid('img_', true) . '_' . basename($image);
            move_uploaded_file($tmp_name, $uploadDir . $safe_name);
            $image = $safe_name;
        } else {
            $image = '';
        }
    }
    // Validate and save audio
    if (!empty($audio)) {
        $allowed_types = ['audio/mpeg', 'audio/mp3', 'audio/wav'];
        $filesize = $_FILES['evidence_audio']['size'];
        $tmp_name = $_FILES['evidence_audio']['tmp_name'];
        $real_mime = mime_content_type($tmp_name);
        if ($filesize >= 10*1024*1024) {
            $file_error = 'Audio file is too large (max 10MB).';
        } elseif (in_array($real_mime, $allowed_types)) {
            $safe_name = uniqid('aud_', true) . '_' . basename($audio);
            move_uploaded_file($tmp_name, $uploadDir . $safe_name);
            $audio = $safe_name;
        } else {
            $audio = '';
        }
    }
    // Validate and save video
    if (!empty($video)) {
        $allowed_types = ['video/mp4', 'video/quicktime', 'video/x-msvideo'];
        $filesize = $_FILES['evidence_video']['size'];
        $tmp_name = $_FILES['evidence_video']['tmp_name'];
        $real_mime = mime_content_type($tmp_name);
        if ($filesize >= 40*1024*1024) {
            $file_error = 'Video file is too large (max 40MB).';
        } elseif (in_array($real_mime, $allowed_types)) {
            $safe_name = uniqid('vid_', true) . '_' . basename($video);
            move_uploaded_file($tmp_name, $uploadDir . $safe_name);
            $video = $safe_name;
        } else {
            $video = '';
        }
    }
    // TODO: Add CSRF token check for full protection

    // Fetch district ID
    $stmt = $conn->prepare("SELECT id FROM districts WHERE name = ?");
    $stmt->bind_param("s", $district_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $district = $result->fetch_assoc()['id'];

    // Fetch chiefdom ID
    $stmt = $conn->prepare("SELECT id FROM chiefdoms WHERE name = ?");
    $stmt->bind_param("s", $chiefdom);
    $stmt->execute();
    $result = $stmt->get_result();
    $chiefdom_id = $result->fetch_assoc()['id'];

    $stmt = $conn->prepare("
        INSERT INTO reports (tracking_id, type, region, district, chiefdom, location, date, description, target, evidence_image, evidence_audio, evidence_video)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("ssssssssssss", $tracking_id, $type, $region, $district, $chiefdom_id, $location, $date, $description, $target, $image, $audio, $video);

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
        if ($file_error) {
            header("Location: ../view/report.php?error=" . urlencode($file_error));
            exit();
        }
        echo "Something went wrong. Please try again.";
    }
}
?>
