<?php
// passenger_auth_process.php
session_start();
require_once 'db.php';

// Enable error reporting for debugging (disable in production)
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'] ?? 'signin';
    $name = trim($_POST['passenger_name'] ?? '');
    $mobile = trim($_POST['mobile_number']);
    $captcha_input = $_POST['captcha'];

    // 1. Mobile Validation (Common)
    if (empty($mobile) || !preg_match("/^[0-9]{10}$/", $mobile)) {
        header("Location: passenger_login.php?error=invalid_mobile&mode=" . $action);
        exit();
    }

    require_once 'db.php';

    // 3. Action Specific Logic
    if ($action === 'signup') {
        // --- SIGN UP ---

        // CAPTCHA Check (Only for Signup)
        if (!isset($_SESSION['captcha_code']) || $captcha_input !== $_SESSION['captcha_code']) {
            header("Location: passenger_login.php?error=invalid_captcha&mode=signup");
            exit();
        }

        if (empty($name)) {
            header("Location: passenger_login.php?error=empty_fields&mode=signup");
            exit();
        }

        // Check if exists
        $stmt = $conn->prepare("SELECT id FROM passengers WHERE mobile_number = ?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            header("Location: passenger_login.php?error=user_exists&mode=signup");
            exit();
        }

        // Create new
        $insertStmt = $conn->prepare("INSERT INTO passengers (name, mobile_number, password_hash) VALUES (?, ?, 'NO_PASSWORD')");
        $insertStmt->bind_param("ss", $name, $mobile);

        if ($insertStmt->execute()) {
            $_SESSION['passenger_id'] = $insertStmt->insert_id;
            $_SESSION['passenger_name'] = $name;
            header("Location: passenger_dashboard.php");
            exit();
        } else {
            header("Location: passenger_login.php?error=db_error");
            exit();
        }

    } else {
        // --- SIGN IN ---
        $stmt = $conn->prepare("SELECT id, name FROM passengers WHERE mobile_number = ?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $stmt->bind_result($id, $db_name);

        if ($stmt->fetch()) {
            $_SESSION['passenger_id'] = $id;
            $_SESSION['passenger_name'] = $db_name;
            header("Location: passenger_dashboard.php");
            exit();
        } else {
            header("Location: passenger_login.php?error=user_not_found&mode=signin");
            exit();
        }
    }
}
?>