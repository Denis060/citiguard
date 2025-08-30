<?php
// admin/auth.php

session_start();
require_once '../config/db.php'; // DB connection

// Get submitted credentials
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    $_SESSION['login_error'] = "Please enter both email and password.";
    header("Location: login.php");
    exit();
}

// Query admin from DB by email
$stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {
    $admin = $result->fetch_assoc();

    // ✅ Verify hashed password
    if (password_verify($password, $admin['password'])) {
        // ✅ Regenerate session ID for security
        session_regenerate_id(true);
        // ✅ Set session variables
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $admin['email'];
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_role'] = $admin['role']; // super | admin | moderator

        header("Location: index.php");
        exit();
    } else {
        $_SESSION['login_error'] = "Incorrect password.";
    }
} else {
    $_SESSION['login_error'] = "Admin not found.";
}

header("Location: login.php");
exit();
