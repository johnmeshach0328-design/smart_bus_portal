<?php
// add_bus_dist.php

if (!isset($_GET['type'])) {
    die("Bus type not selected. Please go back and select a bus type.");
}

$busType = htmlspecialchars($_GET['type']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Bus - <?= strtoupper($busType) ?></title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

        .header {
            background: #1f4e8c;
            color: white;
            padding: 15px 25px;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        h2 {
            margin-top: 0;
            margin-bottom: 20px;
        }

        .bus-type-badge {
            display: inline-block;
            background: #198754;
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn {
            margin-top: 20px;
            padding: 10px 22px;
            background: #0d6efd;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>

<body>

<div class="header">
    <h2>Platform Incharge – Add Bus</h2>
</div>

<div class="container">

    <span class="bus-type-badge">
        Bus Type: <?= strtoupper($busType) ?>
    </span>

    <h2>Add Bus Details</h2>

    <form action="add_bus_process.php" method="POST">

        <input type="hidden" name="bus_type" value="<?= $busType ?>">

        <div class="form-group">
            <label>Bus Number</label>
            <input type="text" name="bus_number" required>
        </div>

        <div class="form-group">
            <label>Route Name</label>
            <input type="text" name="route_name" required>
        </div>

        <div class="form-group">
            <label>District</label>
            <select name="district" required>
                <option value="">-- Select District --</option>
                <option>Ariyalur</option>
                <option>Chengalpattu</option>
                <option>Chennai</option>
                <option>Coimbatore</option>
                <option>Cuddalore</option>
                <option>Dharmapuri</option>
                <option>Dindigul</option>
                <option>Erode</option>
                <option>Kallakurichi</option>
                <option>Kanchipuram</option>
                <option>Kanyakumari</option>
                <option>Karur</option>
                <option>Krishnagiri</option>
                <option>Madurai</option>
                <option>Mayiladuthurai</option>
                <option>Nagapattinam</option>
                <option>Namakkal</option>
                <option>Nilgiris</option>
                <option>Perambalur</option>
                <option>Pudukkottai</option>
                <option>Ramanathapuram</option>
                <option>Ranipet</option>
                <option>Salem</option>
                <option>Sivaganga</option>
                <option>Tenkasi</option>
                <option>Thanjavur</option>
                <option>Theni</option>
                <option>Thoothukudi</option>
                <option>Tiruchirappalli</option>
                <option>Tirunelveli</option>
                <option>Tirupathur</option>
                <option>Tiruppur</option>
                <option>Tiruvallur</option>
                <option>Tiruvannamalai</option>
                <option>Tiruvarur</option>
                <option>Vellore</option>
                <option>Viluppuram</option>
                <option>Virudhunagar</option>
            </select>
        </div>

        <div class="form-group">
            <label>Driver Name</label>
            <input type="text" name="driver_name" required>
        </div>

        <div class="form-group">
            <label>Contact Number</label>
            <input type="text" name="contact_number" required>
        </div>

        <button type="submit" class="btn">Add Bus</button>

    </form>

</div>

</body>
</html>
