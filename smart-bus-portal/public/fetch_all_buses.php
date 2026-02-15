<?php
session_start();
if (!isset($_SESSION['platform_incharge'])) {
    header("Location: platform_incharge_login.php");
    exit;
}

$conn = new mysqli("localhost","root","","smart_bus_portal");
if ($conn->connect_error) {
    die("Connection failed: ".$conn->connect_error);
}

// Run query
$sql = "SELECT * FROM buses ORDER BY created_at DESC";
$result = $conn->query($sql);

// Check if query succeeded
if(!$result){
    die("Query failed: ".$conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Buses</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 900px;
            background: #fff;
            padding: 30px 25px;
            border-radius: 10px;
            box-shadow: 0 12px 25px rgba(0,0,0,0.15);
            text-align: center;
        }

        .container h2 {
            color: #2a5298;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background: #2a5298;
            color: #fff;
            text-transform: uppercase;
        }

        table tr:hover {
            background: #f1f1f1;
        }

        .back-container {
            text-align: center;
            margin-top: 15px;
        }

        .back-btn {
            display: inline-block;
            text-decoration: none;
            background: #2a5298;
            color: #fff;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 14px;
            transition: background 0.2s;
        }

        .back-btn:hover {
            background: #1e3c72;
        }

        @media(max-width:600px){
            table th, table td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>All Buses</h2>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Bus Number</th>
                <th>Route</th>
                <th>Added On</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['bus_number']); ?></td>
                <td><?php echo htmlspecialchars($row['route']); ?></td>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No buses added yet.</p>
    <?php endif; ?>

    <div class="back-container">
        <a class="back-btn" href="platform_dashboard.php">Back to Dashboard</a>
    </div>
</div>

<?php $conn->close(); ?>
</body>
</html>
