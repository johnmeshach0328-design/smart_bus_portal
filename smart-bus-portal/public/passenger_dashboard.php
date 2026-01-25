<?php
$conn = new mysqli("localhost", "root", "", "smart_bus_portal");

if ($conn->connect_error) {
    die("Connection failed");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Passenger Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">Available Bus List</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Bus Number</th>
                <th>Route</th>
            </tr>
        </thead>
        <tbody>

        <?php
        $sql = "SELECT * FROM buses";
        $result = $conn->query($sql);
        $i = 1;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$i++."</td>";
                echo "<td>".$row['bus_number']."</td>";
                echo "<td>".$row['route']."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3' class='text-center'>No buses available</td></tr>";
        }
        ?>

        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-secondary">Logout</a>
    </div>
</div>

</body>
</html>
