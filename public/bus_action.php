<?php
$action = $_GET['action'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bus Management</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            padding: 30px;
        }
        .box {
            background: white;
            padding: 25px;
            border-radius: 8px;
            max-width: 800px;
            margin: auto;
        }
        h2 {
            margin-top: 0;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        button {
            background: #0d6efd;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
<div class="box">

<?php
/* ================= ADD BUS ================= */
if ($action == "add") {
    ?>
    <h2>Add Bus</h2>
    <form method="post">
        <input type="text" name="bus_no" placeholder="Bus Number" required>
        <input type="text" name="route" placeholder="Route Name" required>
        <button name="add_bus">Add Bus</button>
    </form>

    <?php
    if (isset($_POST['add_bus'])) {
        echo "<p style='color:green;'>Bus added successfully (demo).</p>";
    }
}

/* ================= DELETE BUS ================= */
elseif ($action == "delete") {
    ?>
    <h2>Delete Bus</h2>
    <form method="post">
        <input type="text" name="bus_no" placeholder="Enter Bus Number to Delete" required>
        <button name="delete_bus">Delete Bus</button>
    </form>

    <?php
    if (isset($_POST['delete_bus'])) {
        echo "<p style='color:red;'>Bus deleted successfully (demo).</p>";
    }
}

/* ================= VIEW BUS ================= */
elseif ($action == "view") {
    ?>
    <h2>View Buses</h2>
    <table>
        <tr>
            <th>Bus No</th>
            <th>Route</th>
            <th>Status</th>
        </tr>
        <tr>
            <td>TN01AB1234</td>
            <td>Chennai - Madurai</td>
            <td>Active</td>
        </tr>
        <tr>
            <td>TN02CD5678</td>
            <td>Coimbatore - Salem</td>
            <td>Active</td>
        </tr>
    </table>
    <?php
}

/* ================= ATTENDANCE ================= */
elseif ($action == "attendance") {
    ?>
    <h2>Mark Attendance</h2>
    <form method="post">
        <select name="bus_no">
            <option>TN01AB1234</option>
            <option>TN02CD5678</option>
        </select>

        <select name="status">
            <option value="Ready">Ready</option>
            <option value="Not Ready">Not Ready</option>
        </select>

        <button name="mark">Mark Attendance</button>
    </form>

    <?php
    if (isset($_POST['mark'])) {
        echo "<p style='color:green;'>Attendance marked successfully (demo).</p>";
    }
}

/* ================= INVALID ================= */
else {
    echo "<h2>Invalid Action</h2>";
}
?>

</div>
</body>
</html>
