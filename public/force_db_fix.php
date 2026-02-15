<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "smart_bus_portal");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h3>Starting Database Repair...</h3>";

// Function to add column if it doesn't exist
function repairColumn($conn, $table, $column, $definition)
{
    if ($conn->query("SHOW COLUMNS FROM `$table` LIKE '$column'")->num_rows == 0) {
        if ($conn->query("ALTER TABLE `$table` ADD `$column` $definition")) {
            echo "<span style='color:green;'>[SUCCESS] Added column '$column' to '$table'</span><br>";
        } else {
            echo "<span style='color:red;'>[ERROR] Failed to add column '$column': " . $conn->error . "</span><br>";
        }
    } else {
        echo "<span style='color:gray;'>[INFO] Column '$column' already exists in '$table'</span><br>";
    }
}

// Ensure buses table has all required columns
repairColumn($conn, 'buses', 'bus_type', "VARCHAR(50) AFTER route");
repairColumn($conn, 'buses', 'district', "VARCHAR(50) AFTER bus_type");

// Shifts
repairColumn($conn, 'buses', 'shift1_time', "VARCHAR(20) AFTER district");
repairColumn($conn, 'buses', 'shift2_time', "VARCHAR(20) AFTER shift1_time");
repairColumn($conn, 'buses', 'shift3_time', "VARCHAR(20) AFTER shift2_time");
repairColumn($conn, 'buses', 'shift4_time', "VARCHAR(20) AFTER shift3_time");
repairColumn($conn, 'buses', 'shift5_time', "VARCHAR(20) AFTER shift4_time");
repairColumn($conn, 'buses', 'shift6_time', "VARCHAR(20) AFTER shift5_time");

// Stops
repairColumn($conn, 'buses', 'stop1', "VARCHAR(100) AFTER shift6_time");
repairColumn($conn, 'buses', 'stop2', "VARCHAR(100) AFTER stop1");
repairColumn($conn, 'buses', 'stop3', "VARCHAR(100) AFTER stop2");
repairColumn($conn, 'buses', 'stop4', "VARCHAR(100) AFTER stop3");
repairColumn($conn, 'buses', 'stop5', "VARCHAR(100) AFTER stop4");
repairColumn($conn, 'buses', 'stop6', "VARCHAR(100) AFTER stop5");
repairColumn($conn, 'buses', 'stop7', "VARCHAR(100) AFTER stop6");
repairColumn($conn, 'buses', 'stop8', "VARCHAR(100) AFTER stop7");
repairColumn($conn, 'buses', 'stop9', "VARCHAR(100) AFTER stop8");

echo "<h4>Database repair complete!</h4>";
echo "<p><a href='passenger_dashboard.php'>Go back to Dashboard</a></p>";

$conn->close();
?>