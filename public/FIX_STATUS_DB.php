<?php
require_once 'db.php';

// Add new columns to attendance table
$sql = "ALTER TABLE attendance 
        ADD COLUMN detailed_status VARCHAR(50) DEFAULT 'Scheduled',
        ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";

if ($conn->query($sql) === TRUE) {
    echo "<h3>✅ Database Updated Successfully!</h3>";
    echo "<p>Columns 'detailed_status' and 'updated_at' have been added.</p>";
} else {
    echo "<h3>❌ Error updating database:</h3> " . $conn->error;
}

$conn->close();
?>