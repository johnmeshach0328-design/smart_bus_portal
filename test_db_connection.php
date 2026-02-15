<?php
require_once 'config/db.php';

if ($conn) {
    echo "Successfully connected to the database 'smart_bus_portal'!";
    
    // Check if tables exist
    $result = mysqli_query($conn, "SHOW TABLES");
    echo "\nTables in database:\n";
    while ($row = mysqli_fetch_array($result)) {
        echo "- " . $row[0] . "\n";
    }
} else {
    echo "Connection failed.";
}
?>
