<?php
include '../connection.php';

if (isset($_GET['OrderID'])) {
    $orderId = intval($_GET['OrderID']);

    $stmt = $conn->prepare("UPDATE orders SET Views = Views + 1 WHERE ID = ?");
    $stmt->bind_param('i', $orderId);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
?>
