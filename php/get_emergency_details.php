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
$stmt = $conn->prepare("SELECT blood_group, allergies, chronic_conditions, emergency_contact_father_name, emergency_contact_father_phone, emergency_contact_mother_name, emergency_contact_mother_phone FROM emergency_medical_details WHERE patientAadhar = ?");
$stmt->bind_param("s", $patientAadhar);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'details' => $row]);
} else {
    echo json_encode(['status' => 'failure', 'message' => 'No emergency details found']);
}

$stmt->close();
$conn->close();
?>
