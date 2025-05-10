<?php
header('Content-Type: application/json');

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = ""; // default XAMPP MySQL password is empty
$dbname = "login_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit();
}

// Get patientAadhar from GET or POST
$patientAadhar = $_GET['patientAadhar'] ?? $_POST['patientAadhar'] ?? '';

if (empty($patientAadhar)) {
    echo json_encode(['status' => 'error', 'message' => 'Missing patient Aadhar']);
    exit();
}

// Prepare and execute query
$stmt = $conn->prepare("SELECT date, time, treatment, medication, doctorName, note, hospitalName FROM medical_records WHERE patientAadhar = ? ORDER BY date DESC, time DESC");
$stmt->bind_param("s", $patientAadhar);
$stmt->execute();
$result = $stmt->get_result();

$records = [];
while ($row = $result->fetch_assoc()) {
    $records[] = $row;
}

echo json_encode(['status' => 'success', 'records' => $records]);

$stmt->close();
$conn->close();
?>
