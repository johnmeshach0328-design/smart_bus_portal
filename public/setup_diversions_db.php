<?php
require_once 'db.php';

// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS route_diversions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bus_id INT NOT NULL,
    admin_id INT NOT NULL,
    district VARCHAR(100) NOT NULL,
    original_route VARCHAR(255) NOT NULL,
    stop1 VARCHAR(200) NOT NULL,
    stop2 VARCHAR(200) NOT NULL,
    stop3 VARCHAR(200) NOT NULL,
    stop4 VARCHAR(200) NOT NULL,
    emergency_reason TEXT NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    completion_status ENUM('Pending', 'In Transit', 'Completed') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bus_id) REFERENCES buses(id) ON DELETE CASCADE,
    FOREIGN KEY (admin_id) REFERENCES platform_incharges(id),
    INDEX (district),
    INDEX (start_time),
    INDEX (end_time),
    INDEX (completion_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

if ($conn->query($sql) === TRUE) {
    echo "Table 'route_diversions' created successfully.<br>";
    echo "<a href='platform_dashboard.php'>Return to Dashboard</a>";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
