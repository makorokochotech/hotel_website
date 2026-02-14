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

// Handle deleting a message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = (int)$_POST['delete_id'];
    $stmt = $conn->prepare("DELETE FROM contacts WHERE id = ?");
    $stmt->bind_param('i', $delete_id);
    $stmt->execute();
    $stmt->close();
    echo "<p style='color: green;'>Message #$delete_id deleted.</p>";
}

// Fetch all messages from contacts table
$sql = "SELECT id, full_name, email, phone, message, created_at FROM contacts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>User Messages - Admin Dashboard</title>
<link rel="stylesheet" href="css/messages.css" />
</head>
<body>
<h2>User Messages</h2>

<?php if ($result && $result->num_rows > 0): ?>
<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Message</th>
            <th>Received At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['full_name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
            <td><?= htmlspecialchars($row['created_at']) ?></td>
            <td>
                <form method="POST" onsubmit="return confirm('Delete message #<?= $row['id'] ?>?');">
                    <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                    <button type="submit" style="background: red; color: white; border:none; padding: 4px 8px; cursor:pointer;">Delete</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
<p>No messages found.</p>
<?php endif; ?>

<p><a href="../index.php">Back to Dashboard</a></p>

</body>
</html>

<?php
$conn->close();
?>
