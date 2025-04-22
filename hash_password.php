<?php
$password = "Denis55522"; // 🔒 This is the password you want to use to log in
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Hashed Password: " . $hash;
?>
