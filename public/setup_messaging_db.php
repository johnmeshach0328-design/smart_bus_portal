<?php
require_once 'db.php';

// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS district_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    district VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME DEFAULT NULL,
    INDEX (district),
    INDEX (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

if ($conn->query($sql) === TRUE) {
    echo "Table 'district_messages' created successfully.";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
