<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FriedrichOsDev</title>
    <link rel="stylesheet" href="dashboard.css">
</head>

<body>
    <header class="header">
        <p>Admin Dashboard</p>
        <div>
            <a class="button-link" href="index.php">Home</a>
            <a class="button-link" href="projects.html">Projects</a>
            <a class="button-link" href="monitor.php">Monitor</a>
            <a class="button-link" href="contact.html">Contact</a>
            <a class="button-link header-link-active header-link-last" href="login.php">Dashboard</a>
        </div>
    </header>
    <main>
        <section class="dashboard-section">
            <p>This should only be visible to admins!</p>
        </section>
    </main>
    <footer class="footer">
        <p>&copy; 2026 FriedrichOsDev. All rights reserved.</p>
    </footer>
    <script src="script.js"></script>
</body>

</html>