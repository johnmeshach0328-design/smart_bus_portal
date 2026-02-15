<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "db.php";

$error = "";

/* =======================
   🔴 DEBUG: CHECK FORM POST
   ======================= */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<pre>";
    print_r($_POST);
    exit();
}
/* ======================= */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Platform Incharge Login</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 30px;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
    </style>
</head>

<body>

<div class="login-card">
    <h3 class="text-center mb-4">Platform Incharge Login</h3>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">REG ID</label>
            <input type="password" name="reg_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">District</label>
            <select name="district" class="form-control" required>
                <option value="">-- Select District --</option>
                <option>Ariyalur</option>
                <option>Chengalpattu</option>
                <option>Chennai</option>
                <option>Coimbatore</option>
                <option>Cuddalore</option>
                <option>Dharmapuri</option>
                <option>Dindigul</option>
                <option>Erode</option>
                <option>Kallakurichi</option>
                <option>Kanchipuram</option>
                <option>Kanyakumari</option>
                <option>Karur</option>
                <option>Krishnagiri</option>
                <option>Madurai</option>
                <option>Mayiladuthurai</option>
                <option>Nagapattinam</option>
                <option>Namakkal</option>
                <option>Nilgiris</option>
                <option>Perambalur</option>
                <option>Pudukkottai</option>
                <option>Ramanathapuram</option>
                <option>Ranipet</option>
                <option>Salem</option>
                <option>Sivagangai</option>
                <option>Tenkasi</option>
                <option>Thanjavur</option>
                <option>Theni</option>
                <option>Thoothukudi</option>
                <option>Tiruchirappalli</option>
                <option>Tirunelveli</option>
                <option>Tirupattur</option>
                <option>Tiruppur</option>
                <option>Tiruvallur</option>
                <option>Tiruvannamalai</option>
                <option>Tiruvarur</option>
                <option>Vellore</option>
                <option>Viluppuram</option>
                <option>Virudhunagar</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>

    </form>

    <p class="text-center mt-3 text-muted">Smart Bus Portal © 2026</p>
</div>

</body>
</html>
