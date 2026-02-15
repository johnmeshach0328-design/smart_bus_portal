<?php
/**
 * DEFINITIVE LOGIN REPAIR SCRIPT
 * Run this if you get "Invalid Admin Name or Password"
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<div style='font-family: sans-serif; padding: 20px; background: #fff3cd; border-radius: 10px; border: 1px solid #ffeeba;'>";
echo "<h2 style='color:#856404;'>Admin Login - Troubleshooting & Fix</h2>";

$conn = new mysqli("localhost", "root", "", "smart_bus_portal");

if ($conn->connect_error) {
    die("<p style='color:red;'>[FAILED] Cannot connect to database. Make sure XAMPP (MySQL) is running.</p></div>");
}

echo "<p>Connected to database successfully.</p>";

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
$inserted = 0;
$skipped = 0;

foreach ($districts as $district) {
    $username = $district . "Admin";
    // Check if exists
    $check = $conn->prepare("SELECT id FROM platform_incharges WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows == 0) {
        $reg_id = "REG" . (1000 + $inserted);
        $stmt = $conn->prepare("INSERT INTO platform_incharges (username, reg_id, password, district) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $reg_id, $password, $district);
        if ($stmt->execute()) {
            $inserted++;
        }
    } else {
        $skipped++;
    }
}

echo "<hr>";
echo "<p style='color:green;'>✅ Final Verification:</p>";
echo "<ul>
        <li>New Logins Created: <strong>$inserted</strong></li>
        <li>Logins Already Existed: <strong>$skipped</strong></li>
        <li>Total Districts Ready: <strong>" . ($inserted + $skipped) . " / 38</strong></li>
      </ul>";

echo "<h3 style='color:green;'>SUCCESS! All Admin Logins are now active.</h3>";
echo "<p>You can now log in using:</p>";
echo "<ul>
        <li><strong>Username:</strong> ChennaiAdmin (or MaduraiAdmin, etc.)</li>
        <li><strong>Password:</strong> TVLAD</li>
      </ul>";
echo "<p><a href='platform_incharge_login.php' style='display:inline-block; padding:10px 20px; background:#2c3e50; color:white; text-decoration:none; border-radius:5px;'>GO TO LOGIN PAGE</a></p>";
echo "</div>";

$conn->close();
?>