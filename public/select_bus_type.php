<?php
// select_bus_type.php

if (!isset($_GET['action'])) {
    die("No action selected");
}

$action = $_GET['action'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Bus Type</title>
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
        <li></li><li></li><li></li><li></li><li></li>
        <li></li><li></li><li></li><li></li><li></li>
    </ul>

    <div class="text-center mt-5">
        <h2 class="fw-bold" style="color: var(--text-heading);">Select Bus Type</h2>
    </div>

    <div class="selection-container">
        <a class="type-card route" href="<?= $action ?>_dist.php?type=town">
            <i class="bi bi-bus-front text-success"></i>
            <h3 class="text-success">Town Bus</h3>
        </a>
        <a class="type-card ptp" href="<?= $action ?>_dist.php?type=point">
            <i class="bi bi-signpost-split text-warning"></i>
            <h3 class="text-warning">Point to Point</h3>
        </a>
        <a class="type-card setc" href="<?= $action ?>_dist.php?type=mtc">
            <i class="bi bi-bus-front-fill text-primary"></i>
            <h3 class="text-primary">MTC</h3>
        </a>
        <a class="type-card setc" href="<?= $action ?>_dist.php?type=setc">
            <i class="bi bi-bus-front text-info"></i>
            <h3 class="text-info">SETC</h3>
        </a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/page-transitions.js"></script>
</body>
</html>
