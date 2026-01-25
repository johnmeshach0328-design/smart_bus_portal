<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Passenger Login | Smart Bus Portal</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #4facfe, #00c6ff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-box {
            background: #ffffff;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            max-width: 450px;
            width: 100%;
        }

        .login-title {
            color: #0aa2ff;
            font-weight: 700;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
        }

        .btn-login {
            background: linear-gradient(135deg, #4facfe, #00c6ff);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            color: #fff;
        }

        .btn-login:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body>

<div class="login-box">
    <div class="text-center mb-4">
        <i class="bi bi-person-circle" style="font-size: 3rem; color:#0aa2ff;"></i>
        <h3 class="login-title mt-2">Passenger Login</h3>
        <p class="text-muted">Verify using your details</p>
    </div>

    <form action="passenger_dashboard.php" method="POST">

        <!-- Passenger Name -->
        <div class="mb-3">
            <label class="form-label">Passenger Name</label>
            <input type="text" 
                   class="form-control" 
                   name="passenger_name" 
                   placeholder="Enter your name" 
                   required>
        </div>

        <!-- Mobile Number -->
        <div class="mb-4">
            <label class="form-label">Mobile Number</label>
            <input type="tel" 
                   class="form-control" 
                   name="mobile_number" 
                   placeholder="Enter 10-digit mobile number" 
                   pattern="[0-9]{10}" 
                   required>
        </div>

        <button type="submit" class="btn btn-login w-100">
            Verify & Login
        </button>

    </form>

    <div class="text-center mt-3">
        <a href="index.php" class="text-decoration-none">← Back to Home</a>
    </div>
</div>

</body>
</html>
