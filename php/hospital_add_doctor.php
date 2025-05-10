<?php
header('Content-Type: application/json');

// Read the JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    exit;
}

$name = isset($input['name']) ? trim($input['name']) : '';
$specialist = isset($input['specialist']) ? trim($input['specialist']) : '';
$experience = isset($input['experience']) ? intval($input['experience']) : 0;
$contact = isset($input['contact']) ? trim($input['contact']) : '';
$hospitalName = isset($input['hospitalName']) ? trim($input['hospitalName']) : '';

if (!$name || !$specialist || $experience < 0 || !$hospitalName) {
    echo json_encode(['status' => 'error', 'message' => 'Missing or invalid required fields']);
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO doctors (name, specialist, experience, contact, hospitalName) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare statement']);
    $conn->close();
    exit;
}

$stmt->bind_param("ssiss", $name, $specialist, $experience, $contact, $hospitalName);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Doctor added successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to add doctor']);
}

$stmt->close();
$conn->close();
?>
