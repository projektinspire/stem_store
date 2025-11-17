<?php
include '../connection.php';

// Check if order ID is provided
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    echo json_encode(['success' => false, 'message' => 'Order ID is required']);
    exit;
}

$orderId = intval($_GET['order_id']);

// Query to fetch order data
$orderQuery = "
    SELECT 
        o.ID AS OrderID, u.username AS UserName, c.CustomerName, 
        o.TotalPrice, o.PaymentMode, o.AddedDate,
        o.PaymentStatus, o.Status, o.LPO, o.Address
    FROM orders o
    JOIN users u ON o.UserID = u.id 
    JOIN customers c ON o.CustomerID = c.CustomerID 
    WHERE o.ID = ?
";

$stmt = $conn->prepare($orderQuery);
$stmt->bind_param('i', $orderId);
$stmt->execute();
$orderResult = $stmt->get_result();

if ($orderRow = $orderResult->fetch_assoc()) {
    // Fetch order items
    $itemsQuery = "
        SELECT 
            oi.OrderID, oi.ProductID, p.ProductName, oi.Quantity, 
            oi.Price AS OrderedPrice
        FROM order_items oi
        JOIN products p ON oi.ProductID = p.ID 
        WHERE oi.OrderID = ?
    ";
    
    $stmt = $conn->prepare($itemsQuery);
    $stmt->bind_param('i', $orderId);
    $stmt->execute();
    $itemsResult = $stmt->get_result();
    
    $items = [];
    while ($item = $itemsResult->fetch_assoc()) {
        $items[] = $item;
    }
    
    // Prepare response
    $order = [
        'OrderID' => $orderRow['OrderID'],
        'UserName' => $orderRow['UserName'],
        'CustomerName' => $orderRow['CustomerName'],
        'PaymentMode' => $orderRow['PaymentMode'],
        'AddedDate' => $orderRow['AddedDate'],
        'PaymentStatus' => $orderRow['PaymentStatus'],
        'Status' => $orderRow['Status'] ?: 'Pending',
        'TotalPrice' => $orderRow['TotalPrice'],
        'LPO' => $orderRow['LPO'],
        'Address' => $orderRow['Address'],
        'Items' => $items
    ];
    
    echo json_encode(['success' => true, 'order' => $order]);
} else {
    echo json_encode(['success' => false, 'message' => 'Order not found']);
}

$conn->close();
?>
