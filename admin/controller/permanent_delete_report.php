<?php
// controller/permanent_delete_report.php

session_start();

// ✅ Only super admins can permanently delete reports
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] !== 'super') {
    header('Location: ../login.php');
    exit();
}

require_once '../../config/db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $report_id = intval($_GET['id']);

    // Permanently delete the report
    $stmt = $conn->prepare("DELETE FROM reports WHERE id = ?");
    $stmt->bind_param("i", $report_id);

    if ($stmt->execute()) {
        // 📝 Log the action
        $admin_email = $_SESSION['admin_email'];
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
        $action = "Permanently deleted report ID $report_id";

        $log_stmt = $conn->prepare("INSERT INTO logs (admin_email, action, ip_address, user_agent) VALUES (?, ?, ?, ?)");
        $log_stmt->bind_param("ssss", $admin_email, $action, $ip, $agent);
        $log_stmt->execute();

        header("Location: ../deleted_reports.php");
        exit();
    } else {
        echo "❌ Failed to permanently delete the report.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "⚠️ Invalid report ID.";
}
?>
