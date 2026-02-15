<?php
// generate_fleet_data.php
require_once 'config/db.php';

// Disable time limit for large data generation
set_time_limit(0);
ini_set('memory_limit', '1024M');

echo "Starting massive fleet generation...\n";

// Districts and Zones
$districts = [
    // North Zone
    "Chennai" => "North", "Tiruvallur" => "North", "Kancheepuram" => "North", 
    "Chengalpattu" => "North", "Ranipet" => "North", "Vellore" => "North", 
    "Tirupathur" => "North", "Tiruvannamalai" => "North",

    // West Zone
    "Coimbatore" => "West", "Tiruppur" => "West", "Erode" => "West", 
    "Namakkal" => "West", "Salem" => "West", "Dharmapuri" => "West", 
    "Krishnagiri" => "West", "Nilgiris" => "West",

    // Central Zone
    "Tiruchirappalli" => "Central", "Karur" => "Central", "Perambalur" => "Central", 
    "Ariyalur" => "Central", "Thanjavur" => "Central", "Tiruvarur" => "Central", 
    "Nagapattinam" => "Central", "Mayiladuthurai" => "Central", "Pudukkottai" => "Central",

    // North-Central (Coastal)
    "Viluppuram" => "NorthCentral", "Kallakurichi" => "NorthCentral", "Cuddalore" => "NorthCentral",

    // South Zone
    "Madurai" => "South", "Dindigul" => "South", "Theni" => "South", 
    "Virudhunagar" => "South", "Sivaganga" => "South", "Ramanathapuram" => "South",

    // Deep South Zone
    "Tirunelveli" => "DeepSouth", "Tenkasi" => "DeepSouth", 
    "Thoothukudi" => "DeepSouth", "Kanniyakumari" => "DeepSouth"
];

// Helper to get random district from specific zones
function getRandomDistrictFromZones($targetZones, $excludeDistrict) {
    global $districts;
    $candidates = [];
    foreach ($districts as $d => $z) {
        if (in_array($z, $targetZones) && $d !== $excludeDistrict) {
            $candidates[] = $d;
        }
    }
    return $candidates[array_rand($candidates)];
}

// Helper to get ANY random district except current
function getRandomDistrictExcept($excludeDistrict) {
    global $districts;
    $candidates = array_keys($districts);
    $key = array_search($excludeDistrict, $candidates);
    if ($key !== false) unset($candidates[$key]);
    return $candidates[array_rand($candidates)];
}

// Ensure Incharges Exist
$inchargeIds = [];
$stmtCheck = $conn->prepare("SELECT id FROM platform_incharges WHERE district = ?");
$stmtInsert = $conn->prepare("INSERT INTO platform_incharges (username, password, district) VALUES (?, ?, ?)");
$defaultPass = password_hash("admin123", PASSWORD_DEFAULT);

foreach (array_keys($districts) as $dist) {
    $stmtCheck->bind_param("s", $dist);
    $stmtCheck->execute();
    $res = $stmtCheck->get_result();
    if ($row = $res->fetch_assoc()) {
        $inchargeIds[$dist] = $row['id'];
    } else {
        $user = strtolower(str_replace(' ', '_', $dist)) . "_admin";
        $stmtInsert->bind_param("sss", $user, $defaultPass, $dist);
        $stmtInsert->execute();
        $inchargeIds[$dist] = $conn->insert_id;
        echo "Created admin for $dist\n";
    }
}
$stmtCheck->close();
$stmtInsert->close();

// Prepare Insert Statement
$sql = "INSERT IGNORE INTO buses (incharge_id, bus_number, route, bus_type, district, 
        shift1_time, shift2_time, shift3_time, shift4_time, shift5_time, shift6_time,
        stop1, stop2, stop3, stop4, stop5, stop6, stop7, stop8, stop9) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmtBus = $conn->prepare($sql);

$totalInserted = 0;
$batchSize = 500;
$conn->begin_transaction();

