<?php
session_start();
require_once 'db.php';

if ($conn->connect_error) {
    die("Database connection failed");
}

$bus_id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM buses WHERE id = ?");
$stmt->bind_param("i", $bus_id);
$stmt->execute();
$bus = $stmt->get_result()->fetch_assoc();

if (!$bus) {
    die("Bus not found");
}

// Logic to filter out empty stops and shifts
$stops = [];
for ($i = 1; $i <= 9; $i++) {
    if (!empty($bus["stop$i"]))
        $stops[] = $bus["stop$i"];
}

$shifts = [];
for ($i = 1; $i <= 6; $i++) {
    if (!empty($bus["shift{$i}_time"]))
        $shifts[] = $bus["shift{$i}_time"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Details |
        <?php echo htmlspecialchars($bus['bus_number']); ?>
    </title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="assets/CSS/custom_style.css?v=20260202" rel="stylesheet">
    <script src="assets/js/theme-manager.js?v=20260202"></script>
    <script src="assets/js/font-color-loader.js"></script>

    <style>
        .details-card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
            padding: 40px;
            margin-top: 50px;
            margin-bottom: 50px;
            animation: fadeIn 0.8s ease-out;
            border: 1px solid var(--border-color);
            color: var(--text-main);
        }

        .details-card h1,
        .details-card h2,
        .details-card h3,
        .details-card h4,
        .details-card h5,
        .details-card h6 {
            color: var(--text-heading) !important;
        }

        .details-card p {
            color: var(--text-main) !important;
        }

        .details-card .text-muted {
            color: var(--text-main) !important;
            opacity: 0.7;
        }

        .bus-badge {
            font-size: 1rem;
            padding: 8px 16px;
            border-radius: 50px;
            margin-bottom: 20px;
            display: inline-block;
        }

        .stop-timeline {
            position: relative;
            padding-left: 30px;
            border-left: 3px solid var(--border-color);
            margin-left: 10px;
        }

        .stop-item {
            position: relative;
            padding-bottom: 25px;
        }

        .stop-item h6 {
            color: var(--text-heading) !important;
        }

        .stop-item::before {
            content: "";
            position: absolute;
            left: -38px;
            top: 5px;
            width: 14px;
            height: 14px;
            background: var(--primary-blue);
            border-radius: 50%;
            border: 3px solid var(--card-bg);
            box-shadow: 0 0 0 2px var(--primary-blue);
        }

        .shift-chip {
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            padding: 8px 15px;
            border-radius: 10px;
            margin-right: 10px;
            margin-bottom: 10px;
            display: inline-block;
            font-weight: 600;
            color: var(--text-main) !important;
        }

        .shift-chip small {
            color: var(--text-main) !important;
            opacity: 0.7;
        }

        .map-container {
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            margin-top: 10px;
        }

        .map-container iframe {
            width: 100%;
            height: 400px;
            border: none;
        }

        .btn-map-view {
            background: var(--primary-blue);
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-map-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.3);
            color: #fff;
        }
    </style>
</head>

