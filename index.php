<?php
    require_once('/var/www/db_config.php');
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($ip !== '127.0.0.1' && $ip !== '::1' && $ip !== MY_IP) {
            $stmt = $pdo->prepare("INSERT INTO visitors (ip, count) VALUES (?, 1) ON DUPLICATE KEY UPDATE count = count + 1");
            $stmt->execute([$ip]);
        }
    } catch (PDOException $e) {
        error_log($e->getMessage());
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
        <p>Home</p>
        <div>
            <a class="button-link header-link-active" href="index.php">Home</a>
            <a class="button-link" href="projects.html">Projects</a>
            <a class="button-link" href="monitor.php">Monitor</a>
            <a class="button-link header-link-last" href="contact.html">Contact</a>
        </div>
    </header>
    <main>
        <section class="about-section">
            <div class="terminal-window">
                <div class="terminal-header">
                    <span class="dot red"></span>
                    <span class="dot yellow"></span>
                    <span class="dot green"></span>
                    <span class="terminal-title">about-me.sh</span>
                </div>
                <div class="terminal-body">
                    <p class="terminal-line"><span class="prompt">friedrich@osdev:~$</span> <span class="command"></span></p>
                    <p class="response"></p>
                    
                    <p class="terminal-line"><span class="prompt">friedrich@osdev:~$</span> <span class="command"></span></p>
                    <p class="response-tags"></p>
                    
                    <p class="terminal-line"><span class="prompt">friedrich@osdev:~$</span> <span class="command"></span></p>
                    <p class="response-tags"></p>
                    
                    <p class="terminal-line"><span class="prompt">friedrich@osdev:~$</span> <span class="command"></span></p>
                    <p class="response"></p>

                    <p class="terminal-line"><span class="prompt">friedrich@osdev:~$</span> <span class="cursor"></span></p>
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