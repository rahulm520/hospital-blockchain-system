<?php
// Disable error display to prevent HTML output interfering with JSON response
ini_set('display_errors', 0);
error_reporting(0);
ob_start();

header('Content-Type: application/json');

// Read the raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON input']);
    ob_end_flush();
    exit;
}

// Validate required fields
$required_fields = ['patientAadhar', 'date', 'time', 'treatment', 'doctorName', 'hospitalName'];
foreach ($required_fields as $field) {
    if (!array_key_exists($field, $data)) {
        echo json_encode(['status' => 'error', 'message' => "Missing field: $field"]);
        ob_end_flush();
        exit;
    }
}

// Database connection parameters - updated DB name as per user input
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error]);
    ob_end_flush();
    exit;
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO medical_records (patientAadhar, date, time, treatment, medication, doctorName, note, hospitalName) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
    ob_end_flush();
    exit;
}

// Assign variables from input data with null coalescing for optional fields
$patientAadhar = $data['patientAadhar'];
$date = $data['date'];
$time = $data['time'];
$treatment = $data['treatment'];
$medication = $data['medication'] ?? null;
$doctorName = $data['doctorName'];
$note = $data['note'] ?? null;
$hospitalName = $data['hospitalName'];

$stmt->bind_param("ssssssss", $patientAadhar, $date, $time, $treatment, $medication, $doctorName, $note, $hospitalName);

// Execute statement
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Record inserted successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Execute failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close();

ob_end_flush();
?>
