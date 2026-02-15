<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once 'db.php';

$error = "";

$selected_district = $_GET['district'] ?? '';
// If no district is selected, redirect back to selection page
if (empty($selected_district)) {
    header("Location: staff_district_selection.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_input = strtolower(trim($_POST['admin_name']));
    $password_input = strtolower(trim($_POST['password']));
    // District from GET param (for security, could strictly rely on DB lookup but need to match the flow)
    $district_input = strtolower(trim($selected_district));

    // Query: Username AND Password AND District must match
    $stmt = $conn->prepare("SELECT * FROM platform_incharges WHERE LOWER(username)=? AND LOWER(district)=? AND LOWER(password)=?");
    $stmt->bind_param("sss", $username_input, $district_input, $password_input);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['platform_incharge'] = $row['username'];
        $_SESSION['incharge_id'] = $row['id'];
        $_SESSION['admin_district'] = $row['district'];
        header("Location: platform_dashboard.php");
        exit();
    } else {
        $error = "Invalid Credentials for " . htmlspecialchars($selected_district) . " District!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login | <?php echo htmlspecialchars($selected_district); ?> District</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <link href="assets/CSS/custom_style.css" rel="stylesheet">
    <script src="assets/js/theme-manager.js"></script>
    <script src="assets/js/font-color-loader.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            /* Background managed by theme-manager.js */
        }

        .login-card {
            background: var(--card-bg);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            display: flex;
            flex-wrap: wrap;
            min-height: 550px;
            position: relative;
            z-index: 10;
        }

        .login-image {
            background: var(--gradient-primary);
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 40px;
            text-align: center;
        }

        .login-form-container {
            width: 50%;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .login-image h2 {
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 2.2rem;
        }

        .brand-icon {
            font-size: 5rem;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .input-group-text {
            background: var(--input-bg);
            border-right: none;
            color: var(--text-main);
        }

        .form-control {
            border-left: none;
            padding: 12px;
            background: var(--input-bg);
        }

        .form-control:focus {
            box-shadow: none;
            background: var(--input-bg);
            border-color: var(--primary-blue);
        }

        .btn-login {
            background: var(--primary-blue);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: var(--primary-blue-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            color: white;
        }

        @media (max-width: 768px) {
            .login-image {
                display: none;
            }

            .login-form-container {
                width: 100%;
            }

            .login-card {
                max-width: 450px;
                min-height: auto;
            }
        }
    </style>
</head>

<body class="bg-movable bg-staff bg-overlay">
    <!-- Background Animation -->
    <ul class="circles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>

    <div class="login-card">
        <!-- Decoration Side -->
        <div class="login-image">
            <i class="bi bi-shield-lock brand-icon"></i>
            <h2>Staff Portal</h2>
            <p>Login for <strong><?php echo htmlspecialchars($selected_district); ?></strong> District</p>
        </div>

        <!-- Form Side -->
        <div class="login-form-container">
            <!-- Back Button -->
            <a href="staff_district_selection.php"
                class="text-decoration-none text-secondary position-absolute bottom-0 start-50 translate-middle-x mb-4"
                style="font-size: 0.9rem;" id="btn_back_dist_link">
                <i class="bi bi-arrow-left me-1"></i> <span id="btn_back_dist">Back to Districts</span>
            </a>

            <h3 class="fw-bold mb-2" id="staff_login_title" style="color: var(--text-heading);">Staff Login</h3>
            <p class="text-muted mb-4">Enter credentials for <?php echo htmlspecialchars($selected_district); ?></p>

            <?php if ($error): ?>
                <div class="alert alert-danger py-2 text-center" role="alert">
                    <i class="bi bi-exclamation-circle me-1"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label" id="lbl_username">USERNAME</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                        <input type="text" class="form-control" name="admin_name" placeholder="Enter ID" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label" id="lbl_pass">PASSWORD</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                        <input type="password" class="form-control" name="password" placeholder="Enter Password"
                            required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-login mb-4" id="btn_login">
                    Login
                </button>
            </form>
        </div>
    </div>

    <script src="assets/js/page-transitions.js"></script>
</body>

</html>