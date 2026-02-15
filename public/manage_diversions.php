<?php
session_start();
require_once 'db.php';

// Check login
if (!isset($_SESSION['platform_incharge'])) {
    header("Location: platform_incharge_login.php");
    exit();
}

$admin_district = $_SESSION['admin_district'];

// Fetch active diversions
$active_diversions = [];
$stmt = $conn->prepare("SELECT rd.*, b.bus_number 
                       FROM route_diversions rd 
                       JOIN buses b ON rd.bus_id = b.id 
                       WHERE rd.district = ? AND rd.completion_status != 'Completed'
                       ORDER BY rd.start_time ASC");
$stmt->bind_param("s", $admin_district);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $active_diversions[] = $row;
}
$stmt->close();

// Fetch available buses (registered in this district and NOT currently diverted)
$buses = [];
$sql = "SELECT id, bus_number, route FROM buses 
        WHERE district = ? 
        AND id NOT IN (SELECT bus_id FROM route_diversions WHERE completion_status != 'Completed')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $admin_district);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $buses[] = $row;
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Route Diversions | Smart Bus Portal</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="assets/CSS/custom_style.css" rel="stylesheet">
    <script src="assets/js/theme-manager.js"></script>
    <script src="assets/js/font-color-loader.js"></script>
</head>
<body class="bg-movable bg-index bg-overlay">
    <!-- Background Animation -->
    <ul class="circles">
        <li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li>
    </ul>

    <nav class="navbar navbar-expand-lg backdrop-blur shadow-sm mb-4">
        <div class="container-fluid">
            <a class="navbar-brand text-dark fw-bold" href="platform_dashboard.php">
                <i class="bi bi-arrow-left-circle me-2"></i>Dashboard
            </a>
            <span class="navbar-text ms-auto text-dark">Route Diversion Management</span>
        </div>
    </nav>

    <div class="container pb-5">
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Action completed successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Error occurred. Please try again.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Create Diversion Form -->
            <div class="col-lg-5">
                <div class="glass-panel p-4 h-100">
                    <h4 class="fw-bold mb-4" style="color: var(--text-heading);"><i class="bi bi-cone-striped me-2 text-warning"></i>Announce Diversion</h4>
                    
                    <form action="create_diversion_process.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Select Bus Checkpoints</label>
                            <select name="bus_id" class="form-select" required>
                                <option value="" selected disabled>Select a bus from <?php echo htmlspecialchars($admin_district); ?></option>
                                <?php foreach ($buses as $bus): ?>
                                    <option value="<?php echo $bus['id']; ?>">
                                        <?php echo htmlspecialchars($bus['bus_number'] . " (" . $bus['route'] . ")"); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text text-light-emphasis">Only showing currently available buses.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Temporary Route (4 Stops)</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-light"><i class="bi bi-geo-alt-fill text-primary"></i></span>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($admin_district); ?>" readonly 
                                       style="background: #e9ecef; cursor: not-allowed;" title="Origin is fixed to your district">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"><i class="bi bi-signpost-split"></i></span>
                                <input type="text" name="stop2" class="form-control" placeholder="2nd Stop" required>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"><i class="bi bi-signpost-split"></i></span>
                                <input type="text" name="stop3" class="form-control" placeholder="3rd Stop" required>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-flag-fill text-danger"></i></span>
                                <input type="text" name="stop4" class="form-control" placeholder="Destination Stop" required>
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label">Start Time</label>
                                <input type="datetime-local" name="start_time" class="form-control" required
                                       value="<?php echo date('Y-m-d\TH:i'); ?>">
                            </div>
                            <div class="col-6">
                                <label class="form-label">End Time</label>
                                <input type="datetime-local" name="end_time" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Emergency Reason</label>
                            <textarea name="emergency_reason" class="form-control" rows="3" 
                                      placeholder="e.g. Main bridge maintenance work..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-warning w-100 fw-bold border-0 py-3 rounded-pill shadow-sm hover-scale" 
                                style="background: var(--gradient-warning); color: #fff; font-size: 1.1rem; letter-spacing: 0.5px;">
                            <i class="bi bi-megaphone-fill me-2"></i>ANNOUNCE DIVERSION
                        </button>
                    </form>
                </div>
            </div>

            <!-- Active Diversions List -->
            <div class="col-lg-7">
                <div class="glass-panel p-4 h-100">
                    <h4 class="fw-bold mb-4" style="color: var(--text-heading);"><i class="bi bi-activity me-2 text-primary"></i>Active Diversions</h4>
                    
                    <?php if (empty($active_diversions)): ?>
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-check-circle fs-1 d-block mb-3 text-success opacity-50"></i>
                            <p>No active route diversions.</p>
                        </div>
                    <?php else: ?>
                        <div class="diversion-list">
                            <?php foreach ($active_diversions as $d): 
                                $is_active = strtotime($d['end_time']) > time();
                                $status_badge = $is_active 
                                    ? '<span class="badge bg-danger">Active</span>' 
                                    : '<span class="badge bg-secondary">Completing Trip</span>';
                            ?>
                            ?>
                                <div class="card mb-3 border-0 shadow-sm diversion-card" style="background: rgba(255,255,255,0.95); border-radius: 16px; transition: transform 0.2s;">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h5 class="fw-bold mb-1 text-primary">
                                                    <i class="bi bi-bus-front me-2"></i><?php echo htmlspecialchars($d['bus_number']); ?>
                                                </h5>
                                                <small class="text-muted">Original: <?php echo htmlspecialchars($d['original_route']); ?></small>
                                            </div>
                                            <?php echo $status_badge; ?>
                                        </div>
                                        
                                        <div class="alert alert-warning py-2 mb-2 small" style="color: #000 !important; background-color: #fff3cd !important; border-color: #ffecb5 !important;">
                                            <i class="bi bi-exclamation-triangle me-1"></i>
                                            <strong>Via:</strong> <?php echo htmlspecialchars($d['stop1'] . " → " . $d['stop2'] . " → " . $d['stop3'] . " → " . $d['stop4']); ?>
                                        </div>
                                        
                                        <p class="mb-2 small text-secondary">
                                            <strong>Reason:</strong> <?php echo htmlspecialchars($d['emergency_reason']); ?>
                                        </p>

                                        <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                                            <div class="small text-muted">
                                                <i class="bi bi-clock me-1"></i> Ends: 
                                                <strong><?php echo date('d M, h:i A', strtotime($d['end_time'])); ?></strong>
                                            </div>
                                            
                                            <form action="cancel_diversion.php" method="POST" onsubmit="return confirm('Are you sure you want to cancel this diversion? The bus will return to normal schedule.');">
                                                <input type="hidden" name="diversion_id" value="<?php echo $d['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                    End Diversion
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
