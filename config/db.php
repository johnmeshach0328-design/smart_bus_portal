<?php
$conn = mysqli_connect("localhost", "root", "", "smart_bus_portal");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to utf8mb4
mysqli_set_charset($conn, "utf8mb4");
?>
