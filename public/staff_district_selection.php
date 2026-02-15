<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select District | Staff Portal</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- External CSS -->
    <link href="assets/CSS/custom_style.css?v=theme_fix_2" rel="stylesheet">

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            /* Background managed by theme-manager.js */
        }

        .dashboard-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .glass-panel {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 1000px;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .district-card {
            background: var(--card-bg);
            border-radius: 15px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            text-decoration: none;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            min-height: 140px;
        }

        .district-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-blue);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .district-card i {
            font-size: 2rem;
            color: var(--primary-blue);
            margin-bottom: 10px;
            display: block;
        }

        .district-card h5 {
            font-weight: 700;
            margin: 0;
            font-size: 1rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
            width: 100%;
            color: var(--text-heading) !important;
            text-shadow: none;
        }

        /* goldGlow animation removed — district card text now follows theme */

        .district-card h6 {
            font-weight: 700;
            margin: 0;
            font-size: 0.95rem;
            color: var(--text-heading) !important;
            text-shadow: none;
        }

        .district-card span {
            color: var(--text-heading) !important;
        }

        .district-scroll-container {
            max-height: 500px;
            overflow-y: auto;
            padding: 10px;
            scrollbar-width: thin;
            scrollbar-color: var(--primary-blue) var(--input-bg, rgba(255,255,255,0.1));
        }

        .district-scroll-container::-webkit-scrollbar {
            width: 6px;
        }

        .district-scroll-container::-webkit-scrollbar-thumb {
            background-color: var(--primary-blue);
            border-radius: 10px;
        }

        /* Floating Squares Animation */
        .circles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .circles li {
            position: absolute;
            display: block;
            list-style: none;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.15);
            animation: animate 25s linear infinite;
            bottom: -150px;
            border-radius: 20%;
            /* Slightly rounded squares */
        }

        .circles li:nth-child(1) {
            left: 25%;
            width: 80px;
            height: 80px;
            animation-delay: 0s;
        }

        .circles li:nth-child(2) {
            left: 10%;
            width: 20px;
            height: 20px;
            animation-delay: 2s;
            animation-duration: 12s;
        }

        .circles li:nth-child(3) {
            left: 70%;
            width: 20px;
            height: 20px;
            animation-delay: 4s;
        }

        .circles li:nth-child(4) {
            left: 40%;
            width: 60px;
            height: 60px;
            animation-delay: 0s;
            animation-duration: 18s;
        }

        .circles li:nth-child(5) {
            left: 65%;
            width: 20px;
            height: 20px;
            animation-delay: 0s;
        }

        .circles li:nth-child(6) {
            left: 75%;
            width: 110px;
            height: 110px;
            animation-delay: 3s;
        }

        .circles li:nth-child(7) {
            left: 35%;
            width: 150px;
            height: 150px;
            animation-delay: 7s;
        }

        .circles li:nth-child(8) {
            left: 50%;
            width: 25px;
            height: 25px;
            animation-delay: 15s;
            animation-duration: 45s;
        }

        .circles li:nth-child(9) {
            left: 20%;
            width: 15px;
            height: 15px;
            animation-delay: 2s;
            animation-duration: 35s;
        }

        .circles li:nth-child(10) {
            left: 85%;
            width: 150px;
            height: 150px;
            animation-delay: 0s;
            animation-duration: 11s;
        }

        @keyframes animate {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
                border-radius: 20%;
            }

            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
                border-radius: 50%;
            }
        }
    </style>
</head>

<body class="bg-movable bg-doodle bg-overlay">

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

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg backdrop-blur shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-dark" href="index.php">
                <i class="bi bi-bus-front me-2"></i><span id="txt_app_title">SMART BUS PORTAL</span>
            </a>
            <div class="ms-auto">
                <a href="index.php" class="btn btn-outline-dark btn-sm rounded-pill px-4" id="btn_back">Back to Home</a>
            </div>
        </div>
    </nav>

    <div class="dashboard-container">
        <!-- District Selection Screen -->
        <div class="glass-panel text-center">
            <h2 class="fw-bold mb-2" id="dist_title" style="color: var(--text-heading);">Select Your District</h2>
            <p class="text-muted mb-4" id="dist_desc" style="color: var(--text-main); opacity: 0.7;">Choose the district you are responsible for
            </p>

            <div class="district-scroll-container">
                <div class="row g-3">
                    <?php
                    $districts = [
                        "Ariyalur",
                        "Chengalpattu",
                        "Chennai",
                        "Coimbatore",
                        "Cuddalore",
                        "Dharmapuri",
                        "Dindigul",
                        "Erode",
                        "Kallakurichi",
                        "Kancheepuram",
                        "Kanniyakumari",
                        "Karur",
                        "Krishnagiri",
                        "Madurai",
                        "Mayiladuthurai",
                        "Nagapattinam",
                        "Namakkal",
                        "Nilgiris",
                        "Perambalur",
                        "Pudukkottai",
                        "Ramanathapuram",
                        "Ranipet",
                        "Salem",
                        "Sivaganga",
                        "Tenkasi",
                        "Thanjavur",
                        "Theni",
                        "Thoothukudi",
                        "Tiruchirappalli",
                        "Tirunelveli",
                        "Tirupathur",
                        "Tiruppur",
                        "Tiruvallur",
                        "Tiruvannamalai",
                        "Tiruvarur",
                        "Vellore",
                        "Viluppuram",
                        "Virudhunagar"
                    ];
                    foreach ($districts as $d):
                        $key = strtolower($d);
                        ?>
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="platform_incharge_login.php?district=<?php echo urlencode($d); ?>"
                                class="district-card py-3">
                                <i class="bi bi-shield-lock-fill mb-1"
                                    style="font-size: 1.5rem; color: #2563eb !important;"></i>
                                <h6 class="mb-0">
                                    <span data-translate-district="<?php echo $key; ?>"><?php echo $d; ?></span>
                                </h6>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Transitions -->
    <script src="assets/js/page-transitions.js"></script>
    <script src="assets/js/theme-manager.js?v=theme_fix_2"></script>
    <script src="assets/js/font-color-loader.js?v=theme_fix_2"></script>
    <script>
        // Update nav title locally if needed as it's span not title class
        const appTitleEl = document.getElementById('txt_app_title');
        if (appTitleEl && translations[localStorage.getItem('user_lang')]) {
            appTitleEl.textContent = translations[localStorage.getItem('user_lang')].app_title.toUpperCase();
        }
    </script>
</body>

</html>