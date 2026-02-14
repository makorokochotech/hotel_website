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

    $stmt = $pdo->query("SELECT * FROM bookings ORDER BY id DESC");
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("DB Error: " . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Bookings - Makorokocho Hotel</title>
  <link rel="stylesheet" href="admin.css" />
</head>
<body>

  <h1>Manage Bookings</h1>
  <a href="index.php">Back to Dashboard</a>

  <table border="1" cellpadding="5" cellspacing="0">
    <thead>
      <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Room Type</th>
        <th>Check-in</th>
        <th>Check-out</th>
        <th>Guests</th>
        <th>Booking Date</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($bookings): ?>
        <?php foreach ($bookings as $booking): ?>
          <tr>
            <td><?= htmlspecialchars($booking['id']) ?></td>
            <td><?= htmlspecialchars($booking['full_name']) ?></td>
            <td><?= htmlspecialchars($booking['email']) ?></td>
            <td><?= htmlspecialchars($booking['phone']) ?></td>
            <td><?= htmlspecialchars($booking['room_type']) ?></td>
            <td><?= htmlspecialchars($booking['check_in']) ?></td>
            <td><?= htmlspecialchars($booking['check_out']) ?></td>
            <td><?= htmlspecialchars($booking['guests']) ?></td>
            <td><?= htmlspecialchars($booking['created_at']) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="9">No bookings found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

</body>
</html>
