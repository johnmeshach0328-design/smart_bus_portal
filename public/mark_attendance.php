<?php
session_start();
if (!isset($_SESSION['platform_incharge'])) {
    header("Location: platform_incharge_login.php");
    exit;
}
require_once 'db.php';
$bus_type = $_GET['type'] ?? '';
$action = $_GET['action'] ?? '';

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
        return ($days == 1) ? "yesterday" : "$days days ago";
    else if ($weeks <= 4.3)
        return ($weeks == 1) ? "a week ago" : "$weeks weeks ago";
    else if ($months <= 12)
        return ($months == 1) ? "a month ago" : "$months months ago";
    else
        return ($years == 1) ? "one year ago" : "$years years ago";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Mark Attendance</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <!-- Custom CSS -->
    <link href="assets/CSS/custom_style.css?v=professional_v4" rel="stylesheet">
    <script src="assets/js/theme-manager.js?v=professional_v4"></script>
    <script src="assets/js/font-color-loader.js?v=professional_v4"></script>
    <style>
        body {
            /* Background managed by theme-manager.js */
        }

        .landscape-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-decoration: none;
            color: var(--text-main);
            margin-bottom: 25px;
            border-left: 8px solid transparent;
        }

        .landscape-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .landscape-card h2 {
            margin: 0;
            font-weight: bold;
        }

        .landscape-card p {
            margin: 5px 0 0;
            color: var(--text-main); opacity: 0.7;
        }

        .landscape-card .icon-box {
            font-size: 3rem;
            margin-right: 20px;
        }

        .card-attendance {
            border-left-color: #0d6efd;
        }

        .card-attendance .icon-box {
            color: #0d6efd;
        }

        .card-status {
            border-left-color: #198754;
        }

        .card-status .icon-box {
            color: #198754;
        }

        /* Force theme colors on Bootstrap tables */
        .table {
            --bs-table-bg: var(--card-bg) !important;
            --bs-table-color: var(--text-main) !important;
            --bs-table-border-color: var(--border-color) !important;
            --bs-table-hover-bg: rgba(255, 255, 255, 0.05) !important;
            --bs-table-hover-color: var(--text-main) !important;
            color: var(--text-main) !important;
        }

        .table thead th {
            background: var(--input-bg) !important;
            color: var(--text-heading) !important;
            border-color: var(--border-color) !important;
        }

        .table tbody td {
            background: var(--card-bg) !important;
            color: var(--text-main) !important;
            border-color: var(--border-color) !important;
        }

        .table tbody tr:hover td {
            background: rgba(255, 255, 255, 0.05) !important;
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

    <nav class="navbar navbar-expand-lg backdrop-blur shadow-sm mb-4" style="background: var(--card-bg); border-bottom: 1px solid var(--border-color);">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="platform_dashboard.php" style="color: var(--text-heading) !important;">
                <i class="bi bi-arrow-left-circle me-2"></i>Dashboard
            </a>
        </div>
    </nav>

    <!-- Alerts for Imminent Delays -->
    <div class="container mt-2">
        <?php
        $dist = $_SESSION['admin_district'] ?? '';
        $today = date('Y-m-d');
        $now = date('H:i');
        $nowTs = strtotime($now);
        $warningLimitTs = $nowTs + (10 * 60);

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
                        if ($stTs >= $nowTs && $stTs <= $warningLimitTs) {
                            echo '<div class="alert alert-dismissible fade show shadow-sm border-start border-4" role="alert"
                                    style="background: var(--card-bg); color: var(--text-main); border-color: var(--primary-blue) !important;">
                                    <i class="bi bi-bell-fill me-2" style="color: var(--primary-blue);"></i>
                                    <strong>Ready for Departure?</strong> Bus <strong>' . htmlspecialchars($bus['bus_number']) . '</strong> 
                                    is scheduled for ' . $st . '. Please mark as Departured!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="filter: invert(1);"></button>
                                  </div>';
                            break;
                        }
                    }
                }
            }
        }
        ?>
    </div>

    <?php if (!$bus_type): ?>
        <!-- Step 1: Selection Screen -->
        <div class="text-center mt-5">
            <h2 class="fw-bold" id="page_title" style="color: var(--text-heading);">Mark Attendance</h2>
            <p style="color: var(--text-main); opacity: 0.9;" id="lbl_sel_cat">Select a category to proceed</p>
        </div>

        <div class="selection-container">
            <a href="mark_attendance.php?type=SETC" class="type-card setc">
                <i class="bi bi-bus-front text-success"></i>
                <h3 class="text-success">SETC</h3>
            </a>
            <a href="mark_attendance.php?type=Point-To-Point" class="type-card ptp">
                <i class="bi bi-signpost-split text-success"></i>
                <h3 class="text-success">Point-To-Point</h3>
            </a>
            <a href="mark_attendance.php?type=Route Bus" class="type-card route">
                <i class="bi bi-map text-success"></i>
                <h3 class="text-success">Route Bus</h3>
            </a>
        </div>

    <?php else: ?>
        <!-- Step 2: Action Choice (Attendance vs Status) -->
        <div class="container mt-5" style="max-width: 800px;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 style="color: var(--text-main);">Category: <span class="fw-bold"
                        style="color: var(--text-heading);"><?php echo htmlspecialchars($bus_type); ?></span></h3>
                <a href="mark_attendance.php" class="btn btn-outline-secondary rounded-pill">Change Category</a>
            </div>

            <div class="row g-4">
                <!-- Attendance Container -->
                <div class="col-md-6">
                    <a href="mark_attendance.php?type=<?php echo urlencode($bus_type); ?>&action=attendance"
                        class="landscape-card card-attendance h-100">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-check icon-box"></i>
                            <div>
                                <h2>Attendance</h2>
                                <p>Mark daily attendance for buses</p>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right text-muted fs-4"></i>
                    </a>
                </div>

                <!-- Status Container -->
                <div class="col-md-6">
                    <a href="mark_attendance.php?type=<?php echo urlencode($bus_type); ?>&action=status"
                        class="landscape-card card-status h-100">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-clipboard-data icon-box"></i>
                            <div>
                                <h2>Status</h2>
                                <p>View attendance logs and records</p>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right text-muted fs-4"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Action Handling -->
        <?php if ($action == 'attendance'): ?>
            <?php
            $admin_dist = $_SESSION['admin_district'] ?? '';
            $today = date('Y-m-d');
            $message = "";

            // Handle Attendance Submission (Individual or Bulk)
            if (isset($_POST['submit_attendance']) || isset($_POST['update_single'])) {
                $bus_ids = [];
                if (isset($_POST['update_single'])) {
                    $bus_ids = [$_POST['bus_id_clicked']];
                } else {
                    $bus_ids = $_POST['bus_ids'] ?? [];
                }

                $marks = $_POST['status'] ?? []; // key is bus_id, value is status
                $details = $_POST['detailed_status'] ?? []; // key is bus_id
    
                foreach ($bus_ids as $bid) {
                    $status = $marks[$bid] ?? 'Absent';
                    $det_status = $details[$bid] ?? 'Scheduled';
                    $incharge_id = $_SESSION['incharge_id'] ?? 0;

                    // Check if already marked for today
                    $check = $conn->prepare("SELECT id FROM attendance WHERE bus_id = ? AND attendance_date = ?");
                    $check->bind_param("is", $bid, $today);
                    $check->execute();
                    $exist = $check->get_result();

                    if ($exist->num_rows > 0) {
                        // Update existing entry
                        $stmt = $conn->prepare("UPDATE attendance SET status = ?, detailed_status = ?, marked_by = ?, updated_at = CURRENT_TIMESTAMP WHERE bus_id = ? AND attendance_date = ?");
                        $stmt->bind_param("ssiis", $status, $det_status, $incharge_id, $bid, $today);
                    } else {
                        // Insert new entry
                        $stmt = $conn->prepare("INSERT INTO attendance (bus_id, attendance_date, status, detailed_status, marked_by) VALUES (?, ?, ?, ?, ?)");
                        $stmt->bind_param("isssi", $bid, $today, $status, $det_status, $incharge_id);
                    }
                    $stmt->execute();
                }
                $message = "Attendance updated successfully!";
            }

            // Fetch Buses for this category and district with Diversion Status
            $sql = "SELECT b.*, rd.id as diversion_id, rd.stop2, rd.stop3, rd.stop4, rd.original_route 
                    FROM buses b 
                    LEFT JOIN route_diversions rd ON b.id = rd.bus_id AND rd.completion_status != 'Completed'
                    WHERE b.bus_type = ? AND b.district = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $bus_type, $admin_dist);
            $stmt->execute();
            $buses = $stmt->get_result();
            ?>

            <div class="container mt-4 mb-5">
                <div class="card p-4 shadow-sm border-0" style="background: var(--card-bg); color: var(--text-main); border: 1px solid var(--border-color) !important;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0" style="color: var(--text-heading);"><span id="lbl_att_sheet">Attendance Sheet</span>: <?php echo $today; ?></h4>
                        <span class="badge p-2" style="background: var(--primary-blue); color: var(--card-bg);"><?php echo htmlspecialchars($admin_dist); ?></span>
                    </div>

                    <?php if ($message): ?>
                        <div class="alert alert-success text-center"><?php echo $message; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <input type="hidden" name="bus_id_clicked" value="">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" style="color: var(--text-main);">
                                <thead style="background: var(--input-bg); color: var(--text-heading);">
                                    <tr>
                                        <th id="th_bus_id">Bus Number</th>
                                        <th id="th_route">Route</th>
                                        <th class="text-center" id="th_status">Status Control</th>
                                        <th class="text-center" id="th_action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($buses->num_rows > 0): ?>
                                        <?php while ($row = $buses->fetch_assoc()):
                                            // Check current status for today
                                            $c_stmt = $conn->prepare("SELECT status, detailed_status FROM attendance WHERE bus_id = ? AND attendance_date = ?");
                                            $c_stmt->bind_param("is", $row['id'], $today);
                                            $c_stmt->execute();
                                            $res = $c_stmt->get_result()->fetch_assoc();
                                            $c_status = $res['status'] ?? '';
                                            $c_detailed = $res['detailed_status'] ?? 'Scheduled';
                                            
                                            // Diversion Badge
                                            $is_diverted = !empty($row['diversion_id']);
                                            ?>
                                            <tr style="background: var(--card-bg); color: var(--text-main); border-color: var(--border-color);">
                                                <td class="fw-bold">
                                                    <?php echo htmlspecialchars($row['bus_number']); ?>
                                                    <?php if ($is_diverted): ?>
                                                        <br><span class="badge bg-warning text-dark border border-dark"><i class="bi bi-cone-striped me-1"></i>Diverted</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars($row['route']); ?>
                                                    <?php if ($is_diverted): ?>
                                                        <div class="small text-danger mt-1">
                                                            <i class="bi bi-exclamation-triangle-fill"></i> Via: <?php echo htmlspecialchars($row['stop2'] . ' - ' . $row['stop3']); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <input type="hidden" name="bus_ids[]" value="<?php echo $row['id']; ?>">
                                                    <div class="mb-2">
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <input type="radio" class="btn-check"
                                                                name="status[<?php echo $row['id']; ?>]"
                                                                id="p_<?php echo $row['id']; ?>" value="Present" <?php echo ($c_status == 'Present' || $c_status == '') ? 'checked' : ''; ?>>
                                                            <label class="btn btn-outline-success"
                                                                for="p_<?php echo $row['id']; ?>">Present</label>

                                                            <input type="radio" class="btn-check"
                                                                name="status[<?php echo $row['id']; ?>]"
                                                                id="a_<?php echo $row['id']; ?>" value="Absent" <?php echo ($c_status == 'Absent') ? 'checked' : ''; ?>>
                                                            <label class="btn btn-outline-danger"
                                                                for="a_<?php echo $row['id']; ?>">Absent</label>
                                                        </div>
                                                    </div>
                                                    <div class="btn-group btn-group-sm flex-wrap" role="group">
                                                        <input type="radio" class="btn-check"
                                                            name="detailed_status[<?php echo $row['id']; ?>]"
                                                            id="ds_sched_<?php echo $row['id']; ?>" value="Scheduled" <?php echo $c_detailed == 'Scheduled' ? 'checked' : ''; ?>>
                                                        <label class="btn btn-outline-info"
                                                            for="ds_sched_<?php echo $row['id']; ?>">Scheduled</label>

                                                        <input type="radio" class="btn-check"
                                                            name="detailed_status[<?php echo $row['id']; ?>]"
                                                            id="ds_arr_<?php echo $row['id']; ?>" value="Arrived" <?php echo $c_detailed == 'Arrived' ? 'checked' : ''; ?>>
                                                        <label class="btn btn-outline-success"
                                                            for="ds_arr_<?php echo $row['id']; ?>">Arrived</label>

                                                        <input type="radio" class="btn-check"
                                                            name="detailed_status[<?php echo $row['id']; ?>]"
                                                            id="ds_del_<?php echo $row['id']; ?>" value="Delayed" <?php echo $c_detailed == 'Delayed' ? 'checked' : ''; ?>>
                                                        <label class="btn btn-outline-warning"
                                                            for="ds_del_<?php echo $row['id']; ?>">Delayed</label>

                                                        <input type="radio" class="btn-check"
                                                            name="detailed_status[<?php echo $row['id']; ?>]"
                                                            id="ds_dep_<?php echo $row['id']; ?>" value="Departured" <?php echo $c_detailed == 'Departured' ? 'checked' : ''; ?>>
                                                        <label class="btn btn-outline-primary"
                                                            for="ds_dep_<?php echo $row['id']; ?>">Departured</label>

                                                        <input type="radio" class="btn-check"
                                                            name="detailed_status[<?php echo $row['id']; ?>]"
                                                            id="ds_na_<?php echo $row['id']; ?>" value="not available due to problem" <?php echo $c_detailed == 'not available due to problem' ? 'checked' : ''; ?>>
                                                        <label class="btn btn-outline-secondary"
                                                            for="ds_na_<?php echo $row['id']; ?>">N/A</label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <!-- Use a hidden div to wrap each row in its own submit context if needed, 
                                                         but here we use the name of the button to detect click -->
                                                    <button type="submit" name="update_single" value="true"
                                                        onclick="this.form.bus_id_clicked.value='<?php echo $row['id']; ?>'"
                                                        class="btn btn-sm btn-primary rounded-pill px-3">
                                                        <i class="bi bi-pencil-square me-1"></i> Update
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-muted">No buses found in this category for
                                                your district.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if ($buses->num_rows > 0): ?>
                            <button type="submit" name="submit_attendance"
                                class="btn btn-success w-100 rounded-pill mt-3 py-2 fw-bold shadow-sm" id="btn_save_records">
                                <i class="bi bi-check2-circle me-2"></i> Save All Records
                            </button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

        <?php elseif ($action == 'status'): ?>
            <?php
            $admin_dist = $_SESSION['admin_district'] ?? '';
            $today = date('Y-m-d');

            // Fetch Logs with bus shift details
            $l_stmt = $conn->prepare("SELECT a.*, b.bus_number, b.route, b.shift1_time, b.shift2_time, b.shift3_time, b.shift4_time, b.shift5_time, b.shift6_time 
                                    FROM attendance a 
                                    JOIN buses b ON a.bus_id = b.id 
                                    WHERE b.district = ? AND b.bus_type = ? AND a.attendance_date = ?
                                    ORDER BY a.created_at DESC");
            $l_stmt->bind_param("sss", $admin_dist, $bus_type, $today);
            $l_stmt->execute();
            $logs = $l_stmt->get_result();
            ?>

            <div class="container mt-4 mb-5">
                <div class="card p-4 shadow-sm border-0" style="background: var(--card-bg); color: var(--text-main); border: 1px solid var(--border-color) !important;">
                    <h4 class="fw-bold mb-4" style="color: var(--text-heading);"><span id="lbl_logs">Today's Logs</span> (<?php echo $today; ?>)</h4>

                    <div class="table-responsive">
                        <table class="table table-sm align-middle" style="color: var(--text-main);">
                            <thead style="background: var(--input-bg); color: var(--text-heading);">
                                <tr>
                                    <th id="th_bus_id">Bus #</th>
                                    <th id="th_route">Route</th>
                                    <th id="th_status">Status</th>
                                    <th>Last Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($logs->num_rows > 0): ?>
                                    <?php while ($log = $logs->fetch_assoc()): ?>
                                        <tr style="background: var(--card-bg); border-color: var(--border-color);">
                                            <td><?php echo htmlspecialchars($log['bus_number']); ?></td>
                                            <td><small><?php echo htmlspecialchars($log['route']); ?></small></td>
                                            <td>
                                                <?php
                                                $sText = $log['status'];
                                                $detText = $log['detailed_status'];

                                                // Auto-Delay Logic
                                                $now = date('H:i');
                                                $sTimes = [$log['shift1_time'], $log['shift2_time'], $log['shift3_time'], $log['shift4_time'], $log['shift5_time'], $log['shift6_time']];
                                                $passed = false;
                                                foreach ($sTimes as $st) {
                                                    if (!empty($st) && $now > $st)
                                                        $passed = true;
                                                }

                                                if ($sText == 'Present' && $passed && $detText != 'Departured' && $detText != 'Delayed') {
                                                    $detText = 'Delayed (Auto)';
                                                }
                                                ?>

                                                <span class="badge bg-<?php echo ($sText == 'Present') ? 'success' : 'danger'; ?> mb-1">
                                                    <?php echo $sText; ?>
                                                </span><br>
                                                <small
                                                    class="fw-bold <?php echo (strpos($detText, 'Delayed') !== false) ? 'text-warning' : 'text-primary'; ?>">
                                                    <?php echo htmlspecialchars($detText); ?>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="text-muted small">
                                                    <?php echo date('h:i A', strtotime($log['updated_at'])); ?>
                                                </div>
                                                <div class="fw-bold text-success small"><?php echo time_ago($log['updated_at']); ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No attendance logs found for today.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    <?php endif; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Page Transitions -->
    <script src="assets/js/page-transitions.js"></script>
</body>

</html>