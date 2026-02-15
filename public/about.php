<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Bus Portal | About Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/CSS/custom_style.css?v=premium_polish_final" rel="stylesheet">
    <style>
        body {
            /* Animated background managed by custom_style.css .circles */

            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
            color: #fff;
        }

        .content-box {
            background: var(--card-bg);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-xl);
            padding: 3rem;
            max-width: 800px;
            width: 90%;
            box-shadow: var(--shadow-2xl);
            animation: fadeIn 0.8s ease-out;
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
            <i class="bi bi-info-circle fs-1 text-info"></i>
        </div>

        <h2 class="fw-bold mb-4" id="page_title">About Us</h2>

        <div class="fs-5 lh-lg" style="color: var(--text-main); opacity: 0.8;" id="about_content">
            <!-- Content populated by JS -->
        </div>
    </div>

    <script src="assets/js/page-transitions.js"></script>
    <script src="assets/js/theme-manager.js?v=premium_polish_final"></script>
    <script src="assets/js/font-color-loader.js"></script>
</body>

</html>