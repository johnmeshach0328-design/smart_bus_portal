<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Select District & Bus Type</title>
</head>
<body>

<h2>Select District</h2>
<form method="POST" action="action_page.php">

    <select name="district_id" required>
        <option value="">-- Select District --</option>
        <?php
        $d = mysqli_query($conn, "SELECT * FROM districts ORDER BY district_name");
        while ($row = mysqli_fetch_assoc($d)) {
            echo "<option value='{$row['id']}'>{$row['district_name']}</option>";
        }
        ?>
    </select>

    <br><br>

    <h2>Select Bus Type</h2>
    <select name="bus_type_id" required>
        <option value="">-- Select Bus Type --</option>
        <?php
        $b = mysqli_query($conn, "SELECT * FROM bus_types");
        while ($row = mysqli_fetch_assoc($b)) {
            echo "<option value='{$row['id']}'>{$row['type_name']}</option>";
        }
        ?>
    </select>

    <br><br>

    <button type="submit" name="action" value="add">Add Bus</button>
    <button type="submit" name="action" value="delete">Delete Bus</button>
    <button type="submit" name="action" value="view">View Buses</button>
    <button type="submit" name="action" value="attendance">Attendance</button>

</form>

</body>
</html>
