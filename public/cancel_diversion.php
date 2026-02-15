<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['platform_incharge'])) {
    header("Location: platform_incharge_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $diversion_id = $_POST['diversion_id'];
    $admin_district = $_SESSION['admin_district'];

    if (!empty($diversion_id)) {
        // Verify the diversion belongs to this admin's district to prevent unauthorized cancellations
        $stmt = $conn->prepare("UPDATE route_diversions SET completion_status = 'Completed' WHERE id = ? AND district = ?");
        $stmt->bind_param("is", $diversion_id, $admin_district);
        
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                 header("Location: manage_diversions.php?success=diversion_cancelled");
            } else {
                 header("Location: manage_diversions.php?error=invalid_id");
            }
        } else {
            header("Location: manage_diversions.php?error=db_error");
        }
        $stmt->close();
    } else {
        header("Location: manage_diversions.php");
    }
} else {
    header("Location: manage_diversions.php");
}
$conn->close();
?>
