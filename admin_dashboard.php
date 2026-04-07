<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

require_once('/var/www/db_config.php');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT ip, count, last_visit FROM visitors ORDER BY last_visit DESC");
    $visitors = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Datenbankverbindung fehlgeschlagen: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FriedrichOsDev - Admin</title>
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
            <div class="terminal-window admin-window">
                <div class="terminal-header">
                    <div class="dot red"></div>
                    <div class="dot yellow"></div>
                    <div class="dot green"></div>
                    <span class="terminal-title">visitors_stats.log</span>
                </div>
                <div class="terminal-body">
                    <?php if (isset($error)): ?>
                        <p class="error-active"><?php echo $error; ?></p>
                    <?php else: ?>
                        <div class="table-container">
                            <table class="visitors-table">
                                <thead>
                                    <tr>
                                        <th>IP Address</th>
                                        <th>Visits</th>
                                        <th>Last Visit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($visitors as $visitor): ?>
                                        <tr>
                                            <td class="ip-cell"><?php echo htmlspecialchars($visitor['ip']); ?></td>
                                            <td class="count-cell"><?php echo htmlspecialchars($visitor['count']); ?></td>
                                            <td class="date-cell"><?php echo htmlspecialchars($visitor['last_visit']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
    <footer class="footer">
        <p>&copy; 2026 FriedrichOsDev. All rights reserved.</p>
    </footer>
    <script src="script.js"></script>
</body>

</html>