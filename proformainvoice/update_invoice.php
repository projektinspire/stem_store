<?php 

include '../connection.php'; // Include your database connection file

// Check if order_id is provided
if (!isset($_POST['order_id']) || empty($_POST['order_id'])) {
    die("Invalid Order ID.");
}

$orderId = intval($_POST['order_id']);
$customerId = isset($_POST['customer_id']) ? intval($_POST['customer_id']) : 0;
$paymentMethod = isset($_POST['paymentMethod']) ? htmlspecialchars($_POST['paymentMethod']) : '';
$productsJson = isset($_POST['products']) ? $_POST['products'] : '[]';

// Decode JSON products data
$products = json_decode($productsJson, true);
if (!is_array($products) || empty($products)) {
    die("Invalid product data.");
}

// Calculate total and VAT
$totalWithoutVAT = 0;
foreach ($products as $product) {
    if (!isset($product['Quantity']) || !isset($product['Price'])) {
        die("Invalid product data format.");
    }
    $totalWithoutVAT += intval($product['Quantity']) * floatval($product['Price']);
}
$vatAmount = $totalWithoutVAT * (18 / 118);
$totalWithVAT = number_format($totalWithoutVAT + $vatAmount, 2, '.', '');

// Start database transaction
$conn->begin_transaction();
try {
    // Update Order details in hold_orders table
    $stmt = $conn->prepare("UPDATE hold_orders SET CustomerID = ?, PaymentMode = ?, TotalPrice = ?, UpdatedDate = NOW() WHERE ID = ?");
    $stmt->bind_param("isdi", $customerId, $paymentMethod, $totalWithVAT, $orderId);
    $stmt->execute();
    $stmt->close();

    // Delete old order items from hold_order_item table
    $stmt = $conn->prepare("DELETE FROM hold_order_item WHERE OrderID = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $stmt->close();

    // Insert new order items into hold_order_item table
    $stmt = $conn->prepare("INSERT INTO hold_order_item (OrderID, ProductID, Quantity, Price, AddedDate) VALUES (?, ?, ?, ?, NOW())");
    foreach ($products as $product) {
        $productId = getProductIdByName($product['ProductName'], $conn); // Get Product ID
        if ($productId) {
            $quantity = intval($product['Quantity']);
            $price = floatval($product['Price']);
            $stmt->bind_param("iiid", $orderId, $productId, $quantity, $price);
            $stmt->execute();
        }
    }
    $stmt->close();

    // Commit transaction
    $conn->commit();

    // Redirect to invoice.php
    header("Location: invoice.php?order_id=$orderId");
    exit();
} catch (Exception $e) {
    $conn->rollback();
    die("Error updating invoice: " . $e->getMessage());
}

// Function to get Product ID by Product Name
function getProductIdByName($productName, $conn) {
    $stmt = $conn->prepare("SELECT ID FROM products WHERE ProductName = ?");
    $stmt->bind_param("s", $productName);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return $row ? $row['ID'] : null;
}

?>