foreach ($districts as $dist => $zone) {
    echo "Processing $dist ($zone)...\n";
    $inchargeId = $inchargeIds[$dist];

    // --- 1. SETC Buses (200 per district) ---
    // Target: Long distance (different zone)
    for ($i = 0; $i < 200; $i++) {
        // Pick destination zone based on current zone to ensure distance
        $targetZones = [];
        switch ($zone) {
            case 'North': $targetZones = ['South', 'DeepSouth', 'West', 'Central']; break;
            case 'West': $targetZones = ['North', 'South', 'DeepSouth', 'Central', 'NorthCentral']; break;
            case 'Central': $targetZones = ['North', 'DeepSouth', 'West', 'South']; break;
            case 'South': $targetZones = ['North', 'NorthCentral', 'West', 'DeepSouth']; break;
            case 'DeepSouth': $targetZones = ['North', 'NorthCentral', 'West', 'Central']; break;
            case 'NorthCentral': $targetZones = ['West', 'South', 'DeepSouth']; break;
            default: $targetZones = ['North', 'South']; break;
        }

        $dest = getRandomDistrictFromZones($targetZones, $dist);
        
        $busNum = "TN " . rand(10, 99) . " N " . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
        $route = "$dist - $dest";
        
        // Generate Stops
        $stops = [$dist];
        // Add 2 random intermediate stops (mocking towns)
        $stops[] = "Highway Stop " . rand(1, 100);
        $stops[] = "Toll Plaza " . rand(1, 50);
        $stops[] = $dest;
        
        // Pad stops to 9
        $stopParams = array_pad($stops, 9, null);

        // Shifts for SETC (Long distance - fewer trips/day)
        $s1 = date('H:i:s', rand(18000, 36000)); // Morning 5am-10am
        $s2 = date('H:i:s', rand(54000, 72000)); // Evening 3pm-8pm
        
        $busType = 'SETC';
        $null = null;
        
        $stmtBus->bind_param("isssssssssssssssssss", 
            $inchargeId, $busNum, $route, $busType, $dist,
            $s1, $s2, $null, $null, $null, $null,
            $stopParams[0], $stopParams[1], $stopParams[2], $stopParams[3], 
            $stopParams[4], $stopParams[5], $stopParams[6], $stopParams[7], $stopParams[8]
        );
        $stmtBus->execute();
        $totalInserted++;

        if ($totalInserted % $batchSize == 0) {
            $conn->commit();
            $conn->begin_transaction();
        }
    }

    // --- 2. Point-to-Point Buses (400 per district) ---
    // Target: Any district (can be closer)
    for ($i = 0; $i < 400; $i++) {
        $dest = getRandomDistrictExcept($dist);
        
        $busNum = "TN " . rand(10, 99) . " P " . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
        $route = "$dist - $dest Express";
        
        // Stops: Just Origin and Destination
        $stopParams = array_pad([$dist, $dest], 9, null);

        // Shifts for PtP (Frequent)
        $s1 = date('H:i:s', rand(21600, 28800)); // 6am-8am
        $s2 = date('H:i:s', rand(32400, 39600)); // 9am-11am
        $s3 = date('H:i:s', rand(43200, 50400)); // 12pm-2pm
        $s4 = date('H:i:s', rand(54000, 61200)); // 3pm-5pm
        $s5 = date('H:i:s', rand(64800, 72000)); // 6pm-8pm
        
        $busType = 'Point-To-Point';
        $null = null;
        
        $stmtBus->bind_param("isssssssssssssssssss", 
            $inchargeId, $busNum, $route, $busType, $dist,
            $s1, $s2, $s3, $s4, $s5, $null,
            $stopParams[0], $stopParams[1], $stopParams[2], $stopParams[3], 
            $stopParams[4], $stopParams[5], $stopParams[6], $stopParams[7], $stopParams[8]
        );
        $stmtBus->execute();
        $totalInserted++;

        if ($totalInserted % $batchSize == 0) {
            $conn->commit();
            $conn->begin_transaction();
            echo "   Inserted $totalInserted buses...\n";
        }
    }
}

$conn->commit();
echo "Done! Total buses inserted: $totalInserted\n";
?>
