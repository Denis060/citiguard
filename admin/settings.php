<?php
session_start();

// 🔐 Only Super Admins can access
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] !== 'super') {
    header("Location: login.php");
    exit();
}

require_once '../config/db.php';

// Define database connection variables
$db_user = $db_user ?? 'root'; // Replace with your actual database username
$db_pass = $db_pass ?? 'Denis55522';    // Replace with your actual database password
$db_host = $db_host ?? 'localhost'; // Replace with your actual database host
$db_name = $db_name ?? 'citiguard'; // Replace with your actual database name

$success = '';
$error = '';

// Handle Backup
if (isset($_POST['backup'])) {
    $backupFile = '../uploads/db_backup_' . date('Y-m-d_H-i-s') . '.sql';
    $command = "mysqldump --user={$db_user} --password={$db_pass} --host={$db_host} {$db_name} > {$backupFile}";
    exec($command, $output, $result);
    if ($result === 0) {
        $success = "Database backup created successfully: " . basename($backupFile);
    } else {
        $error = "Failed to create database backup.";
    }
}

// Handle Restore
if (isset($_POST['restore']) && isset($_FILES['backup_file'])) {
    $backupFile = $_FILES['backup_file']['tmp_name'];
    $command = "mysql --user={$db_user} --password={$db_pass} --host={$db_host} {$db_name} < {$backupFile}";
    exec($command, $output, $result);
    if ($result === 0) {
        $success = "Database restored successfully.";
    } else {
        $error = "Failed to restore database.";
    }
}
?>

<?php include 'includes/admin_header.php'; ?>
<div class="admin-container">
  <?php include 'includes/sidebar.php'; ?>

  <main class="dashboard">
    <h1>System Settings</h1>

    <?php if ($success): ?>
      <div class="alert success"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
      <div class="alert danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Backup Section -->
    <section>
      <h2>Backup Database</h2>
      <form method="post" action="">
        <button type="submit" name="backup" class="btn btn-primary">Create Backup</button>
      </form>
    </section>

    <!-- Restore Section -->
    <section>
      <h2>Restore Database</h2>
      <form method="post" action="" enctype="multipart/form-data">
        <div class="form-group">
          <label>Upload Backup File:</label>
          <input type="file" name="backup_file" class="form-control" required>
        </div>
        <button type="submit" name="restore" class="btn btn-primary">Restore Database</button>
      </form>
    </section>

    <!-- System Information -->
    <section>
      <h2>System Information</h2>
      <table class="admin-table">
        <tr>
          <th>Application Version</th>
          <td>1.0.0</td>
        </tr>
        <tr>
          <th>Server Software</th>
          <td><?= htmlspecialchars($_SERVER['SERVER_SOFTWARE']) ?></td>
        </tr>
        <tr>
          <th>PHP Version</th>
          <td><?= htmlspecialchars(phpversion()) ?></td>
        </tr>
        <tr>
          <th>Database Status</th>
          <td><?= $conn->ping() ? 'Connected' : 'Disconnected' ?></td>
        </tr>
      </table>
    </section>
  </main>
</div>
<?php include 'includes/admin_footer.php'; ?>