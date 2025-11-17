<?php 
include '../connection.php';
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
        // Update `EditedPrice` in the `products` table if provided
        if ($editedPrice !== null) {
            $updateSql = "UPDATE products SET EditedPrice = ? WHERE ID = ?";
            $updateStmt = $conn->prepare($updateSql);
            if ($updateStmt) {
                $updateStmt->bind_param("di", $editedPrice, $productID);
                $updateStmt->execute();
                $updateStmt->close();
            }
        }

        // Insert product into `cart` table with appropriate details
        $insertSql = "INSERT INTO cart (UserID, ProductID, Quantity, EditedPrice, AddedDate) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($insertSql);
        if ($stmt) {
            // Bind EditedPrice, passing null if not set
            $stmt->bind_param("iiid", $userID, $productID, $quantity, $editedPrice);
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
        echo 'Invalid quantity.';
    }
    $conn->close();
} else {
    echo 'Invalid request method.';
}
?>
