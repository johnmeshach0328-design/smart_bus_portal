<?php
session_start();
header('Content-Type: application/json');
require_once 'db.php';

// Check connection
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

// Get the raw POST data
$data = json_decode(file_get_contents("php://input"), true);
$action = $data['action'] ?? 'chat'; // Default to chat

// HANDLE FETCH MESSAGES ACTION
if ($action === 'fetch_messages') {
    $district = $data['district'] ?? '';
    if (empty($district)) {
        echo json_encode(['status' => 'error', 'message' => 'District required']);
        exit;
    }

    // Fetch latest non-expired message for this district
    $stmt = $conn->prepare("SELECT message, created_at FROM district_messages WHERE district = ? AND (expires_at IS NULL OR expires_at > NOW()) ORDER BY created_at DESC LIMIT 1");
    $stmt->bind_param("s", $district);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode(['status' => 'success', 'message' => $row['message'], 'time' => $row['created_at']]);
    } else {
        echo json_encode(['status' => 'empty', 'message' => 'No new announcements']);
    }
    
    $stmt->close();
    $conn->close();
    exit;
}

$userMessage = $data['message'] ?? '';

if (empty($userMessage)) {
    echo json_encode(['status' => 'error', 'message' => 'Please enter a destination.']);
    exit;
}

$searchQuery = "%" . $conn->real_escape_string($userMessage) . "%";

// Search query to find buses where the route or any stop matches the user's input
$sql = "SELECT * FROM buses WHERE 
        route LIKE ? OR 
        stop1 LIKE ? OR 
        stop2 LIKE ? OR 
        stop3 LIKE ? OR 
        stop4 LIKE ? OR 
        stop5 LIKE ? OR 
        stop6 LIKE ? OR 
        stop7 LIKE ? OR 
        stop8 LIKE ? OR 
        stop9 LIKE ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssssssss",
    $searchQuery,
    $searchQuery,
    $searchQuery,
    $searchQuery,
    $searchQuery,
    $searchQuery,
    $searchQuery,
    $searchQuery,
    $searchQuery,
    $searchQuery
);

$stmt->execute();
$result = $stmt->get_result();

$buses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Filter out empty shifts/stops for cleaner response if needed, 
        // but for now, sending the raw row data or a simplified version is fine.
        $buses[] = [
            'id' => $row['id'],
            'bus_number' => $row['bus_number'],
            'route' => $row['route'],
            'type' => $row['bus_type'],
            'district' => $row['district'],
            // sending shifts to show timings
            'shifts' => array_filter([
                $row['shift1_time'],
                $row['shift2_time'],
                $row['shift3_time'],
                $row['shift4_time'],
                $row['shift5_time'],
                $row['shift6_time']
            ])
        ];
    }

    $responseMessage = "I found " . count($buses) . " buses matching '" . htmlspecialchars($userMessage) . "'.";
    $responseMessage = "I found " . count($buses) . " buses matching '" . htmlspecialchars($userMessage) . "'.";
} else {
    // Fuzzy Search Logic
    $locations = [
        "Ariyalur", "Chengalpattu", "Chennai", "Coimbatore", "Cuddalore", 
        "Dharmapuri", "Dindigul", "Erode", "Kallakurichi", "Kancheepuram", 
        "Kanniyakumari", "Karur", "Krishnagiri", "Madurai", "Mayiladuthurai", 
        "Nagapattinam", "Namakkal", "Nilgiris", "Perambalur", "Pudukkottai", 
        "Ramanathapuram", "Ranipet", "Salem", "Sivaganga", "Tenkasi", 
        "Thanjavur", "Theni", "Thoothukudi", "Tiruchirappalli", "Trichy",
        "Tirunelveli", "Tirupathur", "Tiruppur", "Tiruvallur", "Tiruvannamalai", 
        "Tiruvarur", "Vellore", "Viluppuram", "Virudhunagar",
        "Pollachi", "Ooty", "Kodaikanal", "Rameswaram", "Hosur", "Nagercoil",
        "Tuticorin", "Pondicherry", "Tambaram", "Velachery"
    ];

    $bestMatch = null;
    $shortestDist = -1;
    $cleanQuery = strtolower(trim($userMessage));

    foreach ($locations as $loc) {
        $dist = levenshtein($cleanQuery, strtolower($loc));
        $len = max(strlen($cleanQuery), strlen($loc));
        $percent = 1 - ($dist / $len);

        // Allow distance up to 3 for shorter words, maybe more for longer?
        // Let's stick to standard dist <= 3 AND similarity > 50%
        if ($dist <= 3 && $percent > 0.4) {
             if ($shortestDist < 0 || $dist < $shortestDist) {
                 $shortestDist = $dist;
                 $bestMatch = $loc;
             }
        }
    }

    if ($bestMatch) {
         $responseMessage = "I couldn't find buses for '" . htmlspecialchars($userMessage) . "'. Did you mean **" . $bestMatch . "**? Try searching for that.";
    } else {
        // Fallback to Gemini API if no local match found
        $aiResponse = callGeminiAPI($userMessage);
        if ($aiResponse) {
            $responseMessage = $aiResponse;
        } else {
            $responseMessage = "Sorry, I couldn't find any buses going to '" . htmlspecialchars($userMessage) . "'. Please check the spelling or try a nearby major stop.";
        }
    }
}

echo json_encode([
    'status' => 'success',
    'reply' => $responseMessage,
    'data' => $buses
]);

$stmt->close();
$conn->close();

function callGeminiAPI($prompt) {
    // REPLACE WITH YOUR ACTUAL API KEY
    $apiKey = "YOUR_GEMINI_API_KEY_HERE"; 
    
    if ($apiKey === "YOUR_GEMINI_API_KEY_HERE") {
        return null; // API key not set
    }

    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $apiKey;

    $data = [
        "contents" => [
            [
                "parts" => [
                    ["text" => "You are a helpful assistant for the Smart Bus Portal in Tamil Nadu. You help users with bus inquiries. Context: We have buses for 38 districts including SETC, Point-to-Point, and Route Buses. If the user asks about specific bus timings that you don't know, suggest they search by District in the portal. User message: " . $prompt]
                ]
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_decode(json_encode($data))); // Ensure JSON specific filtering/format if needed, but json_encode($data) is fine
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    
    // Disable SSL verification for local dev (XAMPP often has issues with certificates)
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        return null; 
    }
    
    curl_close($ch);
    
    $decoded = json_decode($response, true);
    
    if (isset($decoded['candidates'][0]['content']['parts'][0]['text'])) {
        return $decoded['candidates'][0]['content']['parts'][0]['text'];
    }
    
    return null;
}
?>