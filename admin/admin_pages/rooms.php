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

// Handle Add Room
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_room'])) {
    $room_number = $conn->real_escape_string($_POST['room_number']);
    $room_type = $conn->real_escape_string($_POST['room_type']);
    $price = floatval($_POST['price']);
    $description = $conn->real_escape_string($_POST['description']);
    $is_available = isset($_POST['is_available']) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO rooms (room_number, room_type, price, description, is_available) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('ssdsi', $room_number, $room_type, $price, $description, $is_available);
    $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle Delete Room
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM rooms WHERE id = ?");
    $stmt->bind_param('i', $delete_id);
    $stmt->execute();
    $stmt->close();

    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

// Handle Toggle Availability
if (isset($_GET['toggle_id'])) {
    $toggle_id = intval($_GET['toggle_id']);
    // Get current availability
    $stmt = $conn->prepare("SELECT is_available FROM rooms WHERE id = ?");
    $stmt->bind_param('i', $toggle_id);
    $stmt->execute();
    $stmt->bind_result($current_avail);
    $stmt->fetch();
    $stmt->close();

    // Toggle
    $new_avail = $current_avail ? 0 : 1;

    // Update availability
    $stmt = $conn->prepare("UPDATE rooms SET is_available = ? WHERE id = ?");
    $stmt->bind_param('ii', $new_avail, $toggle_id);
    $stmt->execute();
    $stmt->close();

    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

// Fetch all rooms
$stmt = $conn->prepare("SELECT * FROM rooms ORDER BY room_number ASC");
$stmt->execute();
$rooms = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Rooms List - Makorokocho Hotel</title>
<link rel="stylesheet" href="css/rooms.css" />
</head>
<body>

<h2>Hotel Rooms List</h2>

 <!-- Add Room Form -->
<section class="add-room-form">
  <h3>Add New Room</h3>
  <form method="POST" action="">
    <label>
      Room Number:
      <input type="text" name="room_number" required />
    </label>

    <label>
      Room Type:
      <select name="room_type" required>
        <option value="">-- Select Room Type --</option>
        <option value="Standard">Standard</option>
        <option value="Deluxe Suite">Deluxe Suite</option>
        <option value="Suite">Suite</option>
      </select>
    </label>

    <label>
      Price (USD):
      <input type="number" step="0.01" name="price" required />
    </label>

    <label>
      Description:
      <textarea name="description" rows="2"></textarea>
    </label>

    <label>
      Available:
      <input type="checkbox" name="is_available" checked />
    </label>

    <button type="submit" name="add_room">Add Room</button>
  </form>
</section>

<?php if (!empty($rooms)) : ?>
<table>
    <thead>
        <tr>
            <th>Room Number</th>
            <th>Type</th>
            <th>Price (USD)</th>
            <th>Description</th>
            <th>Availability</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rooms as $room) : ?>
        <tr>
            <td data-label="Room Number"><?= htmlspecialchars($room['room_number']) ?> </td>
            <td data-label="Type"><?= htmlspecialchars(ucfirst($room['room_type'])) ?> </td>
            <td data-label="Price (USD)"><?= number_format($room['price'], 2) ?> </td>
            <td data-label="Description"><?= htmlspecialchars($room['description']) ?> </td>
            <td data-label="Availability" class="<?= $room['is_available'] ? 'available' : 'not-available' ?>">
                <a href="?toggle_id=<?= $room['id'] ?>" class="toggle-availability" title="Click to toggle availability">
                    <?= $room['is_available'] ? 'Available' : 'Not Available' ?>
                </a>
            </td>
            <td data-label="Actions">
                <a href="?delete_id=<?= $room['id'] ?>" onclick="return confirm('Are you sure you want to delete this room?');" class="delete-btn">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p>No rooms found in the system.</p>
<?php endif; ?>
</body>
</html>
