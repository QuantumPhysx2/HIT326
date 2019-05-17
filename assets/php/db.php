<?php
// Database connection settings (change for Spinetail)
$dbAdapter = "mysql";
$dbHost = "localhost";
$dbPort = 3307;
$dbName = "hit326";
$dbUsername = "root";
$dbPassword = "";

// Attempt connection to database
try {
    // Define variable to create a new connection (keep an eye on spelling)
    $conn = new PDO("$dbAdapter:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUsername, $dbPassword);
    // Setup error checking attributes
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $err) {
    // Should only occur if the connection parameters are incorrect
    die("Connection error. Check the configurations".$err->getMessage());
}
?>
