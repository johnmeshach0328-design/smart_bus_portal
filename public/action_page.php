<?php
$district_id = $_POST['district_id'] ?? '';
$bus_type_id = $_POST['bus_type_id'] ?? '';
$action = $_POST['action'] ?? '';

if ($district_id == '' || $bus_type_id == '') {
    die("District or Bus Type not selected");
}

switch ($action) {
    case 'add':
        header("Location: add_bus.php?district=$district_id&type=$bus_type_id");
        break;

    case 'delete':
        header("Location: delete_bus.php?district=$district_id&type=$bus_type_id");
        break;

    case 'view':
        header("Location: view_bus.php?district=$district_id&type=$bus_type_id");
        break;

    case 'attendance':
        header("Location: attendance.php?district=$district_id&type=$bus_type_id");
        break;

    default:
        echo "Invalid Action";
}
exit;
