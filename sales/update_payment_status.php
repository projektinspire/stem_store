<?php
include '../connection.php';

// Get the POST data from the AJAX request
$data = json_decode(file_get_contents("php://input"), true);
$orderID = $data['order_id'];
$status = $data['status'];

if (!in_array($status, ['Pending', 'Paid'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid status']);
    exit;
}

// Update the order's PaymentStatus in the database
$query = "UPDATE orders SET PaymentStatus = ? WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('si', $status, $orderID);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update payment status']);
}
