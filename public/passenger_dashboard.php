<?php
session_start();
require_once 'db.php';

// Strict Session Check
if (!isset($_SESSION['passenger_id'])) {
    header("Location: passenger_login.php");
    exit();
}

// Old captcha logic removed as it's now handled in auth process

if ($conn->connect_error) {
    die("Connection failed");
}

function time_ago($timestamp)
{
    if (!$timestamp)
        return "Never";
    $time_ago = strtotime($timestamp);
    $cur_time = time();
    $time_elapsed = $cur_time - $time_ago;
    $seconds = $time_elapsed;
    $minutes = round($time_elapsed / 60);
    $hours = round($time_elapsed / 3600);
    $days = round($time_elapsed / 86400);
    $weeks = round($time_elapsed / 604800);
    $months = round($time_elapsed / 2600640);
    $years = round($time_elapsed / 31207680);

    if ($seconds <= 5)
        return "Just now";
    else if ($seconds < 60)
        return "$seconds secs ago";
    else if ($minutes <= 0)
        return "less than a min ago";
    else if ($minutes <= 60)
        return ($minutes == 1) ? "one min ago" : "$minutes mins ago";
    else if ($hours <= 24)
        return ($hours == 1) ? "an hour ago" : "$hours hrs ago";
    else if ($days <= 7)
        return ($days == 1)
            ? "yesterday" : "$days days ago";
    else if ($weeks <= 4.3)
        return ($weeks == 1) ? "a week ago" : "$weeks weeks ago";
    else if ($months <= 12)
        return ($months == 1) ? "a month ago" : "$months months ago";
    else
        return ($years == 1)
            ? "one year ago" : "$years years ago";
}
$selected_district = $_GET['district'] ?? '';
$selected_bus_type = $_GET['type'] ?? ''; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Dashboard | Smart Bus Portal</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- External CSS -->
    <link href="assets/CSS/custom_style.css?v=premium_polish_final" rel="stylesheet">
    <!-- External JS -->
    <script src="assets/JS/theme-manager.js?v=premium_polish_final"></script>
    <script src="assets/js/font-color-loader.js"></script>

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
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-xl);
            padding: 40px;
            box-shadow: var(--shadow-2xl);
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
            background: var(--input-bg);
            border-radius: var(--border-radius-lg);
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition-bounce);
            border: 1px solid var(--border-color);
            text-decoration: none;
            color: var(--text-main);
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
            /* Slightly smaller icon */
            color: var(--primary-blue);
            margin-bottom: 10px;
            display: block;
        }

        .district-card h5 {
            font-weight: 700;
            margin: 0;
            font-size: 1rem;
            /* Better base size */
            word-wrap: break-word;
            /* Handle long words */
            overflow-wrap: break-word;
            hyphens: auto;
            width: 100%;
        }

        .table-custom {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            --bs-table-bg: var(--card-bg) !important;
            --bs-table-color: var(--text-main) !important;
            --bs-table-border-color: var(--border-color) !important;
            --bs-table-hover-bg: rgba(255, 255, 255, 0.05) !important;
            --bs-table-hover-color: var(--text-main) !important;
            color: var(--text-main) !important;
            border: 1px solid var(--border-color);
        }

        .table-custom thead {
            background: var(--primary-blue) !important;
            color: white !important;
            border-bottom: 2px solid var(--border-color);
        }

        .table-custom thead th {
            background: var(--primary-blue) !important;
            color: white !important;
        }

        .table-custom tbody tr {
            border-color: var(--border-color);
            background: var(--card-bg) !important;
        }

        .table-custom tbody td {
            padding: 1rem;
            color: var(--text-main) !important;
            background: var(--card-bg) !important;
            border-color: var(--border-color) !important;
        }

        .table-custom tbody tr:hover td {
            background: rgba(255, 255, 255, 0.05) !important;
        }

        .district-scroll-container {
            max-height: 500px;
            overflow-y: auto;
            padding: 10px;
            scrollbar-width: thin;
            scrollbar-color: var(--primary-blue) #f0f0f0;
        }

        .district-scroll-container::-webkit-scrollbar {
            width: 6px;
        }

        .district-scroll-container::-webkit-scrollbar-thumb {
            background-color: var(--primary-blue);
            border-radius: 10px;
        }

        .badge-type {
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Search Bar Styles */
        .search-container {
            position: relative;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .search-input {
            width: 100%;
            padding: 15px 50px 15px 25px;
            border-radius: 50px;
            border: 1px solid var(--border-color);
            background: var(--input-bg);
            color: var(--text-main);
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.2);
            transform: translateY(-2px);
        }

        .search-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-main);
            opacity: 0.5;
            font-size: 1.2rem;
            pointer-events: none;
        }

        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 20px;
            right: 20px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 15px;
            margin-top: 10px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            z-index: 1000;
            opacity: 0;
            transform: translateY(-10px);
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .search-suggestions.active {
            opacity: 1;
            transform: translateY(0);
            visibility: visible;
        }

        .suggestion-item {
            padding: 12px 20px;
            cursor: pointer;
            transition: background 0.2s;
            color: var(--text-main);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
        }

        .suggestion-item:last-child {
            border-bottom: none;
        }

        .suggestion-item:hover {
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary-blue);
        }

        .suggestion-item i {
            margin-right: 10px;
            opacity: 0.7;
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
    <nav class="navbar navbar-expand-lg navbar-dark border-bottom border-light border-opacity-10 backdrop-blur"
        style="background: rgba(0,0,0,0.3);">
        <div class="container">
            <a class="navbar-brand fw-bold" href="passenger_dashboard.php">
                <i class="bi bi-bus-front me-2"></i><span id="app_title">SMART BUS</span>
            </a>
            <div class="ms-auto">
                <a href="index.php" class="btn btn-outline-light btn-sm rounded-pill px-4" id="btn_logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="dashboard-container">

        <?php if (!$selected_district): ?>
            <!-- District Selection Screen -->
            <div class="glass-panel text-center">
                <h2 class="fw-bold mb-2" id="dist_title">Select Your District</h2>
                <p class="text-muted mb-4" id="dist_desc">Choose from all 38 districts across Tamil Nadu</p>

                <!-- Fuzzy Search Bar -->
                <div class="search-container">
                    <input type="text" id="districtSearch" class="search-input" placeholder="Search for a district (e.g. Madurai)..." autocomplete="off">
                    <i class="bi bi-search search-icon"></i>
                    <div id="searchSuggestions" class="search-suggestions"></div>
                </div>

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
                                <a href="?district=<?php echo $d; ?>" class="district-card py-3">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <h5>
                                        <span data-translate-district="<?php echo $key; ?>"><?php echo $d; ?></span>
                                    </h5>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        <?php else: ?>

            <?php if (!$selected_bus_type): ?>
                <!-- Bus Type Selection Screen -->
                <div class="glass-panel text-center">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h3 class="fw-bold mb-0" id="select_bus_type">Select Bus Type</h3>
                            <p class="text-muted mb-0"><?php echo htmlspecialchars($selected_district); ?> District</p>
                        </div>
                        <a href="passenger_dashboard.php" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="bi bi-arrow-left me-2"></i><span id="change_district">Change District</span>
                        </a>
                    </div>

                    <div class="row g-4 mt-3">
                        <!-- SETC Card -->
                        <div class="col-md-4">
                            <a href="?district=<?php echo urlencode($selected_district); ?>&type=SETC"
                                class="text-decoration-none">
                                <div class="custom-card" style="border-top: 4px solid #0d6efd;">
                                    <i class="bi bi-bus-front-fill" style="font-size: 4rem; color: var(--primary-blue);"></i>
                                    <h3 class="mt-3 mb-2" id="setc_title" style="color: var(--text-heading);">SETC</h3>
                                    <p class="mb-0" style="color: var(--text-main); opacity: 0.7;" id="setc_desc">State Express Transport</p>
                                    <div class="mt-3">
                                        <span class="badge" style="background: var(--primary-blue); color: #fff; font-weight: 600;"
                                            id="view_buses_1">View Buses</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Point-To-Point Card -->
                        <div class="col-md-4">
                            <a href="?district=<?php echo urlencode($selected_district); ?>&type=Point-To-Point"
                                class="text-decoration-none">
                                <div class="custom-card" style="border-top: 4px solid #ffc107;">
                                    <i class="bi bi-signpost-split-fill"
                                        style="font-size: 4rem; color: var(--primary-blue);"></i>
                                    <h3 class="mt-3 mb-2" id="ptp_title" style="color: var(--text-heading);">Point-To-Point</h3>
                                    <p class="mb-0" style="color: var(--text-main); opacity: 0.7;" id="ptp_desc">Direct Route Service</p>
                                    <div class="mt-3">
                                        <span class="badge" style="background: #ff9800; color: #000000; font-weight: 600;"
                                            id="view_buses_2">View Buses</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Route Bus Card -->
                        <div class="col-md-4">
                            <a href="?district=<?php echo urlencode($selected_district); ?>&type=Route Bus"
                                class="text-decoration-none">
                                <div class="custom-card" style="border-top: 4px solid #198754;">
                                    <i class="bi bi-map-fill" style="font-size: 4rem; color: var(--primary-blue);"></i>
                                    <h3 class="mt-3 mb-2" id="route_bus_title" style="color: var(--text-heading);">Route Bus</h3>
                                    <p class="mb-0" style="color: var(--text-main); opacity: 0.7;" id="route_bus_desc">Multiple Stop Service</p>
                                    <div class="mt-3">
                                        <span class="badge" style="background: #4caf50; color: #fff; font-weight: 600;"
                                            id="view_buses_3">View Buses</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            <?php else: ?>
                <!-- Bus List for Selected Type and District -->
                <div class="glass-panel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h3 class="fw-bold mb-0"><?php echo htmlspecialchars($selected_bus_type); ?> Buses</h3>
                            <p class="text-muted mb-0"><?php echo htmlspecialchars($selected_district); ?> District</p>
                        </div>
                        <div>
                            <a href="?district=<?php echo urlencode($selected_district); ?>"
                                class="btn btn-outline-secondary rounded-pill px-3 me-2">
                                <i class="bi bi-arrow-left me-1"></i>Back
                            </a>
                            <a href="passenger_dashboard.php" class="btn btn-primary rounded-pill px-3">
                                <i class="bi bi-house me-1"></i>Home
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-custom align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th>Bus Number</th>
                                    <th>Route</th>
                                    <th>Live Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $today = date('Y-m-d');
                                $stmt = $conn->prepare("SELECT b.*, a.status as attendance_status, a.detailed_status, a.updated_at 
                                                      FROM buses b 
                                                      LEFT JOIN attendance a ON b.id = a.bus_id AND a.attendance_date = ?
                                                      WHERE b.district = ? AND b.bus_type = ?");
                                $stmt->bind_param("sss", $today, $selected_district, $selected_bus_type);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $i = 1;

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $typeClass = 'bg-primary';
                                        if ($row['bus_type'] == 'Point-To-Point')
                                            $typeClass = 'bg-warning text-dark';
                                        if ($row['bus_type'] == 'Route Bus')
                                            $typeClass = 'bg-success';

                                        // Status badge logic
                                        $statusText = $row['detailed_status'] ?? "Scheduled";
                                        $statusClass = "bg-secondary";

                                        // AUTO-DELAY LOGIC: If current time > any shift time and NOT departured
                                        $currentTime = date('H:i');
                                        $shifts = [$row['shift1_time'], $row['shift2_time'], $row['shift3_time'], $row['shift4_time'], $row['shift5_time'], $row['shift6_time']];
                                        $anyShiftPassed = false;
                                        foreach ($shifts as $st) {
                                            if (!empty($st) && $currentTime > $st) {
                                                $anyShiftPassed = true;
                                            }
                                        }

                                        if ($row['attendance_status'] == 'Present') {
                                            $statusClass = "bg-success";
                                            // Auto-convert to Delayed if time passed and not departured OR arrived
                                            if ($anyShiftPassed && $statusText != 'Departured' && $statusText != 'Delayed' && $statusText != 'Arrived') {
                                                $statusText = 'Delayed';
                                            }

                                            if ($statusText == 'Delayed')
                                                $statusClass = "bg-warning text-dark";
                                            if ($statusText == 'not available due to problem')
                                                $statusClass = "bg-danger";
                                        } elseif ($row['attendance_status'] == 'Absent') {
                                            $statusText = "Not Available Today";
                                            $statusClass = "bg-danger";
                                        }

                                        $timeAgo = isset($row['updated_at']) ? time_ago($row['updated_at']) : '';

                                        echo "<tr>";
                                        echo "<td>" . $i++ . "</td>";
                                        echo "<td><span class='badge badge-type $typeClass'>" . $row['bus_type'] . "</span></td>";
                                        echo "<td class='fw-bold'>" . $row['bus_number'] . "</td>";
                                        echo "<td>" . $row['route'] . "</td>";
                                        echo "<td>
                                                <span class='badge rounded-pill $statusClass'>$statusText</span><br>
                                                <small class='text-muted' style='font-size:0.7rem;'>$timeAgo</small>
                                              </td>";
                                        echo "<td class='text-end'><a href='bus_details.php?id=" . $row['id'] . "' class='btn btn-sm btn-outline-primary rounded-pill px-3'>View Details</a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center py-4 text-muted'>No buses currently registered in this district.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>

    </div>

    <!-- Chatbot FAB -->
    <a href="bus_chat_bot.php"
        class="btn btn-primary rounded-circle shadow-lg d-flex align-items-center justify-content-center position-fixed"
        style="bottom: 30px; right: 30px; width: 60px; height: 60px; z-index: 1000; transition: transform 0.3s;"
        onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"
        title="Bus Assistant Chatbot">
        <i class="bi bi-chat-dots-fill" style="font-size: 1.5rem;"></i>
    </a>

    <!-- Page Transitions -->
    <script src="assets/js/page-transitions.js"></script>

    <!-- Fuzzy Search Logic -->
    <script>
        const searchInput = document.getElementById('districtSearch');
        const suggestionsBox = document.getElementById('searchSuggestions');
        let debounceTimer;

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                const query = this.value.trim();

                if (query.length < 2) {
                    suggestionsBox.classList.remove('active');
                    suggestionsBox.innerHTML = '';
                    return;
                }

                debounceTimer = setTimeout(() => {
                    fetch(`search_handler.php?q=${encodeURIComponent(query)}`) // Use ./search_handler.php since we're in public
                        .then(response => response.json())
                        .then(data => {
                            suggestionsBox.innerHTML = '';
                            if (data.status === 'success' && data.suggestions.length > 0) {
                                // Add "Did you mean?" header if no exact match
                                if (!data.exact_match) {
                                    const header = document.createElement('div');
                                    header.className = 'p-2 text-start text-muted small bg-light bg-opacity-10';
                                    header.innerHTML = '<i class="bi bi-lightbulb me-2"></i>Did you mean:';
                                    suggestionsBox.appendChild(header);
                                }

                                data.suggestions.forEach(loc => {
                                    const item = document.createElement('div');
                                    item.className = 'suggestion-item';
                                    item.innerHTML = `<i class="bi bi-geo-alt"></i>${loc}`;
                                    item.onclick = () => {
                                        // Redirect to district page
                                        window.location.href = `passenger_dashboard.php?district=${encodeURIComponent(loc)}`;
                                    };
                                    suggestionsBox.appendChild(item);
                                });
                                suggestionsBox.classList.add('active');
                            } else {
                                suggestionsBox.classList.remove('active');
                            }
                        })
                        .catch(err => console.error('Search error:', err));
                }, 300); // 300ms debounce
            });

            // Close suggestions on click outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                    suggestionsBox.classList.remove('active');
                }
            });
        }
    </script>
</body>

</html>