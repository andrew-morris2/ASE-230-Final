<?php
// Database configuration
$host = 'localhost';      // The hostname of your database server (use '127.0.0.1' if localhost doesn't work)
$user = 'root';           // Your MySQL username (default is 'root' for local installations)
$password = '';           // Your MySQL password (leave blank for default local installations)
$database = 'store_db'; // The name of your database

// Create the connection
$conn = new mysqli($host, $user, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>