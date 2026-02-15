<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Smart Bus Portal</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
            transition: all 0.5s ease;
        }

        /* Page fade animation */
        body.fade-out {
            opacity: 0;
            transform: scale(0.97);
        }

        .portal-box {
            background: #ffffff;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            max-width: 900px;
            width: 100%;
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(25px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .portal-title {
            color: #0d6efd;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .login-card {
            border: none;
            border-radius: 14px;
            padding: 35px 25px;
            cursor: pointer;
            transition: all 0.35s ease;
            background: linear-gradient(135deg, #e7f1ff, #ffffff);
        }

        .login-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(13,110,253,0.35);
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            color: #ffffff;
        }

        .login-card:active {
            transform: scale(0.95);
        }

        .login-card:hover i,
        .login-card:hover p {
            color: #ffffff;
        }

        .login-card i {
            font-size: 3rem;
            color: #0d6efd;
            margin-bottom: 15px;
            transition: color 0.35s ease;
        }

        .login-card p {
            color: #555;
            margin-bottom: 0;
        }
    </style>
</head>

<body>

<div class="portal-box text-center">
    <h2 class="portal-title mb-4">SMART BUS PORTAL</h2>
    
    <div class="row g-4 justify-content-center">

        <!-- Passenger Login -->
        <div class="col-md-5">
            <div class="card login-card" onclick="goToPage('passenger_login.php')">
                <i class="bi bi-person-fill"></i>
                <h4>Passenger Login</h4>
            </div>
        </div>

        <!-- Platform Incharge Login -->
        <div class="col-md-5">
            <div class="card login-card" onclick="goToPage('platform_incharge_login.php')">
                <i class="bi bi-shield-lock-fill"></i>
                <h4>Platform Incharge Login</h4>
            </div>
        </div>

    </div>
</div>

<script>
    function goToPage(url) {
        document.body.classList.add("fade-out");
        setTimeout(() => {
            window.location.href = url;
        }, 450);
    }
</script>

</body>
</html>
