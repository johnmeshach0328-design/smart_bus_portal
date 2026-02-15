<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Bus Portal | Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Poppins:wght@300;400;600;700&family=Roboto:wght@300;400;500;700&family=Open+Sans:wght@300;400;600;700&family=Montserrat:wght@300;400;600;700&family=Lato:wght@300;400;700&family=Raleway:wght@300;400;600;700&family=Nunito:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <link href="assets/CSS/custom_style.css?v=premium_polish_final" rel="stylesheet">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow-y: auto;
            font-family: 'Inter', sans-serif;
            color: #fff;
            padding: 2rem 0;
        }

        .content-box {
            background: var(--card-bg);
            backdrop-filter: blur(25px);
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

        /* Language Toggle */
        .language-toggle {
            display: inline-flex;
            background: rgba(255, 255, 255, 0.1);
            padding: 4px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .lang-btn {
            background: transparent;
            border: none;
            color: var(--text-main);
            opacity: 0.6;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .lang-btn.active {
            background: #ffffff !important;
            color: #0f172a !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Theme Grid */
        .theme-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .theme-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
        }

        .theme-card:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .theme-card.active {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--primary-blue) !important;
            box-shadow: 0 0 15px var(--primary-blue);
            transform: scale(1.05);
            color: #fff;
        }

        .theme-card.active .theme-preview {
            border: 2px solid #fff !important;
        }

        .theme-preview {
            width: 100%;
            height: 40px;
            border-radius: 8px;
            margin-bottom: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .section-label {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-main);
            opacity: 0.6;
            font-weight: 600;
            margin-bottom: 1rem;
            display: block;
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

    <div class="content-box">
        <a href="index.php" class="back-btn"><i class="bi bi-arrow-left"></i></a>

        <div class="d-flex align-items-center mb-5 pb-3 border-bottom border-light border-opacity-10">
            <i class="bi bi-sliders2 fs-2 me-3 text-info"></i>
            <h2 class="fw-bold m-0" id="page_title">Settings</h2>
        </div>

        <!-- Language Selection -->
        <div class="mb-5 text-center">
            <label class="section-label" id="lbl_lang_section">Language</label>
            <div class="language-toggle">
                <button onclick="applyLanguage('en')" class="lang-btn" id="btn_lang_en">English</button>
                <button onclick="applyLanguage('ta')" class="lang-btn" id="btn_lang_ta">தமிழ்</button>
                <button onclick="applyLanguage('hi')" class="lang-btn" id="btn_lang_hi">हिंदी</button>
            </div>
        </div>

        <!-- Theme Selection -->
        <div>
            <label class="section-label" id="lbl_theme_section">Interface Theme</label>
            <div class="theme-grid">
                <!-- Executive Gold -->
                <button onclick="applyTheme('executive')" class="theme-card" data-theme-id="executive">
                    <div class="theme-preview" style="background: linear-gradient(135deg, #1a1a1d, #3a3a3d);"></div>
                    <span>Executive</span>
                </button>

                <!-- Corporate Navy -->
                <button onclick="applyTheme('corporate')" class="theme-card" data-theme-id="corporate">
                    <div class="theme-preview" style="background: linear-gradient(135deg, #0a1e3d, #2563eb);"></div>
                    <span>Corporate</span>
                </button>

                <!-- Emerald Pro -->
                <button onclick="applyTheme('emerald')" class="theme-card" data-theme-id="emerald">
                    <div class="theme-preview" style="background: linear-gradient(135deg, #022c22, #065f46);"></div>
                    <span>Emerald</span>
                </button>

                <!-- Slate Minimal -->
                <button onclick="applyTheme('slate')" class="theme-card" data-theme-id="slate">
                    <div class="theme-preview" style="background: linear-gradient(135deg, #1e293b, #475569);"></div>
                    <span>Slate</span>
                </button>

                <!-- Platinum Silver -->
                <button onclick="applyTheme('platinum')" class="theme-card" data-theme-id="platinum">
                    <div class="theme-preview" style="background: linear-gradient(135deg, #18181b, #3f3f46);"></div>
                    <span>Platinum</span>
                </button>

                <!-- Sapphire -->
                <button onclick="applyTheme('sapphire')" class="theme-card" data-theme-id="sapphire">
                    <div class="theme-preview" style="background: linear-gradient(135deg, #172554, #1e40af);"></div>
                    <span>Sapphire</span>
                </button>

                <!-- Crimson -->
                <button onclick="applyTheme('crimson')" class="theme-card" data-theme-id="crimson">
                    <div class="theme-preview" style="background: linear-gradient(135deg, #450a0a, #991b1b);"></div>
                    <span>Crimson</span>
                </button>

                <!-- Onyx -->
                <button onclick="applyTheme('onyx')" class="theme-card" data-theme-id="onyx">
                    <div class="theme-preview" style="background: linear-gradient(135deg, #000000, #171717);"></div>
                    <span>Onyx</span>
                </button>

                <!-- Amber -->
                <button onclick="applyTheme('amber')" class="theme-card" data-theme-id="amber">
                    <div class="theme-preview" style="background: linear-gradient(135deg, #451a03, #92400e);"></div>
                    <span>Amber</span>
                </button>

                <!-- Arctic -->
                <button onclick="applyTheme('arctic')" class="theme-card" data-theme-id="arctic">
                    <div class="theme-preview" style="background: linear-gradient(135deg, #083344, #155e75);"></div>
                    <span>Arctic</span>
                </button>

                <!-- Professional Dark -->
                <button onclick="applyTheme('dark')" class="theme-card" data-theme-id="dark">
                    <div class="theme-preview" style="background: linear-gradient(135deg, #0f172a, #1e293b);"></div>
                    <span>Pro Dark</span>
                </button>

                <!-- Midnight Pro -->
                <button onclick="applyTheme('midnight')" class="theme-card" data-theme-id="midnight">
                    <div class="theme-preview" style="background: linear-gradient(135deg, #1e1b4b, #312e81);"></div>
                    <span>Midnight</span>
                </button>

                <!-- Ocean Deep -->
                <button onclick="applyTheme('ocean')" class="theme-card" data-theme-id="ocean">
                    <div class="theme-preview" style="background: linear-gradient(135deg, #0c4a6e, #0284c7);"></div>
                    <span>Ocean</span>
                </button>

                <!-- Sunset -->
                <button onclick="applyTheme('sunset')" class="theme-card" data-theme-id="sunset">
                    <div class="theme-preview" style="background: linear-gradient(135deg, #7c2d12, #f97316);"></div>
                    <span>Sunset</span>
                </button>

                <!-- Forest -->
                <button onclick="applyTheme('forest')" class="theme-card" data-theme-id="forest">
                    <div class="theme-preview" style="background: linear-gradient(135deg, #064e3b, #10b981);"></div>
                    <span>Forest</span>
                </button>

                <!-- Royal -->
                <button onclick="applyTheme('royal')" class="theme-card" data-theme-id="royal">
                    <div class="theme-preview" style="background: linear-gradient(135deg, #4c1d95, #7c3aed);"></div>
                    <span>Royal</span>
                </button>

                <!-- Berry -->
                <button onclick="applyTheme('berry')" class="theme-card" data-theme-id="berry">
                    <div class="theme-preview" style="background: linear-gradient(135deg, #831843, #db2777);"></div>
                    <span>Berry</span>
                </button>

                <!-- Graphite -->
                <button onclick="applyTheme('graphite')" class="theme-card" data-theme-id="graphite">
                    <div class="theme-preview" style="background: linear-gradient(135deg, #18181b, #52525b);"></div>
                    <span>Graphite</span>
                </button>
            </div>
        </div>
    </div>

    <script src="assets/js/page-transitions.js"></script>
    <script src="assets/js/font-color-loader.js"></script>
    <script src="assets/js/theme-manager.js?v=premium_polish_final"></script>
</body>

</html>