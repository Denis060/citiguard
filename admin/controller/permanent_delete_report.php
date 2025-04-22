<?php
// controller/permanent_delete_report.php

session_start();

// ✅ Only super admin can permanently delete
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] !== 'super') {
    header('Location: ../login.php');
    exit();
}

require_once '../../config/db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $report_id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM reports WHERE id = ?");
    $stmt->bind_param("i", $report_id);

    if ($stmt->execute()) {
        header("Location: ../deleted_reports.php");
        exit();
    } else {
        echo "❌ Failed to delete report.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "⚠️ Invalid report ID.";
}
?>
