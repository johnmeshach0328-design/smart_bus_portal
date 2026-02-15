<?php
$conn = new mysqli("localhost", "root", "", "smart_bus_portal");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$districts = [
    "Ariyalur",
    "Chengalpattu",
    "Chennai",
    "Coimbatore",
    "Cuddalore",
    "Dharmapuri",
    "Dindigul",
    "Erode",
    "Kallakurichi",
    "Kancheepuram",
    "Kanniyakumari",
    "Karur",
    "Krishnagiri",
    "Madurai",
    "Mayiladuthurai",
    "Nagapattinam",
    "Namakkal",
    "Nilgiris",
    "Perambalur",
    "Pudukkottai",
    "Ramanathapuram",
    "Ranipet",
    "Salem",
    "Sivaganga",
    "Tenkasi",
    "Thanjavur",
    "Theni",
    "Thoothukudi",
    "Tiruchirappalli",
    "Tirunelveli",
    "Tirupathur",
    "Tiruppur",
    "Tiruvallur",
    "Tiruvannamalai",
    "Tiruvarur",
    "Vellore",
    "Viluppuram",
    "Virudhunagar"
];

$password = "TVLAD";
$count = 0;

foreach ($districts as $district) {
    $username = $district . "Admin";
    // Check if user already exists
    $check = $conn->prepare("SELECT id FROM platform_incharges WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows == 0) {
        $reg_id = "REG" . (1000 + $count);
        $stmt = $conn->prepare("INSERT INTO platform_incharges (username, reg_id, password, district) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $reg_id, $password, $district);
        if ($stmt->execute()) {
            $count++;
        }
    }
}

echo "<h3>Successfully created $count new district logins!</h3>";
echo "<p>All new logins use the password: <strong>$password</strong></p>";
echo "<a href='platform_incharge_login.php'>Go to Staff Login</a>";

$conn->close();
?>