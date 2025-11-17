<?php
include '../connection.php';

// Set the response header to JSON
header('Content-Type: application/json');

try {
    // Ensure the request method is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Get JSON input data
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Check if JSON data was parsed successfully
    if (!$data) {
        throw new Exception('Invalid JSON data');
    }

    // Ensure both order_id and status are provided
    if (!isset($data['order_id']) || !isset($data['status'])) {
        throw new Exception('Missing order_id or status in the request');
    }

    $orderID = $data['order_id'];
    $newStatus = $data['status'];

    // Prepare and execute SQL query to update payment status
    $query = "UPDATE orders SET PaymentStatus = ? WHERE ID = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        throw new Exception('Failed to prepare statement: ' . $conn->error);
    }

    $stmt->bind_param('si', $newStatus, $orderID);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Payment status updated']);
    } else {
        throw new Exception('Error executing statement: ' . $stmt->error);
    }

    // Close the statement
    $stmt->close();
} catch (Exception $e) {
    // Send error response with a 400 HTTP status
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    // Close the database connection
    $conn->close();
}
?>
