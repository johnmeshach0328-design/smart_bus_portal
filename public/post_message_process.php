<?php
session_start();
require_once 'db.php';

// Check if user is logged in as admin
if (!isset($_SESSION['platform_incharge'])) {
    header("Location: platform_incharge_login.php");
    exit();
}

// Get the admin's district
$admin_district = $_SESSION['admin_district'];

// Validate inputs
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = trim($_POST['message'] ?? '');
    
    // Validate message
    if (empty($message)) {
        header("Location: platform_incharge_dashboard.php?error=empty_message#dash_staff_title");
        exit();
    }

    // Set expiry (default 24 hours from now)
    $expires_at = date('Y-m-d H:i:s', strtotime('+24 hours'));

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO district_messages (district, message, expires_at) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $admin_district, $message, $expires_at);

    if ($stmt->execute()) {
        header("Location: platform_incharge_dashboard.php?success=message_broadcasted#dash_staff_title");
    } else {
        header("Location: platform_incharge_dashboard.php?error=db_error#dash_staff_title");
    }

    $stmt->close();
} else {
    header("Location: platform_incharge_dashboard.php#dash_staff_title");
}

$conn->close();
?>
