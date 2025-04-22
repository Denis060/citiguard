<?php
// admin/controller/delete_report.php

session_start();
require_once '../../config/db.php';

// 🔐 Only logged-in Admins or Super Admins can delete reports
if (!isset($_SESSION['admin_logged_in']) || !in_array($_SESSION['admin_role'], ['admin', 'super'])) {
    header("Location: ../no_access.php");
    exit();
}

// ✅ Validate Report ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../reports.php?error=invalid_id");
    exit();
}

$report_id = intval($_GET['id']);

// ✅ Soft Delete: Mark report as deleted
$stmt = $conn->prepare("UPDATE reports SET deleted = 1 WHERE id = ?");
$stmt->bind_param("i", $report_id);
$deleted = $stmt->execute();
$stmt->close();

// 🧾 Audit Logging
if ($deleted) {
    $admin_email = $_SESSION['admin_email'];
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    $action = "Soft-deleted report ID $report_id";

    $log_stmt = $conn->prepare("INSERT INTO logs (admin_email, action, ip_address, user_agent) VALUES (?, ?, ?, ?)");
    $log_stmt->bind_param("ssss", $admin_email, $action, $ip, $agent);
    $log_stmt->execute();
    $log_stmt->close();

    header("Location: ../reports.php?success=deleted");
    exit();
} else {
    header("Location: ../reports.php?error=delete_failed");
    exit();
}
?>
