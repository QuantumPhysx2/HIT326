<?php
// Initiate session
session_start();

// Database connection properties
$dbAdapter = "mysql";
$dbHost = "localhost";
$dbPort = 3307;
$dbName = "";
$dbUsername = "root";
$dbPassword = "";

try {
    // Initiate a new PHP Data Objects connection with specified parameters
    $conn = new PDO("$dbAdapter:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUsername, $dbPassword);
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // End session data
    session_write_close();
} catch (PDOException $error) {
    // Report error if connection configurations incorrect
    die("[PHP] ".__LINE__.": Connection Error: " . $error->getMessage());
}
?>
