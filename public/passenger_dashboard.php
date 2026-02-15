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
$selected_bus_type = $_GET['type'] ?? '';

// Fetch Emergency Messages for the selected district
$alert_messages = [];
if (!empty($selected_district)) {
    $stmt = $conn->prepare("SELECT * FROM district_messages WHERE district = ? AND expires_at > NOW() ORDER BY created_at DESC");
    $stmt->bind_param("s", $selected_district);
    $stmt->execute();
    $res = $stmt->get_result();
    while($row = $res->fetch_assoc()) {
        $alert_messages[] = $row;
    }
}
?>
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

        /* --- Emergency Modal Styles --- */
        .modal-emergency .modal-header {
            background: linear-gradient(135deg, #dc3545 0%, #a71d2a 100%);
            color: white;
            border-bottom: none;
        }
        .modal-emergency .modal-content {
            border: none;
            border-radius: 15px;
            overflow: hidden;
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
            background: rgba(255, 255, 255, 0.05) !important;
            color: var(--primary-blue) !important;
            border-bottom: 2px solid var(--primary-blue);
        }

        .table-custom thead th {
            background: transparent !important;
            color: var(--primary-blue) !important;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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
            <div class="ms-auto d-flex align-items-center gap-2">
                <?php if ($selected_district): ?>
                    <a href="passenger_dashboard.php" class="btn btn-outline-light btn-sm rounded-pill px-3">
                        <i class="bi bi-arrow-left me-1"></i>Change District
                    </a>
                <?php endif; ?>
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
            
            <?php 
            $search_dest = $_GET['search_dest'] ?? '';
            if (!$selected_bus_type && empty($search_dest)): 
            ?>
                <!-- Bus Type Selection Screen -->
                <div class="glass-panel text-center">
                    <div class="mb-4"> <!-- Centered Title Container -->
                        <h3 class="fw-bold mb-0" id="select_bus_type">Select Bus Type</h3>
                        <p class="text-muted mb-0"><?php echo htmlspecialchars($selected_district); ?> District</p>
                    </div>
                        
                    <!-- Search Form for Destination (Moved below header) -->
                    <div class="d-flex justify-content-center mb-4">
                        <form action="" method="GET" class="d-flex position-relative flex-grow-1" style="max-width: 600px;">
                            <input type="hidden" name="district" value="<?php echo htmlspecialchars($selected_district); ?>">
                            <input type="text" name="search_dest" class="form-control rounded-pill ps-4 pe-5" 
                                placeholder="Search destination (e.g. Thoothukudi)..." 
                                value="<?php echo htmlspecialchars($_GET['search_dest'] ?? ''); ?>"
                                required style="background: var(--input-bg); border-color: var(--border-color); color: var(--text-main);">
                            <button type="submit" class="btn position-absolute end-0 top-0 h-100 rounded-pill px-3" style="border: none; background: transparent; color: var(--primary-blue);">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>

                    <div class="row g-4 mt-3">
                        <!-- SETC Card -->
                        <div class="col-md-4">
                            <a href="?district=<?php echo urlencode($selected_district); ?>&type=SETC"
                                class="text-decoration-none">
                                <div class="custom-card" style="border-top: 4px solid #0d6efd;">
                                    <i class="bi bi-bus-front-fill" style="font-size: 4rem; color: var(--text-main) !important;"></i>
                                    <h3 class="mt-3 mb-2" id="setc_title" style="color: var(--text-heading);">SETC</h3>
                                    <p class="mb-0" style="color: var(--text-main); opacity: 0.7;" id="setc_desc">State Express Transport</p>
                                    <div class="mt-3">
                                        <span class="badge" style="background: transparent; border: 2px solid var(--primary-blue); color: var(--text-main); font-weight: 700;"
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
                                        <span class="badge" style="background: transparent; border: 2px solid var(--primary-blue); color: var(--text-main); font-weight: 700;"
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
                                        <span class="badge" style="background: transparent; border: 2px solid var(--primary-blue); color: var(--text-main); font-weight: 700;"
                                            id="view_buses_3">View Buses</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            <?php elseif (!empty($search_dest)): ?>
                <!-- SEARCH RESULTS SCREEN -->
                <div class="glass-panel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h3 class="fw-bold mb-0">Search Results</h3>
                            <p class="text-muted mb-0">Buses from/via <strong><?php echo htmlspecialchars($selected_district); ?></strong> to <strong><?php echo htmlspecialchars($search_dest); ?></strong></p>
                        </div>
                        <div>
                            <a href="?district=<?php echo urlencode($selected_district); ?>" class="btn btn-outline-secondary rounded-pill px-3">
                                <i class="bi bi-x-lg me-1"></i>Clear Search
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-custom align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Type</th>
                                    <th>Bus Number</th>
                                    <th>Route</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $s_term = "%" . $conn->real_escape_string($search_dest) . "%";
                                $curr_dist = $conn->real_escape_string($selected_district);
                                
                                // Logic:
                                // 1. Bus originates from selected_district OR passes through it (stop match)
                                // 2. Bus goes to searched destination (route match or stop match)
                                $sql = "SELECT b.*, a.status as attendance_status, a.detailed_status, a.updated_at 
                                      FROM buses b 
                                      LEFT JOIN attendance a ON b.id = a.bus_id AND a.attendance_date = CURDATE()
                                      WHERE 
                                      (district = ? OR stop1 = ? OR stop2 = ? OR stop3 = ? OR stop4 = ? OR stop5 = ? OR stop6 = ? OR stop7 = ? OR stop8 = ?)
                                      AND 
                                      (route LIKE ? OR stop1 LIKE ? OR stop2 LIKE ? OR stop3 LIKE ? OR stop4 LIKE ? OR stop5 LIKE ? OR stop6 LIKE ? OR stop7 LIKE ? OR stop8 LIKE ? OR stop9 LIKE ?)";
                                
                                $stmt = $conn->prepare($sql);
                                // Bind: 9 district checks + 10 destination checks = 19 params
                                $stmt->bind_param("sssssssssssssssssss", 
                                    $curr_dist, $curr_dist, $curr_dist, $curr_dist, $curr_dist, $curr_dist, $curr_dist, $curr_dist, $curr_dist,
                                    $s_term, $s_term, $s_term, $s_term, $s_term, $s_term, $s_term, $s_term, $s_term, $s_term
                                );
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $i = 1;

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        // Type Badge
                                        $typeClass = 'bg-primary';
                                        if ($row['bus_type'] == 'Point-To-Point') $typeClass = 'bg-warning text-dark';
                                        if ($row['bus_type'] == 'Route Bus') $typeClass = 'bg-success';
                                        if ($row['bus_type'] == 'SETC') $typeClass = 'bg-primary'; // Explicitly blue for SETC

                                        // Status Logic (Copy from below)
                                        $statusText = $row['detailed_status'] ?? "Scheduled";
                                        $statusClass = "bg-secondary";
                                        if ($row['attendance_status'] == 'Present') {
                                            $statusClass = "bg-success";
                                            if ($statusText == 'Delayed') $statusClass = "bg-warning text-dark";
                                            if ($statusText == 'not available due to problem') $statusClass = "bg-danger";
                                        } elseif ($row['attendance_status'] == 'Absent') {
                                            $statusText = "Not Available";
                                            $statusClass = "bg-danger";
                                        }

                                        // Highlight "Via" note if origin != current district
                                        $viaNote = "";
                                        if ($row['district'] != $selected_district) {
                                            $viaNote = "<br><small class='text-warning'><i class='bi bi-info-circle me-1'></i>Via " . htmlspecialchars($selected_district) . "</small>";
                                        }

                                        echo "<tr>";
                                        echo "<td>" . $i++ . "</td>";
                                        echo "<td><span class='badge badge-type $typeClass'>" . $row['bus_type'] . "</span></td>";
                                        echo "<td class='fw-bold'>" . $row['bus_number'] . "</td>";
                                        echo "<td>" . $row['route'] . $viaNote . "</td>";
                                        echo "<td><span class='badge rounded-pill $statusClass'>$statusText</span></td>";
                                        echo "<td class='text-end'><a href='bus_details.php?id=" . $row['id'] . "' class='btn btn-sm btn-outline-primary rounded-pill px-3'>View</a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center py-5 text-muted'>
                                        <i class='bi bi-search display-1 d-block mb-3 opacity-25'></i>
                                        No buses found going to <strong>" . htmlspecialchars($search_dest) . "</strong> from/via " . htmlspecialchars($selected_district) . ".
                                    </td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
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

    <?php if ($selected_district): ?>
    <!-- Chatbot FAB -->
    <a href="bus_chat_bot.php?district=<?php echo urlencode($selected_district); ?>"
        class="btn btn-primary rounded-circle shadow-lg d-flex align-items-center justify-content-center position-fixed"
        style="bottom: 30px; right: 30px; width: 60px; height: 60px; z-index: 1000; transition: transform 0.3s;"
        onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"
        title="Bus Assistant Chatbot">
        <i class="bi bi-chat-dots-fill" style="font-size: 1.5rem;"></i>
    </a>
    <?php endif; ?>

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
    
    <!-- Emergency Alert Modal -->
    <?php if (!empty($alert_messages)): ?>
    <style>
        .premium-modal {
            z-index: 10055 !important;
        }
        .premium-modal .modal-backdrop {
            z-index: 10050 !important;
        }
        .premium-modal .modal-content {
            border: none;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            font-family: 'Poppins', sans-serif;
        }
        .premium-modal .modal-header {
            background: #ffffff;
            border-bottom: 1px solid #f3f4f6;
            padding: 24px 32px;
            display: flex;
            align-items: center;
        }
        .premium-modal .modal-title {
            font-weight: 700;
            color: #000000 !important;
            font-size: 1.35rem;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .premium-modal .btn-close {
            background-color: #f3f4f6;
            border-radius: 50%;
            padding: 12px;
            opacity: 1;
            transition: all 0.2s;
            box-shadow: none !important;
        }
        .premium-modal .btn-close:hover {
            background-color: #e5e7eb;
            transform: rotate(90deg);
        }
        .premium-modal .modal-body {
            background: #f9fafb;
            padding: 32px;
            max-height: 65vh;
            overflow-y: auto;
        }
        .alert-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 0;
            margin-bottom: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            display: flex;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .alert-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
        }
        .alert-icon-box {
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
            width: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
        }
        .alert-content {
            padding: 24px;
            flex: 1;
        }
        .alert-badge {
            background: #ffecec;
            color: #cc0000;
            padding: 8px 16px;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 800; /* Extra Bold */
            letter-spacing: 0.05em;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            border: 2px solid #ffcccc;
        }
        .pulsing-dot {
            width: 10px;
            height: 10px;
            background-color: #cc0000;
            border-radius: 50%;
            position: relative;
        }
        .pulsing-dot::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-color: #cc0000;
            border-radius: 50%;
            animation: pulse-ring 1.5s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }
        @keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 1; }
            100% { transform: scale(2.4); opacity: 0; }
        }
        .alert-timestamp {
            font-size: 0.95rem;
            color: #000000 !important; /* Force Black */
            font-weight: 700;
        }
        .alert-text {
            font-size: 1.25rem; /* Larger */
            color: #000000 !important; /* Force PURE BLACK text */
            line-height: 1.5;
            font-weight: 700; /* Bold */
            margin: 0;
            font-family: 'Arial', sans-serif; /* Standard readable font */
        }
        .modal-footer {
            background: white;
            border-top: 1px solid #f3f4f6;
            padding: 20px 32px;
            justify-content: flex-end;
        }
        .btn-acknowledge {
            background: #000000;
            color: white;
            border-radius: 12px;
            padding: 12px 32px;
            font-weight: 600;
            border: none;
            transition: all 0.2s;
            font-size: 1rem;
        }
        .btn-acknowledge:hover {
            background: #333333;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
    </style>

    <div class="modal fade premium-modal" id="emergencyModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <div class="bg-danger bg-opacity-10 p-2 rounded-circle text-danger d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-megaphone-fill fs-5"></i>
                        </div>
                        Official Announcements
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php foreach($alert_messages as $msg): ?>
                        <div class="alert-card">
                            <div class="alert-icon-box">
                                <i class="bi bi-exclamation-triangle-fill fs-2"></i>
                            </div>
                            <div class="alert-content">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="alert-badge">
                                        <div class="pulsing-dot"></div> URGENT ALERT
                                    </div>
                                    <span class="alert-timestamp">
                                        <i class="bi bi-clock me-1"></i><?php echo time_ago($msg['created_at']); ?>
                                    </span>
                                </div>
                                <p class="alert-text">
                                    <?php echo htmlspecialchars($msg['message']); ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-acknowledge" data-bs-dismiss="modal">I Understand</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Auto-Trigger Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var emergencyModal = new bootstrap.Modal(document.getElementById('emergencyModal'));
            emergencyModal.show();
            console.log("Emergency Modal Triggered. Messages: <?php echo count($alert_messages); ?>");
        });
    </script>
    <?php endif; ?>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>