<?php
$host = 'localhost:3307';
$dbname = 'studentdb';
$username = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // die("Database connection failed: " . $e->getMessage());
    echo($e->getMessage());
}
?>