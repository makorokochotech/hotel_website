<?php
session_start();

$host = 'localhost';
$dbname = 'makorokocho_hotel';
$username = 'root';
$password = '';
$error = '';

// Connect to database
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);    

    // Prepare and execute
    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $admin = $result->fetch_assoc();

        // Direct password comparison
        if ($pass === $admin['password']) {
            // Regenerate the session for safety
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];

            header("Location: index.php");

            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Username not found.";
    }

    // Redirect back with error
    header("Location: admin_login.html?error=" . urlencode($error));

    exit;

}

$stmt->close();
$conn->close();

?>
