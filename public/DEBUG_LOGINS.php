<?php
/**
 * DATA VERIFICATION SCRIPT
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<div style='font-family: monospace; background: #000; color: #0f0; padding: 20px;'>";
echo "<h1>SYSTEM DIAGNOSTIC: BUS PORTAL</h1>";

$conn = new mysqli("localhost", "root", "", "smart_bus_portal");

if ($conn->connect_error) {
    die("DATABASE CONNECTION: FAILED [" . $conn->connect_error . "]");
}
echo "DATABASE CONNECTION: SUCCESS<br>";

$res = $conn->query("SELECT id, username, password, district FROM platform_incharges LIMIT 10");

if (!$res) {
    echo "TABLE QUERY: FAILED [" . $conn->error . "]<br>";
} else {
    echo "TABLE QUERY: SUCCESS. Found " . $res->num_rows . " records.<br><hr>";
    echo "<table border='1' style='color:#0f0; border-color:#0f0;'>";
    echo "<tr><th>ID</th><th>Username</th><th>Password</th><th>District</th></tr>";
    while ($row = $res->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['password'] . "</td>";
        echo "<td>" . $row['district'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

echo "</div>";
$conn->close();
?>