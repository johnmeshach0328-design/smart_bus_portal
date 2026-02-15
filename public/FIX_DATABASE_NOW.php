<?php
/**
 * ONE-CLICK DATABASE REPAIR SCRIPT
 * Run this to fix the "Missing District" error immediately.
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<div style='font-family: sans-serif; padding: 20px; background: #f8f9fa; border-radius: 10px; border: 1px solid #ddd;'>";
echo "<h2 style='color:#0d6efd;'>Smart Bus Portal - Database Repair</h2>";

$conn = new mysqli("localhost", "root", "", "smart_bus_portal");

if ($conn->connect_error) {
    die("<p style='color:red;'>[FAILED] Connection error: " . $conn->connect_error . "</p></div>");
}

// Function to safely add a column
function addCol($conn, $col, $type, $after)
{
    $res = $conn->query("SHOW COLUMNS FROM `buses` LIKE '$col'");
    if ($res->num_rows == 0) {
        if ($conn->query("ALTER TABLE `buses` ADD `$col` $type AFTER `$after`")) {
            echo "<p style='color:green;'>✅ Successfully added column: <strong>$col</strong></p>";
        } else {
            echo "<p style='color:red;'>❌ Error adding $col: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color:gray;'>ℹ️ Column '$col' already exists.</p>";
    }
}

echo "<hr>";

// Add the missing columns in order
addCol($conn, 'bus_type', 'VARCHAR(50)', 'route');
addCol($conn, 'district', 'VARCHAR(50)', 'bus_type');

// Add shifts
addCol($conn, 'shift1_time', 'VARCHAR(20)', 'district');
addCol($conn, 'shift2_time', 'VARCHAR(20)', 'shift1_time');
addCol($conn, 'shift3_time', 'VARCHAR(20)', 'shift2_time');
addCol($conn, 'shift4_time', 'VARCHAR(20)', 'shift3_time');
addCol($conn, 'shift5_time', 'VARCHAR(20)', 'shift4_time');
addCol($conn, 'shift6_time', 'VARCHAR(20)', 'shift5_time');

// Add stops
addCol($conn, 'stop1', 'VARCHAR(100)', 'shift6_time');
addCol($conn, 'stop2', 'VARCHAR(100)', 'stop1');
addCol($conn, 'stop3', 'VARCHAR(100)', 'stop2');
addCol($conn, 'stop4', 'VARCHAR(100)', 'stop3');
addCol($conn, 'stop5', 'VARCHAR(100)', 'stop4');
addCol($conn, 'stop6', 'VARCHAR(100)', 'stop5');
addCol($conn, 'stop7', 'VARCHAR(100)', 'stop6');
addCol($conn, 'stop8', 'VARCHAR(100)', 'stop7');
addCol($conn, 'stop9', 'VARCHAR(100)', 'stop8');

echo "<hr>";
echo "<h3 style='color:green;'>Repair Process Finished!</h3>";
echo "<p>The 'district' column is now active. You can now use the dashboard.</p>";
echo "<p><a href='passenger_dashboard.php' style='display:inline-block; padding:10px 20px; background:#0d6efd; color:white; text-decoration:none; border-radius:5px;'>Go to Dashboard</a></p>";
echo "</div>";

$conn->close();
?>