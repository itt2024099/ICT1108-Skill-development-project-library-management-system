<?php
// Databse connection config
// standard PDO database conection
$host = "localhost";
$user = "root";
$pass = "";
$db   = "library_db";

try {
    // Create new PDO database connection
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    
    // Set error mode to exception for error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // Display error if connection fails
    die("Database Connection Failed: " . $e->getMessage());
}
?>