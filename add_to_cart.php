<?php  
include 'connection.php';
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo 'Please log in to add items to the cart.';
    exit();
}

$userID = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $productID = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    $editedPrice = isset($_POST['price']) ? floatval($_POST['price']) : null;

    if ($quantity > 0) {
        // Check available stock
        $stockCheckSql = "SELECT Quantity FROM products WHERE ID = ?";
        $stockStmt = $conn->prepare($stockCheckSql);
        if ($stockStmt) {
            $stockStmt->bind_param("i", $productID);
            $stockStmt->execute();
            $stockStmt->bind_result($availableQuantity);
            $stockStmt->fetch();
            $stockStmt->close();

            if ($quantity > $availableQuantity) {
                echo 'Invalid quantity: Requested quantity exceeds available stock.';
                exit();
            }

            // Insert product into `cart` table with appropriate details
            $insertSql = "INSERT INTO cart (UserID, ProductID, Quantity, AddedDate) VALUES (?, ?, ?, NOW())";
            $stmt = $conn->prepare($insertSql);
            if ($stmt) {
                $stmt->bind_param("iii", $userID, $productID, $quantity);
                if ($stmt->execute()) {
                    echo 'Product added to cart successfully';
                } else {
                    echo 'Failed to add product to cart: ' . $stmt->error;
                }
                $stmt->close();
            } else {
                echo 'Database error: Could not prepare statement.';
            }

        } else {
            echo 'Database error: Could not check stock availability.';
            exit();
        }
    } else {
        echo 'Invalid quantity: Quantity must be greater than zero.';
    }
    $conn->close();
} else {
    echo 'Invalid request method.';
}
?>
