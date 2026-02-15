<?php
session_start();
if (!isset($_SESSION['platform_incharge'])) {
    header("Location: platform_incharge_login.php");
    exit;
}

require_once 'db.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$bus_type = $_GET['type'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bus_number = strtoupper(trim($_POST['bus_number'] ?? ''));
    $route = $_POST['route'] ?? '';
    $type_input = $_POST['bus_type'] ?? '';

    // Collect shifts
    $shift1 = $_POST['shift1'] ?? '';
    $shift2 = $_POST['shift2'] ?? '';
    $shift3 = $_POST['shift3'] ?? '';
    $shift4 = $_POST['shift4'] ?? '';
    $shift5 = $_POST['shift5'] ?? '';
    $shift6 = $_POST['shift6'] ?? '';

    // Collect stops (1-9)
    $stop1 = $_POST['stop1'] ?? '';
    $stop2 = $_POST['stop2'] ?? '';
    $stop3 = $_POST['stop3'] ?? '';
    $stop4 = $_POST['stop4'] ?? '';
    $stop5 = $_POST['stop5'] ?? '';
    $stop6 = $_POST['stop6'] ?? '';
    $stop7 = $_POST['stop7'] ?? '';
    $stop8 = $_POST['stop8'] ?? '';
    $stop9 = $_POST['stop9'] ?? '';

    // District is automatically assigned from the logged-in admin's profile
    $district = $_SESSION['admin_district'] ?? '';

    // Validation: 1-6 mandatory for Route Bus
    if ($bus_number && $route && $type_input && $district) {
        $incharge_id = $_SESSION['incharge_id'] ?? 0;

        // Insert with shifts and stops (up to 9) and district
        $stmt = $conn->prepare("INSERT INTO buses (incharge_id, bus_number, route, bus_type, district, shift1_time, shift2_time, shift3_time, shift4_time, shift5_time, shift6_time, stop1, stop2, stop3, stop4, stop5, stop6, stop7, stop8, stop9) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssssssssssssssss", $incharge_id, $bus_number, $route, $type_input, $district, $shift1, $shift2, $shift3, $shift4, $shift5, $shift6, $stop1, $stop2, $stop3, $stop4, $stop5, $stop6, $stop7, $stop8, $stop9);

        if ($stmt->execute()) {
            $message = "Bus added successfully to $district!";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Please fill in all fields!";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Bus | <?php echo htmlspecialchars($_SESSION['admin_district']); ?></title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="assets/CSS/custom_style.css" rel="stylesheet">
    <script src="assets/js/theme-manager.js"></script>
    <script src="assets/js/font-color-loader.js"></script>
</head>

<body class="bg-movable bg-add-bus bg-overlay">
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

    <nav class="navbar navbar-expand-lg backdrop-blur shadow-sm mb-4">
        <div class="container-fluid">
            <a class="navbar-brand text-dark fw-bold" href="platform_dashboard.php">
                <i class="bi bi-arrow-left-circle me-2"></i>Dashboard
            </a>
            <div class="ms-auto">
                <span class="badge bg-white text-primary border border-primary p-2 px-3 rounded-pill fw-bold">
                    <i class="bi bi-geo-alt-fill me-1"></i> <?php echo htmlspecialchars($_SESSION['admin_district']); ?>
                    Admin
                </span>
            </div>
        </div>
    </nav>

    <?php if (!$bus_type): ?>
        <!-- Selection Screen -->
        <div class="text-center mt-5">
            <h2 class="fw-bold" id="page_title" style="color: var(--text-heading);">Select Bus Category</h2>
            <p style="color: var(--text-main); opacity: 0.9;">Manage buses for
                <?php echo htmlspecialchars($_SESSION['admin_district']); ?>
            </p>
        </div>

        <div class="selection-container">
            <!-- SETC -->
            <a href="add_bus.php?type=SETC" class="type-card setc shadow-lg border border-warning"
                style="background-color: black !important; box-shadow: 0 0 15px rgba(255, 215, 0, 0.2) !important;">
                <i class="bi bi-bus-front" style="color: #FFD700 !important; text-shadow: 0 0 15px #FFD700;"></i>
                <h3 style="color: #FFD700 !important; text-shadow: 0 0 10px #FFD700;">SETC</h3>
            </a>

            <!-- Point-To-Point -->
            <a href="add_bus.php?type=Point-To-Point" class="type-card ptp shadow-lg border border-warning"
                style="background-color: black !important; box-shadow: 0 0 15px rgba(255, 215, 0, 0.2) !important;">
                <i class="bi bi-signpost-split" style="color: #FFD700 !important; text-shadow: 0 0 15px #FFD700;"></i>
                <h3 style="color: #FFD700 !important; text-shadow: 0 0 10px #FFD700;">Point-To-Point</h3>
            </a>

            <!-- Route Bus -->
            <a href="add_bus.php?type=Route Bus" class="type-card route shadow-lg border border-warning"
                style="background-color: black !important; box-shadow: 0 0 15px rgba(255, 215, 0, 0.2) !important;">
                <i class="bi bi-map" style="color: #FFD700 !important; text-shadow: 0 0 15px #FFD700;"></i>
                <h3 style="color: #FFD700 !important; text-shadow: 0 0 10px #FFD700;">Route Bus</h3>
            </a>
        </div>

    <?php else: ?>
        <!-- Form Screen -->
        <div class="container d-flex justify-content-center align-items-center"
            style="min-height: 70vh; margin-top: 30px; margin-bottom: 50px;">
            <div class="card p-4 shadow-lg border-0" style="max-width: 800px; width: 100%; border-radius: 12px;">
                <div class="text-center mb-4">
                    <div class="badge bg-primary-subtle text-primary mb-2 px-3 py-2 rounded-pill">
                        <?php echo htmlspecialchars($_SESSION['admin_district']); ?> District
                    </div>
                    <h3 class="mt-2 fw-bold" style="color: var(--gray-900);">Add <?php echo htmlspecialchars($bus_type); ?>
                    </h3>
                </div>

                <?php if ($message): ?>
                    <div class="alert alert-info text-center border-0 shadow-sm"><?php echo $message; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <input type="hidden" name="bus_type" value="<?php echo htmlspecialchars($bus_type); ?>">

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary">Bus Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                <input type="text" name="bus_number" class="form-control" placeholder="e.g. TN 72 N 1234"
                                    style="text-transform: uppercase;" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary">Overall Route</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-signpost-split"></i></span>
                                <input type="text" name="route" class="form-control"
                                    placeholder="e.g. <?php echo htmlspecialchars($_SESSION['admin_district']); ?> - Chennai"
                                    required>
                            </div>
                        </div>
                    </div>

                    <!-- SETC: 2 Shifts -->
                    <?php if ($bus_type === 'SETC'): ?>
                        <h5 class="text-primary mt-4 mb-3 border-bottom pb-2">Shift Times (2 Shifts)</h5>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label fw-bold text-secondary">Shift 1</label>
                                <input type="time" name="shift1" class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold text-secondary">Shift 2</label>
                                <input type="time" name="shift2" class="form-control" required>
                            </div>
                        </div>

                        <h5 class="text-primary mt-4 mb-3 border-bottom pb-2">Route Stops (4 Stops)</h5>
                        <div class="row g-3">
                            <div class="col-md-3 col-6">
                                <input type="text" name="stop1" class="form-control" placeholder="Stop 1" required>
                            </div>
                            <div class="col-md-3 col-6">
                                <input type="text" name="stop2" class="form-control" placeholder="Stop 2" required>
                            </div>
                            <div class="col-md-3 col-6">
                                <input type="text" name="stop3" class="form-control" placeholder="Stop 3" required>
                            </div>
                            <div class="col-md-3 col-6">
                                <input type="text" name="stop4" class="form-control" placeholder="Stop 4" required>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Route Bus: 4 Shifts + 9 Stops (Min 6) -->
                    <?php if ($bus_type === 'Route Bus'): ?>
                        <h5 class="text-success mt-4 mb-3 border-bottom pb-2">Shift Times (4 Shifts)</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-3 col-6">
                                <label class="form-label small fw-bold">Shift 1</label>
                                <input type="time" name="shift1" class="form-control" required>
                            </div>
                            <div class="col-md-3 col-6">
                                <label class="form-label small fw-bold">Shift 2</label>
                                <input type="time" name="shift2" class="form-control" required>
                            </div>
                            <div class="col-md-3 col-6">
                                <label class="form-label small fw-bold">Shift 3</label>
                                <input type="time" name="shift3" class="form-control" required>
                            </div>
                            <div class="col-md-3 col-6">
                                <label class="form-label small fw-bold">Shift 4</label>
                                <input type="time" name="shift4" class="form-control" required>
                            </div>
                        </div>

                        <h5 class="text-success mt-4 mb-3 border-bottom pb-2">Route Stops (Min 6 Required)</h5>
                        <div class="row g-3">
                            <div class="col-md-4 col-6">
                                <input type="text" name="stop1" class="form-control" placeholder="Stop 1" required>
                            </div>
                            <div class="col-md-4 col-6">
                                <input type="text" name="stop2" class="form-control" placeholder="Stop 2" required>
                            </div>
                            <div class="col-md-4 col-6">
                                <input type="text" name="stop3" class="form-control" placeholder="Stop 3" required>
                            </div>
                            <div class="col-md-4 col-6">
                                <input type="text" name="stop4" class="form-control" placeholder="Stop 4" required>
                            </div>
                            <div class="col-md-4 col-6">
                                <input type="text" name="stop5" class="form-control" placeholder="Stop 5" required>
                            </div>
                            <div class="col-md-4 col-6">
                                <input type="text" name="stop6" class="form-control" placeholder="Stop 6" required>
                            </div>
                            <div class="col-md-4 col-6">
                                <input type="text" name="stop7" class="form-control" placeholder="Stop 7">
                            </div>
                            <div class="col-md-4 col-6">
                                <input type="text" name="stop8" class="form-control" placeholder="Stop 8">
                            </div>
                            <div class="col-md-4 col-6">
                                <input type="text" name="stop9" class="form-control" placeholder="Stop 9">
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Point-To-Point: 6 Shifts -->
                    <?php if ($bus_type === 'Point-To-Point'): ?>
                        <h5 class="text-warning mt-4 mb-3 border-bottom pb-2">Shift Times (6 Shifts)</h5>
                        <div class="row g-3">
                            <div class="col-md-4 col-6">
                                <label class="form-label small fw-bold">Shift 1</label>
                                <input type="time" name="shift1" class="form-control" required>
                            </div>
                            <div class="col-md-4 col-6">
                                <label class="form-label small fw-bold">Shift 2</label>
                                <input type="time" name="shift2" class="form-control" required>
                            </div>
                            <div class="col-md-4 col-6">
                                <label class="form-label small fw-bold">Shift 3</label>
                                <input type="time" name="shift3" class="form-control" required>
                            </div>
                            <div class="col-md-4 col-6">
                                <label class="form-label small fw-bold">Shift 4</label>
                                <input type="time" name="shift4" class="form-control" required>
                            </div>
                            <div class="col-md-4 col-6">
                                <label class="form-label small fw-bold">Shift 5</label>
                                <input type="time" name="shift5" class="form-control" required>
                            </div>
                            <div class="col-md-4 col-6">
                                <label class="form-label small fw-bold">Shift 6</label>
                                <input type="time" name="shift6" class="form-control" required>
                            </div>
                        </div>

                        <h5 class="text-warning mt-4 mb-3 border-bottom pb-2">Route Stops (2 Stops)</h5>
                        <div class="row g-3">
                            <div class="col-6">
                                <input type="text" name="stop1" class="form-control" placeholder="Stop 1" required>
                            </div>
                            <div class="col-6">
                                <input type="text" name="stop2" class="form-control" placeholder="Stop 2" required>
                            </div>
                        </div>
                    <?php endif; ?>

                    <button type="submit" class="btn btn-primary w-100 btn-lg rounded-pill mt-4">Add Bus</button>
                </form>

                <div class="text-center mt-4">
                    <a href="add_bus.php" class="text-decoration-none text-muted">Change Bus Type</a>
                    <br>
                    <a href="platform_dashboard.php" class="btn btn-sm btn-outline-secondary mt-2">Back to Dashboard</a>
                </div>
            </div>
        </div>
    <?php endif; ?>

</body>

</html>