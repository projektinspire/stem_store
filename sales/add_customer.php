<?php
include '../connection.php';// Database connection
// Ensure you have your DB connection here

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['customerName'];
    $email = $_POST['customerEmail'];
    $phone = $_POST['customerPhone'];

    

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO customers (CustomerName, CustomerEmail, CustomerPhone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $phone);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit;
        
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to add customer.']);
    }

    $stmt->close();
    $conn->close();
}
?>
