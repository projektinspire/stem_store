<?php
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = ""; // Default is no password for root
$database = "projektinspire_store"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
