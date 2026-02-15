<?php
/**
 * FORCE DIAGNOSTIC & AUTO-FIX SCRIPT
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<div style='font-family: sans-serif; padding: 30px; border: 2px solid #0d6efd; border-radius: 15px;'>";
echo "<h1 style='color:#0d6efd;'>🚨 CRITICAL LOGIN DIAGNOSTIC</h1>";

// 1. Check Directory
echo "<h3>1. Location Check</h3>";
echo "Current Folder: <strong>" . __DIR__ . "</strong><br>";

// 2. Check Database
echo "<h3>2. Database Check</h3>";
$conn = new mysqli("localhost", "root", "", "smart_bus_portal");

if ($conn->connect_error) {
    echo "<p style='color:red;'>❌ FAILED: Cannot connect to 'smart_bus_portal' database.</p>";
} else {
    echo "<p style='color:green;'>✅ SUCCESS: Connected to database.</p>";
}

// 3. Check Table Structure
$res = $conn->query("SHOW COLUMNS FROM platform_incharges");
if (!$res) {
    echo "<p style='color:red;'>❌ FAILED: 'platform_incharges' table NOT FOUND. Please run SQL setup.</p>";
} else {
    echo "Columns found in table: ";
    while ($col = $res->fetch_assoc())
        echo "<strong>" . $col['Field'] . "</strong>, ";
    echo "<br>";
}

// 4. Test Manual Match
echo "<h3>3. Credentials Test (ChennaiAdmin / TVLAD)</h3>";
$user = "ChennaiAdmin";
$pass = "TVLAD";

$stmt = $conn->prepare("SELECT * FROM platform_incharges WHERE username=? AND password=?");
$stmt->bind_param("ss", $user, $pass);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<p style='color:green; padding:10px; background:#d4edda;'>✅ PERFECT MATCH FOUND! The username and password ARE CORRECT in the database.</p>";
    $row = $result->fetch_assoc();
    echo "Found User ID: " . $row['id'] . "<br>";
    echo "Assigned District: " . $row['district'] . "<br>";
} else {
    echo "<p style='color:red; padding:10px; background:#f8d7da;'>❌ NO MATCH FOUND. The records might be missing or the password 'TVLAD' is wrong.</p>";

    // Auto-fix attempt
    echo "Attempting to FORCE-ADD ChennaiAdmin now...<br>";
    $fix = $conn->prepare("INSERT INTO platform_incharges (username, reg_id, password, district) VALUES ('ChennaiAdmin', 'DIAG100', 'TVLAD', 'Chennai')");
    if ($fix->execute()) {
        echo "<b style='color:green;'>SUCCESS! I have forced 'ChennaiAdmin' into the database.</b>";
    } else {
        echo "<b style='color:red;'>FAILED to insert: " . $conn->error . "</b>";
    }
}

echo "<hr>";
echo "<h2>👉 HOW TO FIX THE ERROR:</h2>";
echo "<ol>
        <li>If you see 'PERFECT MATCH FOUND' above, the database is correct.</li>
        <li>Make sure you type <strong>ChennaiAdmin</strong> (exactly like this, capital C and A).</li>
        <li>Make sure you type <strong>TVLAD</strong> in UPPERCASE.</li>
        <li>If it still fails, there might be a invisible space. I will update the login page to be even more strict.</li>
      </ol>";

echo "<p><a href='platform_incharge_login.php' style='display:inline-block; padding:12px 25px; background:#0d6efd; color:white; text-decoration:none; border-radius:8px;'>GO TO LOGIN PAGE</a></p>";
echo "</div>";

$conn->close();
?>