<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    require_once('/var/www/db_config.php');

    if (!isset($_GET['key']) || empty(MY_API_KEY) || $_GET['key'] !== MY_API_KEY) {
        http_response_code(403);
        echo json_encode(["status" => "error", "message" => "Zugriff verweigert!"]);
        exit;
    }

    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        
        $stmt = $pdo->query("SELECT ip, count, last_visit FROM visitors ORDER BY last_visit DESC");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => "success",
            "total_unique_ips" => count($data),
            "data" => $data
        ]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            "status" => "error",
            "message" => "Datenbankverbindung fehlgeschlagen"
        ]);
    }
?>