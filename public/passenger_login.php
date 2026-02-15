<?php
// Simple session check if needed later
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Login | Smart Bus Portal</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <link href="assets/CSS/custom_style.css?v=professional_v4" rel="stylesheet">
    <script src="assets/js/theme-manager.js?v=professional_v4"></script>
    <script src="assets/js/font-color-loader.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            /* background managed by theme-manager */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card {
            background: var(--card-bg);
            /* Slight transparency */
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            border: 1px solid var(--border-color);
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
        }

        .login-image h2 {
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 2.5rem;
        }

        .login-image p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .brand-icon {
            font-size: 5rem;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 8px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            filter: contrast(1.2);
        }

        .input-group-text {
            background: var(--input-bg);
            border-right: none;
            color: var(--text-main);
            border-color: var(--border-color);
        }

        .form-control {
            border-left: none;
            padding: 12px;
            background: var(--input-bg);
            color: var(--input-text);
            border-color: var(--border-color);
        }

        .form-control:focus {
            box-shadow: none;
            background: white;
            border-color: #ced4da;
        }

        .btn-login {
            background: var(--primary-blue);
            border: none;
            padding: 14px;
            border-radius: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
            color: var(--btn-text-color, #ffffff);
        }

        .btn-login:hover {
            background: var(--primary-blue-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            color: var(--btn-text-color, #ffffff);
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

    <div class="login-card">
        <!-- Decoration Side -->
        <div class="login-image">
            <i class="bi bi-person-circle brand-icon"></i>
            <h2 id="lbl_login_title">Passenger Login</h2>
            <p id="lbl_login_desc">Access your journey details</p>
        </div>

        <!-- Form Side -->
        <div class="login-form-container position-relative">
            <!-- Back Button -->
            <a href="index.php"
                class="text-decoration-none text-secondary position-absolute bottom-0 start-50 translate-middle-x mb-4"
                style="font-size: 0.9rem;" id="btn_back_link">
                <i class="bi bi-arrow-left me-1"></i> <span id="btn_back">Back to Home</span>
            </a>

            <h3 class="fw-bold mb-1" id="formTitle">Welcome Back</h3>
            <p class="text-muted mb-4 small" id="formSubtitle">Sign in to track your bus instantly</p>

            <form action="passenger_auth_process.php" method="POST">
                <input type="hidden" name="action" id="actionInput" value="signin">

                <!-- Toggle Switch -->
                <div class="d-flex justify-content-center mb-4 mt-5">
                    <div class="btn-group bg-light rounded-pill p-1 border" role="group">
                        <button type="button" class="btn btn-primary rounded-pill px-4" id="btnSigninTab"
                            onclick="console.log('Sign In clicked'); toggleAuth('signin'); return false;"
                            style="color: var(--btn-text-color, #ffffff) !important;">Sign
                            In</button>
                        <button type="button" class="btn btn-light rounded-pill px-4 text-dark fw-bold"
                            id="btnSignupTab"
                            onclick="console.log('Sign Up clicked'); toggleAuth('signup'); return false;"
                            style="color: #212529 !important;">Sign
                            Up</button>
                    </div>
                </div>

                <!-- DYNAMIC FORM -->
                <div id="nameFieldContainer" style="display: none;">
                    <label class="form-label" id="lbl_name"
                        style="color: #ffffff !important; font-weight: 700 !important; opacity: 1 !important; background: rgba(0,0,0,0.3); padding: 4px 8px; border-radius: 4px;">PASSENGER
                        NAME</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" name="passenger_name" id="passengerNameInput"
                            placeholder="Enter your Name">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" id="lbl_mobile"
                        style="color: #ffffff !important; font-weight: 700 !important; opacity: 1 !important; background: rgba(0,0,0,0.3); padding: 4px 8px; border-radius: 4px;">MOBILE
                        NUMBER</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-phone"></i></span>
                        <input type="tel" class="form-control" name="mobile_number" id="mobileNumberInput"
                            placeholder="Enter 10-digit number" pattern="[0-9]{10}" required>
                    </div>
                </div>

                <!-- CAPTCHA Section -->
                <div class="mb-4" id="captchaSection" style="display: none;">
                    <label class="form-label" id="lbl_security_check"
                        style="color: #ffffff !important; font-weight: 700 !important; opacity: 1 !important; background: rgba(0,0,0,0.3); padding: 4px 8px; border-radius: 4px;">Security
                        Check</label>
                    <div class="d-flex align-items-center mb-2">
                        <!-- CAPTCHA Container -->
                        <div id="captcha-container" class="me-3 rounded overflow-hidden"
                            style="min-width: 200px; min-height: 60px;">
                            <?php include 'captcha_gen.php'; ?>
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="btn_refresh_captcha"
                            onclick="refreshCaptcha()">
                            <i class="bi bi-arrow-clockwise"></i> Refresh
                        </button>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                        <input type="text" class="form-control" name="captcha" id="captchaInput"
                            placeholder="Enter the code shown above" autocomplete="off">
                    </div>

                    <!-- Error Messages -->
                    <?php if (isset($_GET['error'])): ?>
                        <?php if ($_GET['error'] == 'invalid_captcha'): ?>
                            <div class="text-danger small mt-1" id="err_captcha"><i class="bi bi-exclamation-circle-fill"></i>
                                Invalid CAPTCHA code.
                            </div>
                        <?php elseif ($_GET['error'] == 'invalid_mobile'): ?>
                            <div class="text-danger small mt-1" id="err_mobile"><i class="bi bi-exclamation-circle-fill"></i>
                                Invalid Mobile Number.
                            </div>
                        <?php elseif ($_GET['error'] == 'user_not_found'): ?>
                            <div class="text-danger small mt-1" id="err_user_not_found"><i
                                    class="bi bi-exclamation-circle-fill"></i> User not found. Please
                                Sign Up.</div>
                        <?php elseif ($_GET['error'] == 'user_exists'): ?>
                            <div class="text-danger small mt-1" id="err_user_exists"><i
                                    class="bi bi-exclamation-circle-fill"></i> Account exists. Please
                                Sign In.</div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-login mb-4" id="submitBtn">
                    Sign In <i class="bi bi-arrow-right ms-2"></i>
                </button>

                <div class="text-center">
                    <span class="text-muted" id="lbl_admin_prompt">Are you an admin?</span>
                    <a href="platform_incharge_login.php" class="text-decoration-none fw-bold ms-1"
                        id="lnk_staff_login">Staff Login</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Define toggleAuth GLOBALLY before page renders so onclick handlers can access it
        window.toggleAuth = function (mode) {
            console.log('toggleAuth called with mode:', mode);

            const btnSignin = document.getElementById('btnSigninTab');
            const btnSignup = document.getElementById('btnSignupTab');
            const actionInput = document.getElementById('actionInput');
            const nameField = document.getElementById('nameFieldContainer');
            const nameInput = document.getElementById('passengerNameInput');
            const mobileInput = document.getElementById('mobileNumberInput');
            const captchaSection = document.getElementById('captchaSection');
            const captchaInput = document.getElementById('captchaInput');
            const submitBtn = document.getElementById('submitBtn');
            const title = document.getElementById('formTitle');
            const subtitle = document.getElementById('formSubtitle');

            if (!btnSignin || !btnSignup) {
                console.error('Buttons not found!');
                return;
            }

            if (mode === 'signup') {
                console.log('Switching to SIGNUP mode');
                actionInput.value = 'signup';
                nameField.style.display = 'block';
                nameInput.required = true;
                captchaSection.style.display = 'block';
                captchaInput.required = true;

                submitBtn.classList.remove('btn-primary');
                submitBtn.classList.add('btn-success');

                btnSignup.classList.remove('btn-light', 'text-dark');
                btnSignup.classList.add('btn-primary');
                btnSignup.style.color = 'var(--btn-text-color, #ffffff)';
                btnSignin.classList.add('btn-light', 'text-dark');
                btnSignin.classList.remove('btn-primary');
                btnSignin.style.color = '#212529';

                // Update text if translations available
                if (window.currentTranslations) {
                    const t = window.currentTranslations;
                    title.textContent = t.create_acc || "Create Account";
                    subtitle.textContent = t.join_now || "Join now to start tracking buses";
                    submitBtn.innerHTML = (t.btn_sign_up || "Sign Up") + ' <i class="bi bi-arrow-right ms-2"></i>';
                    btnSignin.textContent = t.btn_sign_in || "Sign In";
                    btnSignup.textContent = t.btn_sign_up || "Sign Up";
                }
            } else {
                console.log('Switching to SIGNIN mode');
                actionInput.value = 'signin';
                nameField.style.display = 'none';
                nameInput.required = false;
                captchaSection.style.display = 'none';
                captchaInput.required = false;

                submitBtn.classList.add('btn-primary');
                submitBtn.classList.remove('btn-success');

                btnSignin.classList.remove('btn-light', 'text-dark');
                btnSignin.classList.add('btn-primary');
                btnSignin.style.color = 'var(--btn-text-color, #ffffff)';
                btnSignup.classList.add('btn-light', 'text-dark');
                btnSignup.classList.remove('btn-primary');
                btnSignup.style.color = '#212529';

                // Update text if translations available
                if (window.currentTranslations) {
                    const t = window.currentTranslations;
                    title.textContent = t.welcome_back || "Welcome Back";
                    subtitle.textContent = t.signin_desc || "Sign in to track your bus instantly";
                    submitBtn.innerHTML = (t.btn_sign_in || "Sign In") + ' <i class="bi bi-arrow-right ms-2"></i>';
                    btnSignin.textContent = t.btn_sign_in || "Sign In";
                    btnSignup.textContent = t.btn_sign_up || "Sign Up";
                }
            }
        };
    </script>

    <script src="assets/js/page-transitions.js"></script>
    <script>
        // IMPORTANT: Attach languageChanged listener FIRST, before anything else
        // This ensures we catch the initial applyLanguage() call on page load
        window.addEventListener('languageChanged', () => {
            // Re-run toggle to update text when language changes matched to current state
            const actionInput = document.getElementById('actionInput');
            if (actionInput) {
                const currentMode = actionInput.value;
                toggleAuth(currentMode);
            }
        });

        // toggleAuth is now defined globally above, no need for duplicate

        // Auto-switch based on URL
        const urlParams = new URLSearchParams(window.location.search);

        // Wait for translations to be ready before initial toggle
        function initializeAuth() {
            if (urlParams.get('mode') === 'signup') {
                toggleAuth('signup');
            } else {
                // Default to signin to ensure state is correct
                toggleAuth('signin');
            }
        }

        // Run after a short delay to ensure translations are loaded
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                setTimeout(initializeAuth, 100);
            });
        } else {
            setTimeout(initializeAuth, 100);
        }

        function refreshCaptcha() {
            const container = document.getElementById('captcha-container');
            container.style.opacity = '0.5';

            fetch('captcha_gen.php?' + Math.random())
                .then(response => response.text())
                .then(html => {
                    container.innerHTML = html;
                    container.style.opacity = '1';
                })
                .catch(err => {
                    console.error('Failed to load CAPTCHA', err);
                    container.style.opacity = '1';
                });
        }
        }

        // FORCE LABEL VISIBILITY - Override any theme styles
        function forceLabelsVisible() {
            const labels = ['lbl_name', 'lbl_mobile', 'lbl_security_check'];
            labels.forEach(id => {
                const label = document.getElementById(id);
                if (label) {
                    label.style.setProperty('color', '#ffffff', 'important');
                    label.style.setProperty('background', 'rgba(0,0,0,0.4)', 'important');
                    label.style.setProperty('padding', '6px 12px', 'important');
                    label.style.setProperty('border-radius', '6px', 'important');
                    label.style.setProperty('display', 'inline-block', 'important');
                    label.style.setProperty('font-weight', '700', 'important');
                    label.style.setProperty('opacity', '1', 'important');
                }
            });
        }

        // Run immediately and after a delay to override theme-manager
        forceLabelsVisible();
        setTimeout(forceLabelsVisible, 100);
        setTimeout(forceLabelsVisible, 500);

        // Re-apply on language change
        window.addEventListener('languageChanged', forceLabelsVisible);
    </script>
</body>

</html>