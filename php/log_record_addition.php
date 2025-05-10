<?php
// Updated log_record_addition.php to store extended log details silently

// Database connection parameters - adjust as needed
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_db"; // Use your actual database name

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get data from POST request (expects JSON)
    $data = json_decode(file_get_contents('php://input'), true);

    // Required fields
    $requiredFields = ['hospital_name', 'patient_aadhar', 'blockchain_tx', 'status', 'source'];

    // Check if all required fields are present
    foreach ($requiredFields as $field) {
        if (empty($data[$field])) {
            // Missing required field, silently skip insertion
            exit();
        }
    }

    $hospitalName = $data['hospital_name'];
    $patientAadhar = $data['patient_aadhar'];
    $blockchainTx = $data['blockchain_tx'];
    $status = $data['status'];
    $source = $data['source'];
    $geoLocation = isset($data['geo_location']) ? $data['geo_location'] : null;
    $timestamp = date('Y-m-d H:i:s');
    $ipAddress = $_SERVER['REMOTE_ADDR'];

    // Prepare and execute insert statement
    $stmt = $conn->prepare("INSERT INTO record_addition_log (timestamp, ip_address, hospital_name, patient_aadhar, blockchain_tx, status, source, geo_location) VALUES (:timestamp, :ip_address, :hospital_name, :patient_aadhar, :blockchain_tx, :status, :source, :geo_location)");

    $stmt->bindParam(':timestamp', $timestamp);
    $stmt->bindParam(':ip_address', $ipAddress);
    $stmt->bindParam(':hospital_name', $hospitalName);
    $stmt->bindParam(':patient_aadhar', $patientAadhar);
    $stmt->bindParam(':blockchain_tx', $blockchainTx);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':source', $source);
    $stmt->bindParam(':geo_location', $geoLocation);

    $stmt->execute();

} catch (PDOException $e) {
    // Silently fail without output
    exit();
}
?>
