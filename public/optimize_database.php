<?php
require_once 'db.php';
header('Content-Type: text/plain');

echo "Starting Database Optimization...\n";
echo "---------------------------------\n";

function executeQuery($conn, $sql, $message) {
    try {
        if ($conn->query($sql) === TRUE) {
            echo "[SUCCESS] $message\n";
        } else {
            // Check if error is "Duplicate key" or similar which is fine
            if (strpos($conn->error, "Duplicate column") !== false || strpos($conn->error, "already exists") !== false) {
                 echo "[SKIPPED] $message (Already exists)\n";
            } else {
                echo "[ERROR] $message: " . $conn->error . "\n";
            }
        }
    } catch (Exception $e) {
        echo "[INFO] $message: " . $e->getMessage() . "\n";
    }
}

// 1. Ensure district_messages exists and is optimized
$sql_msgs = "CREATE TABLE IF NOT EXISTS district_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    district VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME DEFAULT NULL,
    INDEX idx_district_expiry (district, expires_at),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
executeQuery($conn, $sql_msgs, "Table 'district_messages' setup");

// 2. Create system_logs (Auditing) - High Efficiency Requirement
$sql_logs = "CREATE TABLE IF NOT EXISTS system_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    level VARCHAR(20) DEFAULT 'INFO', -- INFO, WARN, ERROR
    action VARCHAR(100) NOT NULL,     -- e.g., 'LOGIN', 'CREATE_DIVERSION'
    message TEXT,
    user_id INT DEFAULT NULL,
    user_type VARCHAR(50) DEFAULT NULL, -- 'admin', 'passenger', 'system'
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_created_at (created_at),
    INDEX idx_action (action),
    INDEX idx_user (user_id, user_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
executeQuery($conn, $sql_logs, "Table 'system_logs' setup");

// 3. Optimize Buses Table
// Add index on route if likely to be searched often
try {
    $conn->query("ALTER TABLE buses ADD INDEX idx_route (route)");
    echo "[OPTIMIZE] Added index on buses(route)\n";
} catch (Exception $e) {
    // Likely already exists
}

// 4. Optimize Attendance
try {
    $conn->query("ALTER TABLE attendance ADD INDEX idx_bus_date_status (bus_id, attendance_date, status)");
    echo "[OPTIMIZE] Added composite index on attendance\n";
} catch (Exception $e) {
    // Likely already exists
}

echo "---------------------------------\n";
echo "Database Optimization Complete.\n";
echo "---------------------------------\n";

$conn->close();
?>