<body class="bg-movable bg-view-fleet bg-overlay">
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

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="details-card">

                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <?php
                            $typeClass = 'bg-primary';
                            $typeStyle = '';
                            if ($bus['bus_type'] == 'Point-To-Point') {
                                $typeClass = '';
                                $typeStyle = 'background: #FFA500; color: white;';
                            }
                            if ($bus['bus_type'] == 'Route Bus')
                                $typeClass = 'bg-success';
                            ?>
                            <span class="bus-badge <?php echo $typeClass; ?>" 
                                style="<?php echo $typeStyle; ?>"
                                data-bus-type="<?php echo $bus['bus_type']; ?>">
                                <i class="bi bi-tag-fill me-2"></i>
                                <span id="bus_type_text"><?php echo strtoupper($bus['bus_type']); ?></span>
                            </span>
                            <h1 class="fw-bold mb-1">
                                <?php echo htmlspecialchars($bus['bus_number']); ?>
                            </h1>
                            <p class="text-muted fs-5"><i class="bi bi-geo-alt-fill me-2 text-danger"></i>
                                <?php echo htmlspecialchars($bus['route']); ?>
                            </p>
                        </div>
                        <a href="passenger_dashboard.php?district=<?php echo urlencode($bus['district']); ?>"
                            class="btn btn-outline-secondary rounded-pill">
                            <i class="bi bi-arrow-left me-2"></i><span id="btn_back">Back</span>
                        </a>
                    </div>

                    <div class="row mt-5">
                        <!-- Shifts -->
                        <div class="col-md-5 mb-4">
                            <h5 class="fw-bold mb-4" id="lbl_shift_timings"><i
                                    class="bi bi-clock-history me-2 text-primary"></i><span
                                    id="shift_timings_text">Shift Timings</span>
                            </h5>
                            <div class="shift-container">
                                <?php if (count($shifts) > 0): ?>
                                    <?php foreach ($shifts as $index => $time): ?>
                                        <div class="shift-chip">
                                            <small class="text-muted d-block">Shift
                                                <?php echo $index + 1; ?>
                                            </small>
                                            <?php echo date("h:i A", strtotime($time)); ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-muted">No shifts registered.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Route Grid -->
                        <div class="col-md-7">
                            <h5 class="fw-bold mb-4" id="lbl_route_stops"><i
                                    class="bi bi-signpost-2 me-2 text-success"></i><span id="route_stops_text">Route
                                    Stops</span></h5>
                            <div class="stop-timeline">
                                <?php foreach ($stops as $stop): ?>
                                    <div class="stop-item">
                                        <h6 class="mb-0 fw-bold">
                                            <?php echo htmlspecialchars($stop); ?>
                                        </h6>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Google Maps Route Section -->
                    <?php if (count($stops) >= 2): ?>
                    <div class="mt-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0" id="lbl_route_map"><i
                                    class="bi bi-map me-2 text-danger"></i><span
                                    id="route_map_text">Route Map</span></h5>
                            <?php
                            $origin = urlencode($stops[0] . ', Tamil Nadu, India');
                            $destination = urlencode($stops[count($stops) - 1] . ', Tamil Nadu, India');
                            $waypointsList = [];
                            for ($w = 1; $w < count($stops) - 1; $w++) {
                                $waypointsList[] = urlencode($stops[$w] . ', Tamil Nadu, India');
                            }
                            $waypointsStr = implode('|', $waypointsList);
                            $fullMapUrl = "https://www.google.com/maps/dir/" . implode('/', array_map(function($s) {
                                return urlencode($s . ', Tamil Nadu, India');
                            }, $stops));
                            ?>
                            <a href="<?php echo $fullMapUrl; ?>" target="_blank" class="btn-map-view">
                                <i class="bi bi-box-arrow-up-right"></i> <span id="btn_full_map">View Full Map</span>
                            </a>
                        </div>
                        <div class="map-container">
                            <?php
                            $mapSrc = "https://www.google.com/maps/embed?pb=!1m";
                            // Use the directions URL approach for the embed
                            $directionsUrl = "https://www.google.com/maps?saddr=" . $origin 
                                . "&daddr=" . $destination;
                            if (!empty($waypointsStr)) {
                                $directionsUrl .= "&waypoints=" . $waypointsStr;
                            }
                            $directionsUrl .= "&dirflg=d&output=embed";
                            ?>
                            <iframe
                                src="<?php echo $directionsUrl; ?>"
                                allowfullscreen
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                        <div class="text-center mt-3">
                            <small style="color: var(--text-main); opacity: 0.6;">
                                <i class="bi bi-info-circle me-1"></i>
                                <span id="map_note">Map shows approximate route between stops</span>
                            </small>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <script>
        // City name translations for route stops
        const cityTranslations = {
            ta: {
                'Madurai': 'மதுரை',
                'Chennai': 'சென்னை',
                'Trichy': 'திருச்சி',
                'Tiruchirappalli': 'திருச்சிராப்பள்ளி',
                'Dindugal': 'திண்டுக்கல்',
                'Dindigul': 'திண்டுக்கல்',
                'Coimbatore': 'கோயம்புத்தூர்',
                'Salem': 'சேலம்',
                'Tirunelveli': 'திருநெல்வேலி',
                'Erode': 'ஈரோடு',
                'Vellore': 'வேலூர்',
                'Thoothukudi': 'தூத்துக்குடி',
                'Thanjavur': 'தஞ்சாவூர்',
                'Nagercoil': 'நாகர்கோவில்',
                'Kanyakumari': 'கன்னியாகுமரி',
                'Tiruppur': 'திருப்பூர்',
                'Karur': 'கரூர்',
                'Cuddalore': 'கடலூர்',
                'Puducherry': 'புதுச்சேரி',
                'Pondicherry': 'பாண்டிச்சேரி'
            },
            hi: {
                'Madurai': 'मदुरै',
                'Chennai': 'चेन्नई',
                'Trichy': 'तिरुचि',
                'Tiruchirappalli': 'तिरुचिरापल्ली',
                'Dindugal': 'डिंडुगल',
                'Dindigul': 'डिंडुगल',
                'Coimbatore': 'कोयंबटूर',
                'Salem': 'सलेम',
                'Tirunelveli': 'तिरुनेलवेली',
                'Erode': 'इरोड',
                'Vellore': 'वेल्लोर',
                'Thoothukudi': 'थूथुकुडी',
                'Thanjavur': 'तंजावुर',
                'Nagercoil': 'नागरकोइल',
                'Kanyakumari': 'कन्याकुमारी',
                'Tiruppur': 'तिरुप्पुर',
                'Karur': 'करुर',
                'Cuddalore': 'कडलूर',
                'Puducherry': 'पुदुचेर्री',
                'Pondicherry': 'पांडिचेरी'
            }
        };

        // Translate bus type dynamically
        window.addEventListener('languageChanged', updateBusDetailsTranslations);

        function updateBusDetailsTranslations() {
            const t = window.currentTranslations;
            if (!t) return;

            const currentLang = localStorage.getItem('user_lang') || 'en';

            // Translate bus type badge
            const busTypeBadge = document.querySelector('[data-bus-type]');
            if (busTypeBadge) {
                const busType = busTypeBadge.getAttribute('data-bus-type');
                const busTypeText = document.getElementById('bus_type_text');
                if (busTypeText && busType) {
                    let translatedType = '';
                    if (busType === 'SETC') {
                        translatedType = t.setc_title || 'SETC';
                    } else if (busType === 'Point-To-Point') {
                        translatedType = t.ptp_title || 'POINT-TO-POINT';
                    } else if (busType === 'Route Bus') {
                        translatedType = t.route_bus_title || 'ROUTE BUS';
                    }
                    busTypeText.textContent = translatedType.toUpperCase();
                }
            }

            // Translate shift labels
            const shiftChips = document.querySelectorAll('.shift-chip small');
            shiftChips.forEach((chip, index) => {
                chip.textContent = (t.shift_label || 'Shift') + ' ' + (index + 1);
            });

            // Translate city names in route stops
            if (currentLang !== 'en' && cityTranslations[currentLang]) {
                const stopItems = document.querySelectorAll('.stop-item h6');
                stopItems.forEach(stopItem => {
                    const englishName = stopItem.textContent.trim();
                    // Try exact match first, then case-insensitive
                    let translatedName = cityTranslations[currentLang][englishName];
                    if (!translatedName) {
                        // Try case-insensitive match
                        const cityKey = Object.keys(cityTranslations[currentLang]).find(
                            key => key.toLowerCase() === englishName.toLowerCase()
                        );
                        if (cityKey) {
                            translatedName = cityTranslations[currentLang][cityKey];
                        }
                    }
                    if (translatedName) {
                        stopItem.textContent = translatedName;
                    }
                });
            }
        }

        // Run on page load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', updateBusDetailsTranslations);
        } else {
            updateBusDetailsTranslations();
        }
    </script>

</body>

</html>