<?php
include '../connection.php';  // Include the connection file

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to modify the cart.";
    exit;
}

// Ensure the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get product ID and user ID from the form and session
    if (isset($_POST['productId'])) {
        $productId = $_POST['productId'];
        $userId = $_SESSION['user_id'];

        // Prepare the SQL statement to delete the item from the cart
        $query = "DELETE FROM cart WHERE ProductID = ? AND UserID = ?";
        $stmt = $conn->prepare($query);  // Use $conn from connection.php
        $stmt->bind_param("ii", $productId, $userId);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect back to the cart page or index page after deletion
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Error: Unable to delete the item.";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Invalid product ID.";
    }
} else {
    echo "Invalid request method.";
}
?>
