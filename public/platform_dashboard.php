<?php
session_start();
if (!isset($_SESSION['platform_incharge'])) {
    header("Location: platform_incharge_login.php");
    exit;
}
require_once 'db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platform Dashboard</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <!-- Custom CSS -->
    <link href="assets/CSS/custom_style.css" rel="stylesheet">
    <script src="assets/js/theme-manager.js"></script>
    <script src="assets/js/font-color-loader.js"></script>
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

    <!-- Professional Header -->
    <nav class="navbar navbar-expand-lg backdrop-blur shadow-sm" style="background: var(--card-bg); border-bottom: 1px solid var(--border-color);">
        <div class="container-fluid">
            <span class="navbar-brand fw-bold" style="color: var(--text-heading) !important;">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </span>
            <div class="d-flex align-items-center">
                <span class="badge me-3 p-2 px-3 rounded-pill fw-bold"
                    style="background: var(--primary-blue); color: var(--card-bg); border: 1px solid var(--primary-blue);">
                    <i class="bi bi-geo-alt-fill me-1"></i> <?php echo htmlspecialchars($_SESSION['admin_district']); ?>
                </span>
                <span class="navbar-text me-3" style="color: var(--text-main) !important;">
                    Welcome, <?php echo htmlspecialchars($_SESSION['platform_incharge']); ?>
                </span>
                <a href="logout.php" class="btn btn-sm rounded-pill px-3" id="btn_logout"
                    style="border: 1px solid var(--primary-blue); color: var(--primary-blue);">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Alerts for Imminent Delays -->
    <div class="container mt-4">
        <?php
        $dist = $_SESSION['admin_district'];
        $today = date('Y-m-d');
        $now = date('H:i');
        $nowTs = strtotime($now);
        $warningLimitTs = $nowTs + (10 * 60); // 10 minutes from now
        
        // Find buses in district that are NOT departured and have a shift starting within 10 mins
        $stmt = $conn->prepare("SELECT b.*, a.detailed_status 
                               FROM buses b 
                               LEFT JOIN attendance a ON b.id = a.bus_id AND a.attendance_date = ?
                               WHERE b.district = ?");
        $stmt->bind_param("ss", $today, $dist);
        $stmt->execute();
        $res = $stmt->get_result();

        while ($bus = $res->fetch_assoc()) {
            $shifts = [$bus['shift1_time'], $bus['shift2_time'], $bus['shift3_time'], $bus['shift4_time'], $bus['shift5_time'], $bus['shift6_time']];
            $status = $bus['detailed_status'] ?? 'Scheduled';

            if ($status != 'Departured') {
                foreach ($shifts as $st) {
                    if (!empty($st)) {
                        $stTs = strtotime($st);
                        // If shift time is between NOW and 10 mins from now
                        if ($stTs >= $nowTs && $stTs <= $warningLimitTs) {
                            $busCategory = urlencode($bus['bus_type']);
                            echo '<a href="mark_attendance.php?type=' . $busCategory . '&action=attendance" 
                                    class="alert alert-dismissible fade show shadow-sm border-start border-4 d-block text-decoration-none" role="alert"
                                    style="background: var(--card-bg); color: var(--text-main); border-color: var(--primary-blue) !important; cursor: pointer;">
                                    <i class="bi bi-exclamation-triangle-fill me-2" style="color: var(--primary-blue);"></i>
                                    <strong>Immediate Action Required:</strong> Bus <strong>' . htmlspecialchars($bus['bus_number']) . '</strong> 
                                    is scheduled for ' . $st . '. Departure not marked! (Delay in 10 mins or less)
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="filter: invert(1);" onclick="event.preventDefault(); event.stopPropagation(); this.closest(\'.alert\').remove();"></button>
                                  </a>';
                            break; // Show one warning per bus
                        }
                    }
                }
            }
        }
        ?>
    </div>

    <!-- Main Content -->
    <div class="container mt-5">
        <!-- Inline Broadcast Section -->
        <div class="glass-panel mb-5 p-4 mx-auto" style="max-width: 800px;">
            <h4 class="fw-bold mb-3" style="color: var(--text-heading);"><i
                    class="bi bi-megaphone-fill me-2 text-primary"></i>Make an Announcement</h4>
            <p class="text-muted mb-3">Send a message to all passengers in <strong><?php echo htmlspecialchars($_SESSION['admin_district'] ?? 'your district'); ?></strong>. (Expires in 24h)</p>

            <form action="post_message_process.php" method="POST" class="d-flex gap-2">
                <div class="flex-grow-1">
                    <input type="text" class="form-control" name="message"
                        placeholder="Type your message here (e.g., 'Bus 404 is delayed due to traffic')" required
                        style="background: var(--input-bg); color: var(--input-text); border: 1px solid var(--border-color);">
                </div>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-send-fill me-2"></i>Send
                </button>
            </form>
            
            <!-- Alert Messages -->
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    Message broadcasted successfully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    Failed to broadcast message. Please try again.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>

        <div class="row g-4 justify-content-center">

            <!-- Add Bus -->
            <div class="col-md-6 col-lg-3">
                <div class="custom-card shadow-lg h-100 p-4 rounded-4 text-center hover-up"
                    style="background: var(--card-bg); border: 2px solid var(--border-color); box-shadow: 0 0 15px rgba(0,0,0,0.2) !important;">
                    <div class="mb-3">
                        <i class="bi bi-plus-circle-fill"
                            style="font-size: 2.5rem; color: var(--primary-blue) !important;"></i>
                    </div>
                    <h3 class="fw-bold mb-3" id="card_add_bus"
                        style="color: var(--text-heading) !important;">Add Bus</h3>
                    <a href="add_bus.php" class="btn w-100 rounded-pill fw-bold"
                        style="background: var(--primary-blue); color: var(--card-bg); border: none;" id="btn_add">Add</a>
                </div>
            </div>

            <!-- Delete Bus -->
            <div class="col-md-6 col-lg-3">
                <div class="custom-card shadow-lg h-100 p-4 rounded-4 text-center hover-up"
                    style="background: var(--card-bg); border: 2px solid var(--border-color); box-shadow: 0 0 15px rgba(0,0,0,0.2) !important;">
                    <div class="mb-3">
                        <i class="bi bi-trash-fill"
                            style="font-size: 2.5rem; color: var(--primary-blue) !important;"></i>
                    </div>
                    <h3 class="fw-bold mb-3" id="card_del_bus"
                        style="color: var(--text-heading) !important;">Delete Bus</h3>
                    <a href="delete_bus.php" class="btn w-100 rounded-pill fw-bold"
                        style="background: var(--primary-blue); color: var(--card-bg); border: none;" id="btn_del">Delete</a>
                </div>
            </div>

            <!-- View Buses -->
            <div class="col-md-6 col-lg-3">
                <div class="custom-card shadow-lg h-100 p-4 rounded-4 text-center hover-up"
                    style="background: var(--card-bg); border: 2px solid var(--border-color); box-shadow: 0 0 15px rgba(0,0,0,0.2) !important;">
                    <div class="mb-3">
                        <i class="bi bi-bus-front-fill"
                            style="font-size: 2.5rem; color: var(--primary-blue) !important;"></i>
                    </div>
                    <h3 class="fw-bold mb-3" id="card_view_bus"
                        style="color: var(--text-heading) !important;">View Buses</h3>
                    <a href="fetch_all_buses.php" class="btn w-100 rounded-pill fw-bold"
                        style="background: var(--primary-blue); color: var(--card-bg); border: none;"
                        id="btn_view">View</a>
                </div>
            </div>

            <!-- Mark Attendance -->
            <div class="col-md-6 col-lg-3">
                <div class="custom-card shadow-lg h-100 p-4 rounded-4 text-center hover-up"
                    style="background: var(--card-bg); border: 2px solid var(--border-color); box-shadow: 0 0 15px rgba(0,0,0,0.2) !important;">
                    <div class="mb-3">
                        <i class="bi bi-check-circle-fill"
                            style="font-size: 2.5rem; color: var(--primary-blue) !important;"></i>
                    </div>
                    <h3 class="fw-bold mb-3" id="card_mark_att"
                        style="color: var(--text-heading) !important;">Mark Attendance</h3>
                    <a href="mark_attendance.php" class="btn w-100 rounded-pill fw-bold"
                        style="background: var(--primary-blue); color: var(--card-bg); border: none;"
                        id="btn_mark">Mark</a>
                </div>
            </div>

            <!-- Route Diversion -->
            <div class="col-md-6 col-lg-3">
                <div class="custom-card shadow-lg h-100 p-4 rounded-4 text-center hover-up"
                    style="background: var(--card-bg); border: 2px solid var(--border-color); box-shadow: 0 0 15px rgba(0,0,0,0.2) !important;">
                    <div class="mb-3">
                        <i class="bi bi-cone-striped"
                            style="font-size: 2.5rem; color: var(--accent-orange) !important;"></i>
                    </div>
                    <h3 class="fw-bold mb-3" 
                        style="color: var(--text-heading) !important;">Route Diversion</h3>
                    <a href="manage_diversions.php" class="btn w-100 rounded-pill fw-bold"
                        style="background: var(--accent-orange); color: #fff; border: none;">Manage</a>
                </div>
            </div>

            <!-- Special Bus -->
            <div class="col-md-6 col-lg-3">
                <div class="custom-card shadow-lg h-100 p-4 rounded-4 text-center hover-up"
                    style="background: var(--card-bg); border: 2px solid var(--border-color); box-shadow: 0 0 15px rgba(0,0,0,0.2) !important;">
                    <div class="mb-3">
                        <i class="bi bi-calendar-event-fill"
                            style="font-size: 2.5rem; color: var(--primary-blue) !important;"></i>
                    </div>
                    <h3 class="fw-bold mb-3" id="card_special_bus"
                        style="color: var(--text-heading) !important;">Special Bus</h3>
                    <a href="special_bus.php" class="btn w-100 rounded-pill fw-bold"
                        style="background: var(--primary-blue); color: var(--card-bg); border: none;"
                        id="btn_special">Manage</a>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Page Transitions -->
    <script src="assets/js/page-transitions.js"></script>
</body>

</html>