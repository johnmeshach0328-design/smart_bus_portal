<?php
session_start();

/* LOGIN PROTECTION */
if (!isset($_SESSION['platform_incharge'])) {
    header("Location: platform_incharge_login.php");
    exit();
}

/* FETCH BUS DATA */
$buses = [];

/* Include only if file exists */
if (file_exists("fetch_all_buses.php")) {
    include "fetch_all_buses.php";   // should set $buses array
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Platform Incharge Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
        }
        .header {
            background-color: #1b5e20;
            color: white;
            padding: 15px;
            text-align: center;
            position: relative;
        }
        .logout {
            position: absolute;
            right: 20px;
            top: 18px;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        .container {
            width: 90%;
            margin: 25px auto;
            background: white;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th {
            background-color: #4caf50;
            color: white;
            padding: 10px;
        }
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        select, button {
            padding: 6px;
        }
        button {
            background-color: #2196f3;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 3px;
        }
        .empty {
            text-align: center;
            padding: 20px;
            color: #777;
        }
    </style>
</head>

<body>

<div class="header">
    <h2>Platform Incharge Dashboard</h2>
    <a href="logout.php" class="logout">Logout</a>
</div>

<div class="container">
    <h3>Bus Schedule Management</h3>

    <table>
        <tr>
            <th>Bus ID</th>
            <th>Route</th>
            <th>Departure Time</th>
            <th>Arrival Time</th>
            <th>Status</th>
            <th>Update Status</th>
        </tr>

        <?php if (!empty($buses)) { ?>
            <?php foreach ($buses as $bus) { ?>
                <tr>
                    <td><?= htmlspecialchars($bus['bus_id']) ?></td>
                    <td><?= htmlspecialchars($bus['route']) ?></td>
                    <td><?= htmlspecialchars($bus['departure_time']) ?></td>
                    <td><?= htmlspecialchars($bus['arrival_time']) ?></td>
                    <td><?= htmlspecialchars($bus['status']) ?></td>
                    <td>
                        <form action="update_status.php" method="POST">
                            <input type="hidden" name="bus_id" value="<?= $bus['bus_id'] ?>">
                            <select name="status">
                                <option value="On Time">On Time</option>
                                <option value="Delayed">Delayed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                            <button type="submit">Save</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="6" class="empty">
                    No bus schedules available.
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
