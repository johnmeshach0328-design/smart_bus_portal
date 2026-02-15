<?php
// db connection
$conn = new mysqli("localhost", "root", "", "smart_bus");
if ($conn->connect_error) {
    die("Database connection failed");
}

// Fetch buses when district is selected
$buses = [];
if (isset($_POST['district'])) {
    $district = $_POST['district'];
    $stmt = $conn->prepare("SELECT id, bus_number FROM buses WHERE district = ?");
    $stmt->bind_param("s", $district);
    $stmt->execute();
    $buses = $stmt->get_result();
}

// Delete bus
if (isset($_POST['delete_bus'])) {
    $bus_id = $_POST['bus_id'];
    $stmt = $conn->prepare("DELETE FROM buses WHERE id = ?");
    $stmt->bind_param("i", $bus_id);
    $stmt->execute();
    echo "<script>alert('Bus deleted successfully');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Bus</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
        }
        .box {
            width: 400px;
            margin: 80px auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        select, button {
            width: 100%;
            padding: 10px;
            margin-top: 12px;
        }
        button {
            background: #dc3545;
            border: none;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background: #c82333;
        }
    </style>
</head>

<body>

<div class="box">
    <h2>Delete Bus</h2>

    <!-- STEP 1: Select District -->
    <form method="post">
        <label>Select District</label>
        <select name="district" onchange="this.form.submit()" required>
            <option value="">-- Select District --</option>
            <?php
            $districts = [
                "Ariyalur","Chengalpattu","Chennai","Coimbatore","Cuddalore","Dharmapuri",
                "Dindigul","Erode","Kallakurichi","Kanchipuram","Kanniyakumari","Karur",
                "Krishnagiri","Madurai","Mayiladuthurai","Nagapattinam","Namakkal",
                "Nilgiris","Perambalur","Pudukkottai","Ramanathapuram","Ranipet","Salem",
                "Sivagangai","Tenkasi","Thanjavur","Theni","Thoothukudi","Tiruchirappalli",
                "Tirunelveli","Tirupathur","Tiruppur","Tiruvallur","Tiruvannamalai",
                "Tiruvarur","Vellore","Viluppuram","Virudhunagar"
            ];

            foreach ($districts as $d) {
                $selected = (isset($district) && $district == $d) ? "selected" : "";
                echo "<option $selected>$d</option>";
            }
            ?>
        </select>
    </form>

    <!-- STEP 2: Show Buses of Selected District -->
    <?php if (!empty($buses)) { ?>
        <form method="post">
            <input type="hidden" name="district" value="<?= $district ?>">

            <label>Select Bus Number</label>
            <select name="bus_id" required>
                <option value="">-- Select Bus --</option>
                <?php while ($row = $buses->fetch_assoc()) { ?>
                    <option value="<?= $row['id'] ?>">
                        <?= $row['bus_number'] ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit" name="delete_bus">Delete Bus</button>
        </form>
    <?php } ?>
</div>

</body>
</html>
