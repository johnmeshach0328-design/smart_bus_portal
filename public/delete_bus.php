<?php
session_start();
if (!isset($_SESSION['platform_incharge'])) {
    header("Location: platform_incharge_login.php");
    exit;
}

$message = "";
require_once 'db.php';

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $admin_dist = $_SESSION['admin_district'] ?? '';
    // Security check: Ensure admin can only delete their own district's buses
    $stmt = $conn->prepare("DELETE FROM buses WHERE id = ? AND district = ?");
    $stmt->bind_param("is", $id, $admin_dist);
    if($stmt->execute()) {
        $message = "Bus deleted successfully!";
    }
}

$bus_type = $_GET['type'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Bus</title>
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
    </div>
</nav>

<?php if (!$bus_type): ?>
    <!-- Selection Screen -->
    <div class="text-center mt-5">
        <h2 class="fw-bold" id="page_title" style="color: var(--text-heading);">Delete Bus</h2>
        <p style="color: var(--text-main); opacity: 0.9;" id="lbl_sel_cat">Select a category to manage deletions</p>
    </div>

    <div class="selection-container">
        <!-- SETC -->
        <a href="delete_bus.php?type=SETC" class="type-card setc">
            <i class="bi bi-bus-front text-danger"></i>
            <h3 class="text-danger">SETC</h3>
        </a>
        
        <!-- Point-To-Point -->
        <a href="delete_bus.php?type=Point-To-Point" class="type-card ptp">
            <i class="bi bi-signpost-split text-danger"></i>
            <h3 class="text-danger">Point-To-Point</h3>
        </a>
        
        <!-- Route Bus -->
        <a href="delete_bus.php?type=Route Bus" class="type-card route">
            <i class="bi bi-map text-danger"></i>
            <h3 class="text-danger">Route Bus</h3>
        </a>
    </div>

<?php else: 
    $admin_dist = $_SESSION['admin_district'] ?? '';
    $stmt = $conn->prepare("SELECT * FROM buses WHERE bus_type = ? AND district = ?");
    $stmt->bind_param("ss", $bus_type, $admin_dist);
    $stmt->execute();
    $result = $stmt->get_result();
?>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-danger"><i class="bi bi-trash me-2"></i> <span id="card_del_bus">Delete Bus</span>: <?php echo htmlspecialchars($bus_type); ?></h2>
            <a href="delete_bus.php" class="btn btn-outline-secondary rounded-pill">Change Category</a>
        </div>
        
        <?php if($message): ?>
            <div class="alert alert-success shadow-sm rounded-pill text-center mb-4"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="table-responsive shadow-sm rounded">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th class="bg-light text-secondary text-uppercase small ls-1" id="th_bus_id">Bus Number</th>
                        <th class="bg-light text-secondary text-uppercase small ls-1" id="th_route">Route</th>
                        <th class="bg-light text-secondary text-uppercase small ls-1 text-center" id="th_action">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="fw-bold"><?php echo htmlspecialchars($row['bus_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['route']); ?></td>
                            <td class="text-center">
                                <a href="delete_bus.php?type=<?php echo urlencode($bus_type); ?>&delete=<?php echo $row['id']; ?>" 
                                   class="btn btn-danger btn-sm rounded-pill px-3" 
                                   onclick="return confirm('Are you sure you want to delete this bus? This action cannot be undone.')">
                                   <i class="bi bi-trash-fill me-1"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="3" class="text-center py-4 text-muted">No buses found to delete.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

</body>
</html>