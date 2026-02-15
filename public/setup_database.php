<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS smart_bus_portal";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully.<br>";
}

// Select database
$conn->select_db("smart_bus_portal");

// DROP tables to start fresh
$conn->query("SET FOREIGN_KEY_CHECKS = 0");
$conn->query("DROP TABLE IF EXISTS attendance");
$conn->query("DROP TABLE IF EXISTS buses");
$conn->query("DROP TABLE IF EXISTS platform_incharges");
$conn->query("SET FOREIGN_KEY_CHECKS = 1");

// 1. Create platform_incharges table
$sql = "CREATE TABLE platform_incharges (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    reg_id VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    district VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);

// 2. Insert all 38 District Admins
$districts = [
    "Ariyalur",
    "Chengalpattu",
    "Chennai",
    "Coimbatore",
    "Cuddalore",
    "Dharmapuri",
    "Dindigul",
    "Erode",
    "Kallakurichi",
    "Kancheepuram",
    "Kanniyakumari",
    "Karur",
    "Krishnagiri",
    "Madurai",
    "Mayiladuthurai",
    "Nagapattinam",
    "Namakkal",
    "Nilgiris",
    "Perambalur",
    "Pudukkottai",
    "Ramanathapuram",
    "Ranipet",
    "Salem",
    "Sivaganga",
    "Tenkasi",
    "Thanjavur",
    "Theni",
    "Thoothukudi",
    "Tiruchirappalli",
    "Tirunelveli",
    "Tirupathur",
    "Tiruppur",
    "Tiruvallur",
    "Tiruvannamalai",
    "Tiruvarur",
    "Vellore",
    "Viluppuram",
    "Virudhunagar"
];

$pass = "TVLAD";
foreach ($districts as $index => $district) {
    $user = $district . "Admin";
    $reg = "REG" . (1000 + $index);
    $stmt = $conn->prepare("INSERT INTO platform_incharges (username, reg_id, password, district) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $user, $reg, $pass, $district);
    $stmt->execute();
}
echo "Created 38 District Administrators.<br>";

// 3. Create buses table
$sql = "CREATE TABLE buses (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    incharge_id INT(6) UNSIGNED,
    bus_number VARCHAR(20) NOT NULL,
    route VARCHAR(100) NOT NULL,
    bus_type VARCHAR(50),
    district VARCHAR(50),
    shift1_time VARCHAR(20),
    shift2_time VARCHAR(20),
    shift3_time VARCHAR(20),
    shift4_time VARCHAR(20),
    shift5_time VARCHAR(20),
    shift6_time VARCHAR(20),
    stop1 VARCHAR(100),
    stop2 VARCHAR(100),
    stop3 VARCHAR(100),
    stop4 VARCHAR(100),
    stop5 VARCHAR(100),
    stop6 VARCHAR(100),
    stop7 VARCHAR(100),
    stop8 VARCHAR(100),
    stop9 VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (incharge_id) REFERENCES platform_incharges(id)
)";
$conn->query($sql);
echo "Buses table created.<br>";

// 4. Create attendance table
$sql = "CREATE TABLE attendance (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    bus_id INT(6) UNSIGNED,
    attendance_date DATE NOT NULL,
    status ENUM('Present', 'Absent') DEFAULT 'Present',
    marked_by INT(6) UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bus_id) REFERENCES buses(id),
    FOREIGN KEY (marked_by) REFERENCES platform_incharges(id)
)";
$conn->query($sql);
echo "Attendance table created.<br>";

echo "<h3>✅ SYSTEM FULLY INITIALIZED</h3>";
echo "<p>You can now log in using <strong>ChennaiAdmin</strong> or <strong>Chennai</strong> with password <strong>TVLAD</strong>.</p>";
echo "<a href='platform_incharge_login.php'>Go to Login</a>";

$conn->close();
?>