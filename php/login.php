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

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['userType'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit();
}

$userType = $data['userType'];

if ($userType === 'patient') {
    $patientName = $conn->real_escape_string($data['patientName'] ?? '');
    $patientAadhar = $conn->real_escape_string($data['patientAadhar'] ?? '');

    if (empty($patientName) || empty($patientAadhar)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing patient credentials']);
        exit();
    }

    $sql = "SELECT * FROM patients WHERE patientName = '$patientName' AND patientAadhar = '$patientAadhar' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'name' => $row['patientName'], 'aadhar' => $row['patientAadhar']]);
    } else {
        echo json_encode(['status' => 'failure']);
    }

} elseif ($userType === 'hospital') {
    $hospitalName = $conn->real_escape_string($data['hospitalName'] ?? '');
    $hospitalId = $conn->real_escape_string($data['hospitalId'] ?? '');

    if (empty($hospitalName) || empty($hospitalId)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing hospital credentials']);
        exit();
    }

    $sql = "SELECT * FROM hospitals WHERE hospitalName = '$hospitalName' AND hospitalId = '$hospitalId' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'name' => $row['hospitalName']]);
    } else {
        echo json_encode(['status' => 'failure']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid user type']);
}

$conn->close();
?>
