<?php
session_start();

// Redirect if not logged in
if (empty($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.html");
    exit;
}

// Logout handler
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: admin_login.html");
    exit;
}

$page = $_GET['page'] ?? 'dashboard';

$allowed_pages = ['dashboard', 'bookings', 'messages', 'rooms', 'reports'];

if (!in_array($page, $allowed_pages)) {
    $page = 'dashboard';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard - Makorokocho Hotel</title>
  <link rel="stylesheet" href="css/index.css" />
</head>
<body>
  <header>
    <h1>Welcome, <?= htmlspecialchars($_SESSION['admin_username']) ?>!</h1>
    <nav>
      <a href="?page=dashboard">Dashboard</a> |
      <a href="?page=bookings">Manage Bookings</a> |
      <a href="?page=messages">Manage Messages</a> |
      <a href="?page=rooms">Manage Rooms</a> |
      <a href="?page=reports">Reports</a> |
      <a href="?action=logout" class="logout">Logout</a>
    </nav>
  </header>

  <main>
    <?php
    switch ($page) {
        case 'bookings':
            include __DIR__ . '/admin_pages/bookings.php';
            break;
        case 'messages':
            include __DIR__ . '/admin_pages/messages.php';
            break;
        case 'rooms':
            include __DIR__ . '/admin_pages/rooms.php';
            break;
        case 'reports':
            include __DIR__ . '/admin_pages/reports.php';
            break;
        case 'dashboard':
        default:
            include __DIR__ . '/admin_pages/dashboard.php';
            break;
    }
    ?>
  </main>

  <footer>
    <p style="text-align:center; padding: 15px; background:#f4f4f4; margin-top: 40px;">
      &copy; <?= date('Y') ?> Makorokocho Hotel. All rights reserved.
    </p>
  </footer>
</body>
</html>
