<?php
// admin/controller/delete_admin.php

session_start();

// ✅ 1. Role Check — Only Super Admin can delete
if (!isset($_SESSION['admin_role']) || $_SESSION['admin_role'] !== 'super') {
    header("Location: ../no_access.php");
    exit();
}

// ✅ 2. Input Validation
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../users.php?error=invalid");
    exit();
}

$adminIdToDelete = intval($_GET['id']);
$yourId = $_SESSION['admin_id'];

require_once '../../config/db.php';

// ✅ 3. Prevent self-deletion
if ($adminIdToDelete == $yourId) {
    header("Location: ../users.php?error=self-delete");
    exit();
}

// ✅ 4. Check role of the target admin
$stmt = $conn->prepare("SELECT role FROM admins WHERE id = ?");
$stmt->bind_param("i", $adminIdToDelete);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: ../users.php?error=notfound");
    exit();
}

$row = $result->fetch_assoc();
$targetRole = $row['role'];

if ($targetRole === 'super') {
    header("Location: ../users.php?error=super-protected");
    exit();
}

// ✅ 5. Proceed to delete
$deleteStmt = $conn->prepare("DELETE FROM admins WHERE id = ?");
$deleteStmt->bind_param("i", $adminIdToDelete);
$deleteStmt->execute();

header("Location: ../users.php?success=deleted");
exit();
