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
} else {
    $responseMessage = "Sorry, I couldn't find any buses going to '" . htmlspecialchars($userMessage) . "'. Please check the spelling or try a nearby major stop.";
}

echo json_encode([
    'status' => 'success',
    'reply' => $responseMessage,
    'data' => $buses
]);

$stmt->close();
$conn->close();
?>