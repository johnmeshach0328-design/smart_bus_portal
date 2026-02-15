<?php
session_start();
if (!isset($_SESSION['platform_incharge'])) {
    header("Location: platform_incharge_login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bus_number = $_POST['bus_number'] ?? '';
    $route = $_POST['route'] ?? '';

    if ($bus_number && $route) {
        $conn = new mysqli("localhost","root","","smart_bus_portal");

        if ($conn->connect_error) {
            die("Connection failed: ".$conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO buses (bus_number, route) VALUES (?, ?)");
        $stmt->bind_param("ss", $bus_number, $route);
        if ($stmt->execute()) {
            $message = "Bus added successfully!";
        } else {
            $message = "Error: ".$stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        $message = "Please fill in all fields!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Bus</title>
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
            max-width: 500px;
            background: #fff;
            padding: 35px 30px;
            border-radius: 10px;
            box-shadow: 0 12px 25px rgba(0,0,0,0.25);
            text-align: center;
        }

        .container h2 {
            color: #2a5298;
            margin-bottom: 25px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
            color: #555;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #2a5298;
            box-shadow: 0 0 6px rgba(42,82,152,0.3);
        }

        button {
            padding: 12px 30px;
            background: #2a5298;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            display: block;
            margin: 0 auto;
            transition: background 0.2s;
        }

        button:hover {
            background: #1e3c72;
        }

        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            font-weight: bold;
        }

        .success { background: #e0ffe0; color: #006600; }
        .error { background: #ffe3e3; color: #b00000; }

        .back-container {
            text-align: center;
            margin-top: 20px;
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

        @media(max-width:500px){
            .container {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add New Bus</h2>

    <?php if($message): ?>
        <div class="message <?php echo strpos($message, 'success') !== false ? 'success' : 'error'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <label>Bus Number</label>
        <input type="text" name="bus_number" placeholder="Enter Bus Number" required>

        <label>Route</label>
        <input type="text" name="route" placeholder="Enter Route" required>

        <button type="submit">Add Bus</button>
    </form>

    <div class="back-container">
        <a class="back-btn" href="platform_dashboard.php">Back to Dashboard</a>
    </div>
</div>

</body>
</html>
