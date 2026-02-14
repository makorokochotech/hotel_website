<?php
// contact.php

// Database connection details
$host = 'localhost';
$dbname = 'makorokocho_hotel';
$username = 'root';
$password = '';

try {
    // Connect to the database using PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve and sanitize POST data
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Basic server-side validation
    $errors = [];

    if (!$full_name) {
        $errors[] = "Full name is required.";
    }
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    if (!$phone || !preg_match('/^[0-9]+$/', $phone)) {
        $errors[] = "Valid phone number is required (numbers only).";
    }
    if (!$message) {
        $errors[] = "Message cannot be empty.";
    }

    if (!empty($errors)) {
        // Display errors in JavaScript alert and go back to form
        echo "<script>alert('" . implode("\\n", $errors) . "'); window.history.back();</script>";
        exit;
    }

    // Insert data into database
    $stmt = $pdo->prepare("INSERT INTO contacts (full_name, email, phone, message) VALUES (?, ?, ?, ?)");
    $stmt->execute([$full_name, $email, $phone, $message]);

    // Success message and redirect back to homepage after a few seconds
    echo "<script>alert('Your message was successfully sent!'); setTimeout(function() { window.location.href = 'index.html'; }, 2000);</script>";

} catch (PDOException $e) {
    echo "<script>alert('Database error: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
    exit;
}
?>
