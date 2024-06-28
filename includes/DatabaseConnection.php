<?php
// Load environment variables from .env file
$env = parse_ini_file('../.env'); // root of project

// Set database credentials from .env variables
$database_host = $env["DATABASE_HOST"];
$database_user = $env["DATABASE_USER"];
$database_password = $env["DATABASE_PASSWORD"];

// PDO database connection
try {
    $pdo = new PDO('mysql:host=$database_host;dbname=cms;charset=utf8', $database_user, $database_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT, false);
    echo "Connected successfully"; // Optional: Display message on successful connection
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>