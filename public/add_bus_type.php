<?php
session_start();
if (!isset($_SESSION['district'])) {
    header("Location: platform_incharge_login.php");
    exit();
}
$district = $_SESSION['district'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Bus Type</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="assets/CSS/custom_style.css" rel="stylesheet">
    <script src="assets/js/theme-manager.js"></script>
    <script src="assets/js/font-color-loader.js"></script>
</head>

<body class="bg-movable bg-index bg-overlay">
    <!-- Background Animation -->
    <ul class="circles">
        <li></li><li></li><li></li><li></li><li></li>
        <li></li><li></li><li></li><li></li><li></li>
    </ul>

    <nav class="navbar navbar-expand-lg backdrop-blur shadow-sm">
        <div class="container-fluid">
            <span class="navbar-brand fw-bold">Select Bus Type</span>
            <span class="navbar-text">
                <?php echo $district; ?> |
                <a href="platform_incharge_dashboard.php" class="btn btn-sm btn-outline-secondary rounded-pill">Back</a>
            </span>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row g-4 justify-content-center">
            <?php
            $busTypes = [
                "Point-to-Point",
                "Town",
                "Mofussil",
                "MTC",
                "AC"
            ];

            foreach ($busTypes as $type) {
                echo '
                <div class="col-md-3">
                    <div class="card shadow-sm text-center">
                        <div class="card-body">
                            <h5 class="card-title">'.$type.' Bus</h5>
                            <a href="add_bus_dist.php?type='.$type.'" class="btn btn-primary">
                                Select
                            </a>
                        </div>
                    </div>
                </div>
                ';
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/page-transitions.js"></script>
</body>
</html>
