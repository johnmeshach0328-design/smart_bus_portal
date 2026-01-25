<?php
session_start();

if (!isset($_SESSION['platform_incharge'])) {
    header("Location: platform_incharge_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Platform Dashboard</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f9;
            margin: 0;
        }

        /* Header */
        .header {
            background: linear-gradient(120deg, #1e3c72, #2a5298);
            color: #fff;
            padding: 18px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h2 {
            margin: 0;
            font-size: 22px;
        }

        .header a {
            color: #fff;
            text-decoration: none;
            background: rgba(255,255,255,0.2);
            padding: 8px 14px;
            border-radius: 5px;
            font-size: 14px;
        }

        .header a:hover {
            background: rgba(255,255,255,0.35);
        }

        /* Dashboard Container */
        .container {
            padding: 30px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.15);
        }

        .card h3 {
            margin: 0 0 10px;
            color: #333;
        }

        .card p {
            color: #666;
            font-size: 14px;
        }

        .card a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            background: #2a5298;
            color: #fff;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
        }

        .card a:hover {
            background: #1e3c72;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 15px;
            font-size: 13px;
            color: #777;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<!-- Header -->
<div class="header">
    <h2>Platform Incharge Dashboard</h2>
    <a href="logout.php">Logout</a>
</div>

<!-- Dashboard Content -->
<div class="container">
    <div class="cards">

        <div class="card">
            <h3>Add Bus</h3>
            <a href="add_bus.php">Add Bus</a>
        </div>

        <div class="card">
            <h3>View Buses</h3>
            <a href="fetch_all_buses.php">View Buses</a>
        </div>

    </div>
</div>

<div class="footer">
</div>

</body>
</html>
