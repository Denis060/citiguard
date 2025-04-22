<?php
session_start();

// Super Admin only
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] !== 'super') {
    http_response_code(403);
    echo "Unauthorized";
    exit();
}

require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $newRole = $_POST['role'] ?? null;

    if (!$id || !is_numeric($id)) {
        http_response_code(400);
        echo "Invalid ID";
        exit();
    }

    // Prevent self-editing
    if ($_SESSION['admin_id'] == $id) {
        http_response_code(403);
        echo "Cannot change your own role";
        exit();
    }

    // Only accept valid roles
    if (!in_array($newRole, ['admin', 'moderator'])) {
        http_response_code(400);
        echo "Invalid role";
        exit();
    }

    // Prevent downgrading super admin
    $check = $conn->prepare("SELECT role FROM admins WHERE id = ?");
    $check->bind_param("i", $id);
    $check->execute();
    $result = $check->get_result();
    $user = $result->fetch_assoc();

    if (!$user || $user['role'] === 'super') {
        http_response_code(403);
        echo "Cannot change this admin";
        exit();
    }

    // Perform update
    $update = $conn->prepare("UPDATE admins SET role = ? WHERE id = ?");
    $update->bind_param("si", $newRole, $id);
    $update->execute();

    echo "Role updated successfully";
} else {
    http_response_code(405);
    echo "Method Not Allowed";
}
