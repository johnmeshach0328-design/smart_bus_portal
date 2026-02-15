<?php
require_once 'config/db.php';

// Total Buses
$result = $conn->query("SELECT COUNT(*) as total FROM buses");
$total = $result->fetch_assoc()['total'];
echo "Total Buses: $total\n";

// By Type
$result = $conn->query("SELECT bus_type, COUNT(*) as count FROM buses GROUP BY bus_type");
while ($row = $result->fetch_assoc()) {
    echo "{$row['bus_type']}: {$row['count']}\n";
}

// Sample District Counts (Top 5)
echo "\nSample District Counts:\n";
$result = $conn->query("SELECT district, COUNT(*) as count FROM buses GROUP BY district LIMIT 5");
while ($row = $result->fetch_assoc()) {
    echo "{$row['district']}: {$row['count']}\n";
}

// Check if any SETC goes to same zone (simple check: distance > 0)
// We can't easily check distance here without the logic, but we can check if route has different src/dest
echo "\nSample SETC Routes:\n";
$result = $conn->query("SELECT route FROM buses WHERE bus_type='SETC' LIMIT 5");
while ($row = $result->fetch_assoc()) {
    echo "{$row['route']}\n";
}
?>
