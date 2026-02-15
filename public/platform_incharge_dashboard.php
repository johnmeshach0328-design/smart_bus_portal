<?php
session_start();

/* LOGIN PROTECTION */
if (!isset($_SESSION['platform_incharge'])) {
    header("Location: platform_incharge_login.php");
    exit();
}

/* FETCH BUS DATA */
$buses = [];

/* Include only if file exists */
if (file_exists("fetch_all_buses.php")) {
    include "fetch_all_buses.php";   // should set $buses array
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platform Incharge Dashboard | Smart Bus Portal</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- External CSS -->
    <link href="assets/CSS/custom_style.css" rel="stylesheet">

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
            align-items: flex-start;
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
            max-width: 1200px;
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

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg backdrop-blur shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-dark" href="#">
                <i class="bi bi-bus-front me-2"></i><span id="txt_app_title">SMART BUS PORTAL</span>
            </a>
            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="text-secondary small d-none d-md-block">
                    <i class="bi bi-person-badge me-1"></i>
                    <?php echo htmlspecialchars($_SESSION['platform_incharge'] ?? 'Staff'); ?>
                    <span
                        class="badge bg-primary ms-1"><?php echo htmlspecialchars($_SESSION['admin_district'] ?? ''); ?></span>
                </span>
                <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-4" id="btn_logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="dashboard-container">
            <!-- New Inline Broadcast Section -->
            <div class="glass-panel mb-4 p-5" style="border: 1px solid rgba(255,255,255,0.3);">
                <h4 class="fw-bold mb-3" style="color: var(--text-heading); letter-spacing: -0.5px;"><i class="bi bi-megaphone-fill me-3 p-2 rounded-circle bg-primary text-white"></i>Make an Announcement</h4>
                <p class="text-muted mb-3">Send a message to all passengers in <strong><?php echo htmlspecialchars($_SESSION['admin_district'] ?? 'your district'); ?></strong>. (Expires in 24h)</p>
                
                <form action="post_message_process.php" method="POST" class="d-flex gap-2">
                    <div class="flex-grow-1">
                        <input type="text" class="form-control" name="message" placeholder="Type your message here (e.g., 'Bus 404 is delayed due to traffic')" required
                            style="background: var(--input-bg); color: var(--input-text); border: 1px solid var(--border-color); height: 50px; border-radius: 50px; padding-left: 1.5rem;">
                    </div>
                    <button type="submit" class="btn btn-primary px-4 rounded-pill fw-bold" style="height: 50px; min-width: 120px;">
                        <i class="bi bi-send-fill me-2"></i>Send
                    </button>
                </form>
            </div>

            <div class="glass-panel">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <h2 class="fw-bold m-0" id="dash_staff_title">Bus Schedule Management</h2>
                    <button class="btn btn-sm btn-primary" onclick="location.reload()">
                        <i class="bi bi-arrow-clockwise me-1"></i> Refresh
                    </button>
                </div>

            <!-- Alert Messages -->
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Message broadcasted successfully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Failed to broadcast message. Please try again.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="table-responsive" style="border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <table class="table table-hover align-middle mb-0" style="background: rgba(255,255,255,0.9);">
                    <thead class="bg-primary text-white" style="background: var(--gradient-primary);">
                        <tr>
                            <th id="th_bus_id">Bus ID</th>
                            <th id="th_route">Route</th>
                            <th id="th_dept_time">Departure Time</th>
                            <th id="th_arr_time">Arrival Time</th>
                            <th id="th_status">Status</th>
                            <th id="th_action">Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($buses)) { ?>
                            <?php foreach ($buses as $bus) { ?>
                                <tr>
                                    <td class="fw-bold"><?= htmlspecialchars($bus['bus_id']) ?></td>
                                    <td><?= htmlspecialchars($bus['route']) ?></td>
                                    <td><?= htmlspecialchars($bus['departure_time']) ?></td>
                                    <td><?= htmlspecialchars($bus['arrival_time']) ?></td>
                                    <td>
                                        <?php
                                        $statusClass = 'bg-secondary';
                                        if ($bus['status'] == 'On Time')
                                            $statusClass = 'bg-success';
                                        elseif ($bus['status'] == 'Delayed')
                                            $statusClass = 'bg-warning text-dark';
                                        elseif ($bus['status'] == 'Cancelled')
                                            $statusClass = 'bg-danger';
                                        ?>
                                        <span
                                            class="badge rounded-pill <?php echo $statusClass; ?>"><?= htmlspecialchars($bus['status']) ?></span>
                                    </td>
                                    <td>
                                        <form action="update_status.php" method="POST" class="d-flex gap-2">
                                            <input type="hidden" name="bus_id" value="<?= $bus['bus_id'] ?>">
                                            <select name="status" class="form-select form-select-sm">
                                                <option value="On Time" <?= $bus['status'] == 'On Time' ? 'selected' : '' ?>>On
                                                    Time</option>
                                                <option value="Delayed" <?= $bus['status'] == 'Delayed' ? 'selected' : '' ?>>
                                                    Delayed</option>
                                                <option value="Cancelled" <?= $bus['status'] == 'Cancelled' ? 'selected' : '' ?>>
                                                    Cancelled</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-outline-primary"><i
                                                    class="bi bi-check-lg"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                    No bus schedules available.
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="assets/js/page-transitions.js"></script>
    <script src="assets/js/theme-manager.js"></script>
    <script src="assets/js/font-color-loader.js"></script>
    <script>
        // Update nav title locally if needed
        const appTitleEl = document.getElementById('txt_app_title');
        if (appTitleEl && translations[localStorage.getItem('user_lang')]) {
            appTitleEl.textContent = translations[localStorage.getItem('user_lang')].app_title.toUpperCase();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>