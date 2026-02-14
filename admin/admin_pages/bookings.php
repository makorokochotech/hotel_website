<?php


// Redirect if not logged in as admin
if (empty($_SESSION['admin_logged_in'])) {
    header("Location: ../admin_login.html");
    exit;
}

$host = 'localhost';
$dbname = 'makorokocho_hotel';
$dbuser = 'root';
$dbpass = '';

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}

// Since your bookings table doesn't have status yet, commenting out update/delete logic for now
/*
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_status'], $_POST['booking_id'])) {
        // You need to add 'status' column in bookings table for this to work
    } elseif (isset($_POST['delete_id'])) {
        // You can enable deletion if you want:
        $delete_id = (int)$_POST['delete_id'];
        $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
        $stmt->bind_param('i', $delete_id);
        $stmt->execute();
        $stmt->close();
        $msg = "Booking #$delete_id deleted.";
    }
}
*/

// Fetch all bookings
$sql = "SELECT id, full_name, email, phone, room_type, check_in, check_out, guests, booking_date FROM bookings ORDER BY booking_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Manage Bookings - Admin Dashboard</title>
<link rel="stylesheet" href="css/booking.css" />
</head>
<body>
<h2>Manage Bookings</h2>

<?php if (!empty($msg)): ?>
    <p style="color: green;"><?= htmlspecialchars($msg) ?></p>
<?php endif; ?>

<?php if ($result && $result->num_rows > 0): ?>
<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Room Type</th>
            <th>Check-In</th>
            <th>Check-Out</th>
            <th>Guests</th>
            <th>Booking Date</th>
            <th>Actions</th> <!-- For future use like delete -->
        </tr>
    </thead>
    <tbody>
    <?php while ($booking = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($booking['id']) ?></td>
            <td><?= htmlspecialchars($booking['full_name']) ?></td>
            <td><?= htmlspecialchars($booking['email']) ?></td>
            <td><?= htmlspecialchars($booking['phone']) ?></td>
            <td><?= htmlspecialchars($booking['room_type']) ?></td>
            <td><?= htmlspecialchars($booking['check_in']) ?></td>
            <td><?= htmlspecialchars($booking['check_out']) ?></td>
            <td><?= htmlspecialchars($booking['guests']) ?></td>
            <td><?= htmlspecialchars($booking['booking_date']) ?></td>
            <td>
                <!-- You can add actions like delete here if you want -->
                <!--
                <form method="POST" onsubmit="return confirm('Delete booking #<?= $booking['id'] ?>?');" style="margin:0;">
                    <input type="hidden" name="delete_id" value="<?= $booking['id'] ?>">
                    <button type="submit" style="background: red; color: white; border:none; padding: 4px 8px; cursor:pointer;">Delete</button>
                </form>
                -->
                N/A
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
<p>No bookings found.</p>
<?php endif; ?>

<p><a href="../index.php">Back to Dashboard</a></p>
</body>
</html>

<?php $conn->close(); ?>
