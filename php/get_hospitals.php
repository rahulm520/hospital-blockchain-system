<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

$sql = "SELECT hospitalName FROM hospitals ORDER BY hospitalName ASC";
$result = $conn->query($sql);

$hospitals = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $hospitals[] = $row['hospitalName'];
    }
    echo json_encode(['status' => 'success', 'hospitals' => $hospitals]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch hospitals']);
}

$conn->close();
?>
