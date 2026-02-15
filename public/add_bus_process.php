<?php
require_once 'db.php';

if ($conn->connect_error) {
    die("Database connection failed");
}

$incharge_id = $_POST['incharge_id'];
$bus_number = $_POST['bus_number'];
$route = $_POST['route'];

$sql = "INSERT INTO buses (incharge_id, bus_number, route)
        VALUES ('$incharge_id', '$bus_number', '$route')";

if ($conn->query($sql)) {
    echo "<script>alert('Bus added successfully'); window.location.href='add_bus.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>