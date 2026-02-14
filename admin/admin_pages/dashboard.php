<?php
// Database connection
$host = 'localhost';
$dbname = 'makorokocho_hotel';
$dbuser = 'root';
$dbpass = '';

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}

// 1. Pending bookings count (status = 'Pending')
$pendingCount = 0;
$res = $conn->query("SELECT COUNT(*) AS total FROM bookings WHERE status = 'Pending'");
if ($res) {
    $row = $res->fetch_assoc();
    $pendingCount = $row['total'] ?? 0;
    $res->free();
}

// 2. Recent messages from contacts table
$recentMessages = [];
$res = $conn->query("SELECT full_name, email, message, created_at FROM contacts ORDER BY created_at DESC LIMIT 5");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $recentMessages[] = $row;
    }
    $res->free();
}

// 3. Room availability (adjust if you have rooms table and is_available column)
$availableRooms = 0;
$totalRooms = 0;
$res = $conn->query("SELECT COUNT(*) AS total, SUM(is_available) AS available FROM rooms");
if ($res) {
    $row = $res->fetch_assoc();
    $totalRooms = $row['total'] ?? 0;
    $availableRooms = $row['available'] ?? 0;
    $res->free();
}

// 4. Revenue summary (assuming total_amount column exists and status 'Confirmed')
$totalRevenue = 0.0;
$res = $conn->query("SELECT SUM(total_amount) AS revenue FROM bookings WHERE status = 'Confirmed'");
if ($res) {
    $row = $res->fetch_assoc();
    $totalRevenue = $row['revenue'] ?? 0;
    $res->free();
}

$conn->close();
?>

<!-- HTML output unchanged except for variable names fixed -->
<h2>Dashboard Overview</h2>

<div style="display: flex; gap: 30px; flex-wrap: wrap;">

  <div style="flex: 1 1 200px; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
    <h3>Pending Bookings</h3>
    <p style="font-size: 2em; font-weight: bold; color: #ff6600;"><?= htmlspecialchars($pendingCount) ?></p>
  </div>

  <div style="flex: 2 1 400px; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
    <h3>Recent Messages</h3>
    <?php if (count($recentMessages) > 0): ?>
      <ul style="list-style: none; padding-left: 0;">
        <?php foreach ($recentMessages as $msg): ?>
          <li style="margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 8px;">
            <strong><?= htmlspecialchars($msg['full_name']) ?> (<?= htmlspecialchars($msg['email']) ?>)</strong><br />
            <em><?= htmlspecialchars(substr($msg['message'], 0, 80)) ?><?= strlen($msg['message']) > 80 ? '...' : '' ?></em><br />
            <small><i><?= htmlspecialchars($msg['created_at']) ?></i></small>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>No recent messages.</p>
    <?php endif; ?>
  </div>

  <div style="flex: 1 1 200px; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
    <h3>Room Availability</h3>
    <p>Total Rooms: <strong><?= htmlspecialchars($totalRooms) ?></strong></p>
    <p>Available Rooms: <strong><?= htmlspecialchars($availableRooms) ?></strong></p>
    <p>Occupied Rooms: <strong><?= htmlspecialchars($totalRooms - $availableRooms) ?></strong></p>
  </div>

  <div style="flex: 1 1 200px; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
    <h3>Revenue Summary</h3>
    <p>Total Confirmed Revenue:</p>
    <p style="font-size: 1.8em; font-weight: bold; color: green;">$<?= number_format($totalRevenue, 2) ?></p>
  </div>

</div>
