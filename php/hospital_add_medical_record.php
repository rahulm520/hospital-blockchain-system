<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON input']);
    exit;
}

$required_fields = ['patientName', 'patientAadhar', 'date', 'time', 'treatment', 'doctorName'];
foreach ($required_fields as $field) {
    if (empty($input[$field])) {
        echo json_encode(['status' => 'error', 'message' => "Missing required field: $field"]);
        exit;
    }
}

$patientName = $input['patientName'];
$patientAadhar = $input['patientAadhar'];
$date = $input['date'];
$time = $input['time'];
$treatment = $input['treatment'];
$medication = isset($input['medication']) ? $input['medication'] : '';
$doctorName = $input['doctorName'];
$note = isset($input['note']) ? $input['note'] : '';
$hospitalName = isset($input['hospitalName']) ? $input['hospitalName'] : '';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

// Optional: Verify patient exists
$stmt = $conn->prepare("SELECT id FROM patients WHERE patientName = ? AND patientAadhar = ?");
$stmt->bind_param("ss", $patientName, $patientAadhar);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Patient not found']);
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// Verify doctor works in the specified hospital
if ($hospitalName) {
    $doctor_check_stmt = $conn->prepare("SELECT id FROM doctors WHERE name = ? AND hospitalName = ?");
    $doctor_check_stmt->bind_param("ss", $doctorName, $hospitalName);
    $doctor_check_stmt->execute();
    $doctor_check_stmt->store_result();
    if ($doctor_check_stmt->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Selected doctor does not work in the specified hospital']);
        $doctor_check_stmt->close();
        $conn->close();
        exit;
    }
    $doctor_check_stmt->close();
}

$insert_stmt = $conn->prepare("INSERT INTO medical_records (patientAadhar, date, time, treatment, medication, doctorName, note, hospitalName) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$insert_stmt->bind_param("ssssssss", $patientAadhar, $date, $time, $treatment, $medication, $doctorName, $note, $hospitalName);

if ($insert_stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to add medical record']);
}

$insert_stmt->close();
$conn->close();
?>
