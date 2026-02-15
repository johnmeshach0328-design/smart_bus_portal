<?php
header('Content-Type: application/json');
require_once '../config/db.php'; // Adjust path if needed, usually db.php is in parent or same dir

// List of valid locations (Districts + Major Cities)
$locations = [
    "Ariyalur", "Chengalpattu", "Chennai", "Coimbatore", "Cuddalore", 
    "Dharmapuri", "Dindigul", "Erode", "Kallakurichi", "Kancheepuram", 
    "Kanniyakumari", "Karur", "Krishnagiri", "Madurai", "Mayiladuthurai", 
    "Nagapattinam", "Namakkal", "Nilgiris", "Perambalur", "Pudukkottai", 
    "Ramanathapuram", "Ranipet", "Salem", "Sivaganga", "Tenkasi", 
    "Thanjavur", "Theni", "Thoothukudi", "Tiruchirappalli", "Trichy", // Variant
    "Tirunelveli", "Tirupathur", "Tiruppur", "Tiruvallur", "Tiruvannamalai", 
    "Tiruvarur", "Vellore", "Viluppuram", "Virudhunagar",
    // Cities/Towns
    "Pollachi", "Ooty", "Kodaikanal", "Rameswaram", "Hosur", "Nagercoil",
    "Tuticorin", "Pondicherry", "Tambaram", "Velachery"
];

$query = $_GET['q'] ?? '';

if (strlen($query) < 2) {
    echo json_encode(['status' => 'empty', 'suggestions' => []]);
    exit;
}

$exactMatch = null;
$suggestions = [];

// Clean query
$cleanQuery = trim($query);
$lowercaseQuery = strtolower($cleanQuery);

// Check distances
foreach ($locations as $loc) {
    // Exact match (case-insensitive)
    if (strtolower($loc) === $lowercaseQuery) {
        $exactMatch = $loc;
        break; 
    }

    // Levenshtein
    $dist = levenshtein($lowercaseQuery, strtolower($loc));
    
    // Similarity percentage
    $percent = 1 - ($dist / max(strlen($lowercaseQuery), strlen($loc)));

    // Threshold: Distance <= 3 AND Similarity > 50%
    if ($dist <= 3 && $percent > 0.5) {
        $suggestions[$loc] = $dist;
    }
}

// Sort suggestions by distance
asort($suggestions);
$finalSuggestions = array_keys($suggestions);

echo json_encode([
    'status' => 'success',
    'query' => $cleanQuery,
    'exact_match' => $exactMatch,
    'suggestions' => array_slice($finalSuggestions, 0, 5) // Top 5
]);
?>
