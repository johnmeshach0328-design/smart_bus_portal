<?php
session_start();
require_once 'db.php';

// Check if user is logged in as admin
if (!isset($_SESSION['platform_incharge'])) {
    header("Location: platform_incharge_login.php");
    exit();
}

$admin_id = $_SESSION['incharge_id'] ?? 0; 
$admin_district = $_SESSION['admin_district'];

// If admin_id is not in session, fetch it using username (platform_incharge)
if ($admin_id == 0 && isset($_SESSION['platform_incharge'])) {
    $stmt = $conn->prepare("SELECT id FROM platform_incharges WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['platform_incharge']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $admin_id = $row['id'];
        $_SESSION['incharge_id'] = $admin_id; // Cache it correctly
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Validate Inputs
    $bus_id = $_POST['bus_id'];
    $stop1 = $admin_district; // Always admin's district
    $stop2 = trim($_POST['stop2']);
    $stop3 = trim($_POST['stop3']);
    $stop4 = trim($_POST['stop4']);
    $reason = trim($_POST['emergency_reason']);
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    if (empty($bus_id) || empty($stop2) || empty($stop3) || empty($stop4) || empty($reason) || empty($start_time) || empty($end_time)) {
        header("Location: manage_diversions.php?error=missing_fields");
        exit();
    }

    if (strtotime($end_time) <= strtotime($start_time)) {
        header("Location: manage_diversions.php?error=invalid_time");
        exit();
    }

    // 2. Get Bus Details (Original Route)
    $stmt = $conn->prepare("SELECT bus_number, route FROM buses WHERE id = ? AND district = ?");
    $stmt->bind_param("is", $bus_id, $admin_district);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 0) {
        header("Location: manage_diversions.php?error=bus_not_found");
        exit();
    }
    $bus = $res->fetch_assoc();
    $original_route = $bus['route'];
    $bus_number = $bus['bus_number'];
    $stmt->close();

    // 3. Insert Diversion Record
    $sql = "INSERT INTO route_diversions (bus_id, admin_id, district, original_route, stop1, stop2, stop3, stop4, emergency_reason, start_time, end_time, completion_status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisssssssss", $bus_id, $admin_id, $admin_district, $original_route, $stop1, $stop2, $stop3, $stop4, $reason, $start_time, $end_time);
    
    if ($stmt->execute()) {
        // 4. Auto-broadcast announcement
        $message = "⚠️ ROUTE DIVERSION: Bus $bus_number ($original_route) is temporarily diverted via $stop2 - $stop3 to $stop4. Reason: $reason. Valid from " . date('d M H:i', strtotime($start_time)) . " to " . date('d M H:i', strtotime($end_time));
        
        $msg_stmt = $conn->prepare("INSERT INTO district_messages (district, message, expires_at) VALUES (?, ?, ?)");
        $msg_stmt->bind_param("sss", $admin_district, $message, $end_time);
        $msg_stmt->execute();
        $msg_stmt->close();

        header("Location: manage_diversions.php?success=diversion_created");
    } else {
        header("Location: manage_diversions.php?error=db_error");
    }
    $stmt->close();
} else {
    header("Location: manage_diversions.php");
}
$conn->close();
?>
