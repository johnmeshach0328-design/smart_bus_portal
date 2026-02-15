<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Bus Portal | Creator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/CSS/custom_style.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
            color: #fff;
        }

        .content-box {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 3rem;
            max-width: 600px;
            width: 90%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.8s ease-out;
            position: relative;
            z-index: 10;
        }

        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 1.5rem;
            transition: color 0.3s;
            text-decoration: none;
        }

        .back-btn:hover {
            color: #fff;
        }
    </style>
</head>

<body class="bg-movable bg-index bg-overlay">
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

    <div class="content-box text-center">
        <a href="index.php" class="back-btn"><i class="bi bi-arrow-left"></i></a>

        <div class="mb-4">
            <i class="bi bi-person-workspace fs-1 text-warning"></i>
        </div>

        <h2 class="fw-bold mb-2" id="page_title">Creator</h2>
        <div class="my-4">
            <i class="bi bi-code-slash display-1 text-white-50"></i>
        </div>

        <h4 class="mb-3" id="creator_heading">Developed with ❤️ by the Tech Team</h4>
        <p class="text-white-50 fs-5" id="creator_desc">Dedicated to building smart solutions for a better tomorrow.</p>

        <div class="mt-5 pt-4 border-top border-white border-opacity-10">
            <p class="small text-white-50" id="creator_footer">Version 1.0.0 &bull; © 2026 Smart Bus Portal</p>
        </div>
    </div>

    <script src="assets/js/page-transitions.js"></script>
    <script src="assets/js/theme-manager.js"></script>
    <script src="assets/js/font-color-loader.js"></script>
</body>

</html>