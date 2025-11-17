<?php
// order_success.php

session_start();
require 'db_connection.php';

// Get the order ID from the URL
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($order_id <= 0) {
    echo "Invalid order ID.";
    exit();
}

// Fetch order details if needed
$stmt = $pdo->prepare("SELECT * FROM orders WHERE ID = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch();

if (!$order) {
    echo "Order not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Success</title>
    <!-- Include your CSS here -->
</head>
<body>
    <div class="container mt-5">
        <h1>Thank You for Your Order!</h1>
        <p>Your order has been placed successfully.</p>
        <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order_id); ?></p>
        <p><strong>Total Price:</strong> Tsh <?php echo number_format($order['TotalPrice'], 2); ?></p>
        <a href="orders.php" class="btn btn-primary">View Orders</a>
    </div>
</body>
</html>
