<?php
$servername = "localhost";
$username = "root";
$password = ""; // default in XAMPP
$database = "smart_bus_portal";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>
