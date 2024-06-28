<?php
// Load environment variables from .env file
$env = parse_ini_file('.env');

// Set database credentials from .env variables
$database_user = $env["DATABASE_USER"];
$database_password = $env["DATABASE_PASSWORD"];

// PDO database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=cms;charset=utf8', $database_user, $database_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; // Optional: Display message on successful connection
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>