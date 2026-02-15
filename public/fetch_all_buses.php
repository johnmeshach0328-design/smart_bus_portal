<?php
session_start();
if (!isset($_SESSION['platform_incharge'])) {
    header("Location: platform_incharge_login.php");
    exit;
}

$bus_type = $_GET['type'] ?? '';
require_once 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Buses</title>
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

<nav class="navbar navbar-expand-lg backdrop-blur shadow-sm mb-4">
    <div class="container-fluid">
        <a class="navbar-brand text-dark fw-bold" href="platform_dashboard.php">
            <i class="bi bi-arrow-left-circle me-2"></i>Dashboard
        </a>
    </div>
</nav>

<?php if (!$bus_type): ?>
    <!-- Selection Screen -->
    <div class="text-center mt-5">
        <h2 class="fw-bold" id="card_view_bus" style="color: var(--text-heading);">View Buses</h2>
        <p style="color: var(--text-main); opacity: 0.9;" id="lbl_sel_cat">Select a category to view currently active buses</p>
    </div>

    <div class="selection-container">
        <!-- SETC -->
        <a href="fetch_all_buses.php?type=SETC" class="type-card setc">
            <i class="bi bi-bus-front text-primary"></i>
            <h3 class="text-primary">SETC</h3>
        </a>
        
        <!-- Point-To-Point -->
        <a href="fetch_all_buses.php?type=Point-To-Point" class="type-card ptp">
            <i class="bi bi-signpost-split text-warning"></i>
            <h3 class="text-warning">Point-To-Point</h3>
        </a>
        
        <!-- Route Bus -->
        <a href="fetch_all_buses.php?type=Route Bus" class="type-card route">
            <i class="bi bi-map text-success"></i>
            <h3 class="text-success">Route Bus</h3>
        </a>
    </div>

<?php else: 
    $admin_dist = $_SESSION['admin_district'] ?? '';
    $stmt = $conn->prepare("SELECT * FROM buses WHERE bus_type = ? AND district = ?");
    $stmt->bind_param("ss", $bus_type, $admin_dist);
    $stmt->execute();
    $result = $stmt->get_result();
?>
    <!-- List Screen -->
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark"><i class="bi bi-list-ul me-2"></i> <?php echo htmlspecialchars($bus_type); ?> List</h2>
            <a href="fetch_all_buses.php" class="btn btn-outline-secondary rounded-pill">Change Category</a>
        </div>
        
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th class="bg-light text-secondary text-uppercase small ls-1" id="th_bus_id">Bus Number</th>
                        <th class="bg-light text-secondary text-uppercase small ls-1" id="th_route">Route</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="fw-bold text-primary"><?php echo htmlspecialchars($row['bus_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['route']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="2" class="text-center py-4 text-muted">No buses found in this category.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

</body>
</html>
