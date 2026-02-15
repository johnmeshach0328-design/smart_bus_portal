<?php
$conn = new mysqli("localhost", "root", "", "smart_bus_portal");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to add column if not exists
function addColumn($conn, $table, $column, $type, $after)
{
    // Check if column exists
    $check = $conn->query("SHOW COLUMNS FROM $table LIKE '$column'");
    if ($check->num_rows == 0) {
        $sql = "ALTER TABLE $table ADD COLUMN $column $type AFTER $after";
        if ($conn->query($sql) === TRUE) {
            echo "Column '$column' added successfully.<br>";
        } else {
            echo "Error adding column '$column': " . $conn->error . "<br>";
        }
    } else {
        echo "Column '$column' already exists.<br>";
    }
}

// Add bus_type and shift columns (ensure previous ones are there)
addColumn($conn, 'buses', 'bus_type', 'VARCHAR(50)', 'incharge_id');
addColumn($conn, 'buses', 'shift1_time', 'VARCHAR(20)', 'route');
addColumn($conn, 'buses', 'shift2_time', 'VARCHAR(20)', 'shift1_time');
addColumn($conn, 'buses', 'shift3_time', 'VARCHAR(20)', 'shift2_time');
addColumn($conn, 'buses', 'shift4_time', 'VARCHAR(20)', 'shift3_time');
addColumn($conn, 'buses', 'shift5_time', 'VARCHAR(20)', 'shift4_time');
addColumn($conn, 'buses', 'shift6_time', 'VARCHAR(20)', 'shift5_time');

// Add Route Stops columns (up to 9)
addColumn($conn, 'buses', 'stop1', 'VARCHAR(100)', 'shift6_time');
addColumn($conn, 'buses', 'stop2', 'VARCHAR(100)', 'stop1');
addColumn($conn, 'buses', 'stop3', 'VARCHAR(100)', 'stop2');
addColumn($conn, 'buses', 'stop4', 'VARCHAR(100)', 'stop3');
addColumn($conn, 'buses', 'stop5', 'VARCHAR(100)', 'stop4');
addColumn($conn, 'buses', 'stop6', 'VARCHAR(100)', 'stop5');
addColumn($conn, 'buses', 'stop7', 'VARCHAR(100)', 'stop6');
addColumn($conn, 'buses', 'stop8', 'VARCHAR(100)', 'stop7');
addColumn($conn, 'buses', 'stop9', 'VARCHAR(100)', 'stop8');
addColumn($conn, 'buses', 'district', 'VARCHAR(50)', 'bus_type');

$conn->close();
?>