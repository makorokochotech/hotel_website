<?php
// Database connection info
$host = 'localhost';
$dbname = 'makorokocho_hotel';
$dbuser = 'root';
$dbpass = '';

// Connect to DB
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}

// Get total bookings count
$bookingsCount = 0;
$result = $conn->query("SELECT COUNT(*) as total FROM bookings");
if ($result) {
    $row = $result->fetch_assoc();
    $bookingsCount = $row['total'] ?? 0;
    $result->free();
}

// Get total messages count
$messagesCount = 0;
$result = $conn->query("SELECT COUNT(*) as total FROM contacts");
if ($result) {
    $row = $result->fetch_assoc();
    $messagesCount = $row['total'] ?? 0;
    $result->free();
}

// Get bookings grouped by status
$bookingsByStatus = [];
$result = $conn->query("SELECT status, COUNT(*) as count FROM bookings GROUP BY status");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $bookingsByStatus[$row['status']] = $row['count'];
    }
    $result->free();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Admin Reports - Makorokocho Hotel</title>
<link rel="stylesheet" href="css/reports.css" />
</head>
<body>

<h2>Admin Reports</h2>

<div class="summary">
    <p><strong>Total Bookings:</strong> <?= htmlspecialchars($bookingsCount) ?></p>
    <p><strong>Total Messages:</strong> <?= htmlspecialchars($messagesCount) ?></p>
</div>

<h3>Bookings by Status</h3>

<?php if (!empty($bookingsByStatus)) : ?>
<table class="report-table">
    <thead>
        <tr>
            <th>Status</th>
            <th>Number of Bookings</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($bookingsByStatus as $status => $count): ?>
        <tr>
            <td><?= htmlspecialchars($status) ?></td>
            <td><?= htmlspecialchars($count) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p>No booking status data available.</p>
<?php endif; ?>

</body>
</html>
