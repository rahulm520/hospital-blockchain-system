<?php
header('Content-Type: application/json');

$search = isset($_GET['search']) ? $_GET['search'] : '';
$hospitalName = isset($_GET['hospitalName']) ? $_GET['hospitalName'] : '';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

$search_param = "%$search%";
$hospital_param = $hospitalName;

if ($hospitalName) {
    $stmt = $conn->prepare("SELECT name, specialist, experience, contact, hospitalName FROM doctors WHERE (name LIKE ? OR specialist LIKE ?) AND hospitalName = ?");
    $stmt->bind_param("sss", $search_param, $search_param, $hospital_param);
} else {
    $stmt = $conn->prepare("SELECT name, specialist, experience, contact, hospitalName FROM doctors WHERE name LIKE ? OR specialist LIKE ?");
    $stmt->bind_param("ss", $search_param, $search_param);
}
$stmt->execute();
$result = $stmt->get_result();

$doctors = [];
while ($row = $result->fetch_assoc()) {
    $doctors[] = $row;
}

echo json_encode(['status' => 'success', 'doctors' => $doctors]);

$stmt->close();
$conn->close();
?>
