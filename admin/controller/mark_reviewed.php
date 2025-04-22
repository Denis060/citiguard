<?php
// admin/controller/mark_reviewed.php

session_start();
require_once '../../config/db.php';

// ✅ Only allow logged-in admins with proper role
if (!isset($_SESSION['admin_logged_in']) || !in_array($_SESSION['admin_role'], ['admin', 'super'])) {
    header("Location: ../no_access.php");
    exit();
}

// ✅ Validate report ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "⚠️ Invalid report ID.";
    exit();
}

$report_id = intval($_GET['id']);
$admin_email = $_SESSION['admin_email'];
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

// ✅ 1. Update report status
$stmt = $conn->prepare("UPDATE reports SET status = 'Reviewed' WHERE id = ?");
$stmt->bind_param("i", $report_id);
$updated = $stmt->execute();
$stmt->close();

if ($updated) {
    // ✅ 2. Insert audit log
    $action = "Marked report ID $report_id as Reviewed";
    $log_stmt = $conn->prepare("INSERT INTO logs (admin_email, action, ip_address, user_agent) VALUES (?, ?, ?, ?)");
    $log_stmt->bind_param("ssss", $admin_email, $action, $ip, $agent);
    $log_stmt->execute();
    $log_stmt->close();

    header('Location: ../reports.php?success=reviewed');
    exit();
} else {
    echo "❌ Failed to update status.";
    exit();
}
?>
