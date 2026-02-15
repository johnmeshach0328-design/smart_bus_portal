<?php
/**
 * CENTRALIZED DATABASE CONNECTION
 * This file is included in all pages to manage the connection.
 */

$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP password
$database = "smart_bus_portal";

// Create connection (Object Oriented)
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Set charset to utf8mb4 for global character support
$conn->set_charset("utf8mb4");

// SET TIMEZONE (India Standard Time)
date_default_timezone_set('Asia/Kolkata');
$conn->query("SET time_zone = '+05:30'");
?>