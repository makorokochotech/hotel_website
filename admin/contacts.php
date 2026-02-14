<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// DB connection
$host = 'localhost';
$dbname = 'makorokocho_hotel';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM contacts ORDER BY id DESC");
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("DB Error: " . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Contacts - Makorokocho Hotel</title>
  <link rel="stylesheet" href="admin.css" />
</head>
<body>

  <h1>Manage Contact Messages</h1>
  <a href="index.php">Back to Dashboard</a>

  <table border="1" cellpadding="5" cellspacing="0">
    <thead>
      <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Message</th>
        <th>Received At</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($contacts): ?>
        <?php foreach ($contacts as $contact): ?>
          <tr>
            <td><?= htmlspecialchars($contact['id']) ?></td>
            <td><?= htmlspecialchars($contact['full_name']) ?></td>
            <td><?= htmlspecialchars($contact['email']) ?></td>
            <td><?= htmlspecialchars($contact['phone']) ?></td>
            <td><?= nl2br(htmlspecialchars($contact['message'])) ?></td>
            <td><?= htmlspecialchars($contact['created_at']) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="6">No contact messages found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

</body>
</html>
