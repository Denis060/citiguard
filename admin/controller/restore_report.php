<?php
// controller/restore_report.php

session_start();

// ✅ Only admins and super admins can restore
if (!isset($_SESSION['admin_logged_in']) || !in_array($_SESSION['admin_role'], ['admin', 'super'])) {
    header('Location: ../login.php');
    exit();
}

require_once '../../config/db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $report_id = intval($_GET['id']);

    $stmt = $conn->prepare("UPDATE reports SET deleted = 0, deleted_at = NULL WHERE id = ?");
    $stmt->bind_param("i", $report_id);

    if ($stmt->execute()) {
        // ✅ Log restore action
        $admin_email = $_SESSION['admin_email'];
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
        $action = "Restored report ID $report_id";

        $log_stmt = $conn->prepare("INSERT INTO logs (admin_email, action, ip_address, user_agent) VALUES (?, ?, ?, ?)");
        $log_stmt->bind_param("ssss", $admin_email, $action, $ip, $agent);
        $log_stmt->execute();
        $log_stmt->close();

        header("Location: ../deleted_reports.php?restored=success");
        exit();
    } else {
        echo "❌ Failed to restore report.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "⚠️ Invalid report ID.";
}
?>
