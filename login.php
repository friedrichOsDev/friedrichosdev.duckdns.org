<?php
session_start();
require_once('/var/www/db_config.php');

$error = "No Error Detected";
$is_error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $stmt = $pdo->prepare("SELECT password_hash FROM admins WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($_POST['password'], $admin['password_hash'])) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password!";
        $is_error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FriedrichOsDev</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="header">
        <p>Login</p>
        <div>
            <a class="button-link" href="index.php">Home</a>
            <a class="button-link" href="projects.html">Projects</a>
            <a class="button-link" href="monitor.php">Monitor</a>
            <a class="button-link" href="contact.html">Contact</a>
            <a class="button-link header-link-active header-link-last" href="login.php">Login</a>
        </div>
    </header>
    <main>
        <section class="about-section">
            <div class="terminal-window">
                <div class="terminal-header">
                    <span class="dot red"></span>
                    <span class="dot yellow"></span>
                    <span class="dot green"></span>
                    <span class="terminal-title">login.sh</span>
                </div>
                <div class="terminal-body">
                    <form method="POST" action="login.php" class="login-form">
                        <p class="terminal-line"><span class="prompt">friedrich@osdev:~$</span> <span
                                class="command">login --username</span></p>
                        <input class="response-input" type="text" name="username" required autofocus autocomplete="off">
                        <p class="terminal-line"><span class="prompt">friedrich@osdev:~$</span> <span
                                class="command">login --password</span></p>
                        <input class="response-input" type="password" name="password" required>
                        <p class="terminal-line"><span class="prompt">friedrich@osdev:~$</span> <span
                                class="command">login --auth</span></p>
                        <button type="submit" class="response-tags response-button">auth</button>
                        <p class="terminal-line"><span class="prompt">friedrich@osdev:~$</span> <span
                                class="command">login --check</span></p>
                        <p class="response-error <?php echo $is_error ? 'error-active' : 'error-none'; ?>">
                            <?php echo htmlspecialchars($error); ?></p>
                        <p class="terminal-line"><span class="prompt">friedrich@osdev:~$</span> <span
                                class="cursor"></span></p>
                    </form>
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