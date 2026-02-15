<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Smart Bus Portal - Real-time bus tracking and attendance system for Tamil Nadu">
    <title>Smart Bus Portal | Welcome</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Poppins:wght@400;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/CSS/custom_style.css?v=premium_polish_final" rel="stylesheet">
    <script src="assets/js/theme-manager.js?v=premium_polish_final"></script>
    <script src="assets/js/font-color-loader.js"></script>

    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
        }

        .portal-container {
            position: relative;
            z-index: 10;
            animation: fadeIn 1s ease-out;
        }

        .portal-box {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 40px;
            padding: 2rem;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.5);
            width: 550px;
            height: 480px;
            max-width: 90vw;
            max-height: 90vh;
            text-align: center;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .portal-box::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 24px;
            padding: 2px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.05));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        .portal-header {
            margin-bottom: 2rem;
        }

        .portal-title {
            color: var(--text-heading);
            font-weight: 800;
            font-size: 2.5rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--text-heading) 0%, #ffffff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: slideDown 0.8s ease-out;
        }

        .portal-subtitle {
            color: var(--text-main);
            font-size: 1rem;
            font-weight: 400;
            letter-spacing: 1px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            animation: slideDown 0.8s ease-out 0.2s both;
        }

        .login-cards-container {
            display: flex;
            gap: 1rem;
            justify-content: center;
            width: 100%;
        }

        .login-card {
            flex: 1;
            min-width: 140px;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-xl);
            padding: 1.5rem 1rem;
            cursor: pointer;
            transition: var(--transition-bounce);
            background: var(--card-bg);
            color: var(--text-main);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: var(--shadow-xl);
            position: relative;
            overflow: hidden;
            height: 180px;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
        }

        .login-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .login-card:hover::before {
            left: 100%;
        }

        .login-card:hover {
            transform: translateY(-8px) scale(1.02);
            background: var(--card-bg);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4);
            border-color: var(--primary-blue);
        }

        .login-card.passenger {
            animation: scaleIn 0.6s ease-out 0.4s both;
        }

        .login-card.staff {
            animation: scaleIn 0.6s ease-out 0.6s both;
        }

        .login-icon-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            transition: all 0.4s ease;
        }

        .login-card:hover .login-icon-wrapper {
            transform: rotate(10deg) scale(1.1);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
        }

        .login-card i {
            font-size: 1.75rem;
            color: #ffffff;
        }

        .login-card h4 {
            color: #1e293b;
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0;
            transition: color 0.3s ease;
        }

        .login-card:hover h4 {
            color: var(--primary-blue);
        }

        .login-card p {
            color: #64748b;
            font-size: 1rem;
            margin: 0;
            font-weight: 500;
        }

        body.fade-out {
            opacity: 0;
            transform: scale(0.95);
            transition: all 0.6s ease;
        }

        .floating-shapes {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
            z-index: 1;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.15) 0%, transparent 70%);
            animation: float 20s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 300px;
            height: 300px;
            top: 10%;
            left: 15%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 200px;
            height: 200px;
            top: 60%;
            right: 20%;
            animation-delay: 4s;
        }

        .shape:nth-child(3) {
            width: 150px;
            height: 150px;
            bottom: 20%;
            left: 25%;
            animation-delay: 8s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) translateX(0);
            }

            33% {
                transform: translateY(-30px) translateX(20px);
            }

            66% {
                transform: translateY(20px) translateX(-20px);
            }
        }

        @media (max-width: 768px) {
            .portal-title {
                font-size: 2.5rem;
                letter-spacing: 2px;
            }

            .portal-subtitle {
                font-size: 1rem;
            }

            .portal-box {
                padding: 2.5rem 1.5rem;
            }

            .login-card {
                min-width: 100%;
            }
        }

        /* ==========================================================================
           GOD-TIER SIGNATURE INTRO
           ========================================================================== */
        #splash-screen {
            position: fixed;
            inset: 0;
            background: #050505;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 10000;
            overflow: hidden;
            transition: opacity 1.5s cubic-bezier(1, 0, 0, 1);
            color: var(--text-heading);
        }

        /* Horizon Scan - Slow-Mo */
        .horizon-scan {
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent, #c0c0c0, transparent);
            opacity: 0;
            z-index: 5;
            animation: horizonSweep 3s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        @keyframes horizonSweep {
            0% {
                transform: scaleX(0);
                opacity: 0;
            }

            40% {
                transform: scaleX(1);
                opacity: 0.8;
            }

            100% {
                transform: scaleX(1.8);
                opacity: 0;
            }
        }

        /* Logo Construction - Slow-Mo */
        .splash-logo-container {
            position: relative;
            margin-bottom: 50px;
            transform: scale(0.9);
            opacity: 0;
            animation: logoConstruct 3s cubic-bezier(0.23, 1, 0.32, 1) 1.5s forwards;
        }

        .splash-logo-base {
            font-size: 12rem;
            color: var(--primary-blue);
            opacity: 0.1;
            /* Removed stroke for cleaner look */
            position: relative;
            z-index: 1;
        }

        .splash-logo-fill {
            position: absolute;
            inset: 0;
            font-size: 12rem;
            color: var(--primary-blue);
            z-index: 2;
            clip-path: inset(100% 0 0 0);
            animation: liquidFill 4s cubic-bezier(0.65, 0, 0.35, 1) 2.5s forwards;
            filter: none;
        }

        /* Simplified Logo Fill - No decorative glint */

        /* Typography Flow - Ethereal Stagger */
        .splash-title-container {
            display: flex;
            gap: 8px;
            perspective: 1200px;
        }

        .splash-char {
            color: var(--text-heading);
            font-size: 2.2rem;
            font-family: 'Poppins', sans-serif;
            opacity: 0;
            transform: rotateX(-90deg) translateZ(80px);
            font-weight: 200;
            text-transform: uppercase;
            text-shadow: var(--text-shadow-glow);
            filter: blur(8px);
        }

        /* Supernova Exit - Weighted */
        .supernova {
            position: absolute;
            width: 20px;
            height: 20px;
            background: radial-gradient(circle, #fff 0%, var(--primary-blue) 40%, transparent 70%);
            border-radius: 50%;
            opacity: 0;
            z-index: 100;
            pointer-events: none;
        }

        .supernova.burst {
            animation: supernovaBurst 2.5s cubic-bezier(0.19, 1, 0.22, 1) forwards;
        }

        /* Animations */
        @keyframes logoConstruct {
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes liquidFill {
            to {
                clip-path: inset(0% 0 0 0);
            }
        }

        @keyframes glintShift {
            0% {
                opacity: 0;
                mask-position: 200% 0;
            }

            30% {
                opacity: 1;
            }

            60% {
                opacity: 0;
                mask-position: -200% 0;
            }

            100% {
                opacity: 0;
            }
        }

        @keyframes charSignature {
            0% {
                opacity: 0;
                transform: rotateX(-90deg) translateZ(80px);
                font-weight: 200;
                letter-spacing: 25px;
                filter: blur(8px);
            }

            50% {
                opacity: 0.6;
                font-weight: 500;
                filter: blur(2px);
            }

            100% {
                opacity: 1;
                transform: rotateX(0deg) translateZ(0);
                font-weight: 800;
                letter-spacing: 6px;
                filter: blur(0);
            }
        }

        @keyframes supernovaBurst {
            0% {
                transform: scale(0);
                opacity: 0;
                filter: blur(0);
            }

            20% {
                opacity: 1;
            }

            100% {
                transform: scale(250);
                opacity: 1;
                filter: blur(60px);
            }
        }

        #splash-screen.super-fade {
            opacity: 0;
            pointer-events: none;
        }
    </style>
</head>

<body class="bg-movable bg-index bg-overlay">
    <!-- Intro Splash Screen -->
    <div id="splash-screen">
        <div class="horizon-scan"></div>
        <div class="splash-logo-container">
            <i class="bi bi-bus-front splash-logo-base"></i>
            <i class="bi bi-bus-front splash-logo-fill"></i>
        </div>
        <div class="splash-title-container" id="splash-title">
            <!-- Signature reveal chars -->
        </div>
        <div class="supernova" id="supernova"></div>
    </div>

    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top p-3" style="z-index: 100;">
        <div class="container-fluid justify-content-center">
            <div class="glass-nav px-4 py-2 rounded-pill d-flex gap-4 align-items-center"
                style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.2); box-shadow: 0 4px 30px rgba(0,0,0,0.1);">
                <a href="about.php" id="nav_about"
                    class="text-white text-decoration-none fw-light hover-glow small text-uppercase"
                    onclick="goToPage('about.php', this); return false;">About
                    us</a>
                <span class="text-white opacity-25">|</span>
                <a href="community.php" id="nav_community"
                    class="text-white text-decoration-none fw-light hover-glow small text-uppercase"
                    onclick="goToPage('community.php', this); return false;">Community</a>
                <span class="text-white opacity-25">|</span>
                <a href="creator.php" id="nav_creator"
                    class="text-white text-decoration-none fw-light hover-glow small text-uppercase"
                    onclick="goToPage('creator.php', this); return false;">Creator</a>
                <span class="text-white opacity-25">|</span>
                <a href="feedback.php" id="nav_feedback"
                    class="text-white text-decoration-none fw-light hover-glow small text-uppercase"
                    onclick="goToPage('feedback.php', this); return false;">Feedback</a>
                <span class="text-white opacity-25">|</span>
                <a href="settings.php" id="nav_settings" onclick="goToPage('settings.php', this); return false;"
                    class="text-white text-decoration-none fw-light hover-glow small text-uppercase">Settings</a>
            </div>
        </div>
    </nav>

    <style>
        .hover-glow:hover {
            color: #fff !important;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
            transform: translateY(-1px);
            transition: all 0.3s ease;
        }
    </style>


    <!-- Animated Background Circles/Squares -->
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

    <!-- Main Portal Container -->
    <div class="portal-container">
        <div class="portal-box">
            <div class="portal-header">
                <h1 class="portal-title high-contrast-glow">
                    <i class="bi bi-bus-front me-3"></i><span id="app_title">Smart Bus Portal</span>
                </h1>
                <p class="portal-subtitle high-contrast-glow" id="feature_subtitle">Real-time Bus Tracking & Attendance
                    Management</p>
            </div>

            <div class="login-cards-container">
                <!-- Passenger Login -->
                <div class="login-card passenger" onclick="goToPage('passenger_login.php', this)">
                    <div class="login-icon-wrapper">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h4 id="lbl_passenger">Passenger Portal</h4>

                </div>

                <!-- Staff Login -->
                <div class="login-card staff" onclick="goToPage('staff_district_selection.php', this)">
                    <div class="login-icon-wrapper">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <h4 id="lbl_staff">Staff Portal</h4>

                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/page-transitions.js"></script>
    <script src="assets/js/theme-manager.js?v=premium_polish_final"></script>
    <script>
        // Specific page logic can go here if needed, generic logic is in theme-manager.js

        function goToPage(url, element) {
            // Add active state if element passed
            if (element) {
                element.style.transform = "scale(0.95)";
                element.style.transition = "transform 0.1s";
            }
            // Short delay for the click feel, then transition
            setTimeout(() => {
                navigateWithTransition(url);
            }, 100);
        }

        // Prevent accidental navigation
        window.addEventListener('beforeunload', function () {
            document.body.classList.add("fade-out");
        });

        // Intro Animation Controller - Smart Detection (Refresh vs Navigate)
        document.addEventListener('DOMContentLoaded', function () {
            const splash = document.getElementById('splash-screen');
            const titleContainer = document.getElementById('splash-title');
            const supernova = document.getElementById('supernova');
            const titleText = "Smart Bus Portal";

            // Detect navigation type
            const navEntries = window.performance.getEntriesByType('navigation');
            const isReload = navEntries.length > 0 && navEntries[0].type === 'reload';

            // Only play intro if it's a REFRESH
            // Skip if it's a 'navigate' (covers clicking back to home)
            if (!isReload) {
                if (splash) splash.remove();
                return;
            }

            // Signature Reveal Characters - Ultra-Slow-Mo
            if (titleContainer) {
                titleText.split('').forEach((char, index) => {
                    const span = document.createElement('span');
                    span.textContent = char === ' ' ? '\u00A0' : char;
                    span.className = 'splash-char high-contrast-glow';
                    span.style.animation = `charSignature 2.5s cubic-bezier(0.23, 1, 0.32, 1) ${3.5 + (index * 0.12)}s forwards`;
                    titleContainer.appendChild(span);
                });
            }

            // Orchestrate God-Tier Slow-Mo Exit
            setTimeout(() => {
                if (supernova) supernova.classList.add('burst');

                setTimeout(() => {
                    if (splash) {
                        splash.classList.add('super-fade');
                        setTimeout(() => splash.remove(), 1500);
                    }
                }, 1200); // Fade start during supernova peak
            }, 8500); // Extended for the full "Ultra-Slow-Mo" story to play out
        });
    </script>
</body>

</html>