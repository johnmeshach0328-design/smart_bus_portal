<?php
session_start();
if (!isset($_SESSION['platform_incharge'])) {
    header("Location: platform_incharge_login.php");
    exit;
}
require_once 'db.php';

$district = $_SESSION['admin_district'];
$message = '';

// Handle Delete
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $stmt = $conn->prepare("DELETE FROM special_buses WHERE id = ? AND district = ?");
    $stmt->bind_param("is", $delete_id, $district);
    if ($stmt->execute()) {
        $message = "Special bus deleted successfully!";
    }
}

// Handle Add
if (isset($_POST['add_special_bus'])) {
    $bus_number = $_POST['bus_number'];
    $route = $_POST['route'];
    $occasion = $_POST['occasion'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Get shift times
    $shift1 = !empty($_POST['shift1_time']) ? $_POST['shift1_time'] : null;
    $shift2 = !empty($_POST['shift2_time']) ? $_POST['shift2_time'] : null;
    $shift3 = !empty($_POST['shift3_time']) ? $_POST['shift3_time'] : null;
    $shift4 = !empty($_POST['shift4_time']) ? $_POST['shift4_time'] : null;
    $shift5 = !empty($_POST['shift5_time']) ? $_POST['shift5_time'] : null;
    $shift6 = !empty($_POST['shift6_time']) ? $_POST['shift6_time'] : null;

    $stmt = $conn->prepare("INSERT INTO special_buses (bus_number, route, occasion, start_date, end_date, district, shift1_time, shift2_time, shift3_time, shift4_time, shift5_time, shift6_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssss", $bus_number, $route, $occasion, $start_date, $end_date, $district, $shift1, $shift2, $shift3, $shift4, $shift5, $shift6);

    if ($stmt->execute()) {
        $message = "Special bus added successfully!";
    } else {
        $message = "Error adding special bus!";
    }
}

// Fetch all special buses
$stmt = $conn->prepare("SELECT * FROM special_buses WHERE district = ? ORDER BY start_date DESC");
$stmt->bind_param("s", $district);
$stmt->execute();
$special_buses = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Bus Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="assets/CSS/custom_style.css?v=premium_polish_final" rel="stylesheet">
    <script src="assets/js/theme-manager.js?v=premium_polish_final"></script>
    <script src="assets/js/font-color-loader.js"></script>

    <style>
        .special-card {
            background: var(--card-bg);
            border-radius: var(--border-radius-xl);
            padding: 2rem;
            box-shadow: var(--shadow-xl);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid var(--border-color);
        }

        .occasion-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .date-range {
            color: var(--text-main);
            font-size: 0.9rem;
        }

        .bus-number-display {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-blue);
        }

        .shift-time {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            padding: 0.25rem 0.75rem;
            border-radius: 8px;
            font-size: 0.875rem;
            display: inline-block;
            margin: 0.25rem;
            color: var(--text-main);
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

    <!-- Header -->
    <nav class="navbar navbar-expand-lg backdrop-blur shadow-sm">
        <div class="container-fluid">
            <a href="platform_dashboard.php" class="navbar-brand text-dark fw-bold">
                <i class="bi bi-arrow-left-circle me-2"></i> Back to Dashboard
            </a>
            <span class="navbar-text text-dark">
                <i class="bi bi-calendar-event me-2 text-info"></i>
                <strong>Special Bus Management</strong>
            </span>
        </div>
    </nav>

    <div class="container mt-5">
        <?php if ($message): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="bi bi-info-circle-fill me-2"></i>
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Add Special Bus Form -->
        <div class="special-card mb-4">
            <h3 class="fw-bold mb-4">
                <i class="bi bi-plus-circle-fill text-info me-2"></i>Add Special Bus
            </h3>
            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Bus Number</label>
                        <input type="text" class="form-control" name="bus_number" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Route</label>
                        <input type="text" class="form-control" name="route" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Occasion Name</label>
                        <input type="text" class="form-control" name="occasion"
                            placeholder="e.g., Diwali Festival, New Year, Pongal" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="start_date" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">End Date</label>
                        <input type="date" class="form-control" name="end_date" required>
                    </div>

                    <!-- Shift Timings -->
                    <div class="col-12 mt-3">
                        <h5 class="mb-3"><i class="bi bi-clock me-2 text-info"></i>Shift Timings (Optional)</h5>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Shift 1</label>
                        <input type="time" class="form-control" name="shift1_time">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Shift 2</label>
                        <input type="time" class="form-control" name="shift2_time">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Shift 3</label>
                        <input type="time" class="form-control" name="shift3_time">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Shift 4</label>
                        <input type="time" class="form-control" name="shift4_time">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Shift 5</label>
                        <input type="time" class="form-control" name="shift5_time">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Shift 6</label>
                        <input type="time" class="form-control" name="shift6_time">
                    </div>

                    <div class="col-12">
                        <button type="submit" name="add_special_bus" class="btn btn-info text-white rounded-pill px-4">
                            <i class="bi bi-plus-lg me-2"></i>Add Special Bus
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- List Special Buses -->
        <div class="special-card">
            <h3 class="fw-bold mb-4">
                <i class="bi bi-list-ul text-info me-2"></i>Active Special Buses
            </h3>

            <?php if ($special_buses->num_rows > 0): ?>
                <div class="row g-3">
                    <?php while ($bus = $special_buses->fetch_assoc()): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-0"
                                style="background: var(--input-bg); border-radius: var(--border-radius-lg);">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <span class="bus-number-display">
                                            <?php echo htmlspecialchars($bus['bus_number']); ?>
                                        </span>
                                        <form method="POST" class="d-inline"
                                            onsubmit="return confirm('Delete this special bus?');">
                                            <input type="hidden" name="delete_id" value="<?php echo $bus['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle p-2">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <p class="mb-2" style="color: var(--text-main);">
                                        <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                        <?php echo htmlspecialchars($bus['route']); ?>
                                    </p>

                                    <span class="occasion-badge d-inline-block mb-3">
                                        <i class="bi bi-balloon-fill me-1"></i>
                                        <?php echo htmlspecialchars($bus['occasion']); ?>
                                    </span>

                                    <div class="date-range">
                                        <i class="bi bi-calendar-range me-1"></i>
                                        <?php echo date('M d, Y', strtotime($bus['start_date'])); ?> -
                                        <?php echo date('M d, Y', strtotime($bus['end_date'])); ?>
                                    </div>

                                    <?php
                                    // Display shift times
                                    $shifts = [];
                                    for ($i = 1; $i <= 6; $i++) {
                                        if (!empty($bus["shift{$i}_time"])) {
                                            $shifts[] = $bus["shift{$i}_time"];
                                        }
                                    }
                                    if (!empty($shifts)): ?>
                                        <div class="mt-3">
                                            <small class="text-muted d-block mb-1">
                                                <i class="bi bi-clock me-1"></i>Shift Timings:
                                            </small>
                                            <?php foreach ($shifts as $shift): ?>
                                                <span class="shift-time">
                                                    <?php echo date('h:i A', strtotime($shift)); ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 4rem; color: var(--text-main); opacity: 0.3;"></i>
                    <p class="text-muted mt-3">No special buses added yet</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/page-transitions.js"></script>
</body>

</html>