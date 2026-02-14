<?php
// booking.php

// Database connection parameters — adjust as needed
$host = 'localhost';
$dbname = 'makorokocho_hotel';
$user = 'root';
$pass = '';


// Connect to database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage()); 
}

// Sanitization
function clean_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize
    $full_name = clean_input($_POST['full_name'] ?? '');
    $email = clean_input($_POST['email'] ?? '');
    $phone = clean_input($_POST['phone'] ?? '');
    $room_type = clean_input($_POST['room_type'] ?? '');
    $check_in = $_POST['check_in'] ?? '';
    $check_out = $_POST['check_out'] ?? '';
    $guests = (int)($_POST['guests'] ?? 0);

    // Validation
    $errors = [];

    if (empty($full_name)) $errors[] = 'Full Name is required';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid Email is required';
    if (empty($phone)) $errors[] = 'Phone is required';
    $valid_rooms = ['standard', 'deluxe', 'suite'];
    if (!in_array($room_type, $valid_rooms)) $errors[] = 'Please select a valid room';
    if (!$check_in) $errors[] = 'Check-in Date is required';
    if (!$check_out) $errors[] = 'Check-out Date is required';
    if ($check_in >= $check_out) $errors[] = 'Check-out must be after Check-in';
    if ($guests < 1 || $guests > 10) $errors[] = 'Guests must be between 1 and 10';

    if (empty($errors)) {
        // Insert booking into database
        $stmt = $pdo->prepare("INSERT INTO bookings (full_name, email, phone, room_type, check_in, check_out, guests) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $success = $stmt->execute([$full_name, $email, $phone, $room_type, $check_in, $check_out, $guests]);

        if ($success) {
            ?>
            <script>
                alert("Thank you! Your booking has been successfully made.");
                window.location.href = "index.html";
            </script>
            <?php
        } else {
            ?>
            <script>
                alert("Sorry, there was a problem processing your booking. Please try again.");
                window.location.href = "booking.html";
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            alert("The following errors occurred:\n- <?= implode('\n- ', $errors) ?>");
            window.location.href = "booking.html";
        </script>
        <?php
    }
} else {
    header('Location: booking.html');
    exit;
}
?>
