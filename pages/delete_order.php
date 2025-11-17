<?php
include '../connection.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['order_id'])) {
    $orderId = $data['order_id'];

    // Delete order items first (to maintain referential integrity)
    $stmt = $conn->prepare("DELETE FROM order_items WHERE OrderID = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();

    // Delete the order itself
    $stmt = $conn->prepare("DELETE FROM orders WHERE ID = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Order not found or could not be deleted.']);
    }
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid order ID.']);
}
?>
