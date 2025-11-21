<?php
include '../connection.php';  // Include database connection

session_start(); // Start the session if not already started

// Ensure that the user is logged in and has a valid user ID
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$userID = $_SESSION['user_id']; // Get the user ID from session

// Clear any cart stored in the session
if (isset($_SESSION['cart'])) {
    unset($_SESSION['cart']); // Clear the session cart if it exists
}

// Prepare the SQL statement to delete all cart items for the user
$query = "DELETE FROM cart WHERE UserID = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Error preparing query: " . $conn->error); // Handle query preparation error
}

// Bind the user ID parameter
$stmt->bind_param("i", $userID);

// Execute the statement to clear the cart
if ($stmt->execute()) {
    // Check if any rows were affected
    if ($stmt->affected_rows > 0) {
        // Cart successfully cleared, redirect the user
        header('Location: Dashboard.php'); // Change to your desired redirect page
        exit;
    } else {
        // No rows affected, meaning the cart was already empty
        echo "No items to clear from the cart.";
    }
} else {
    // Handle execution error
    echo "Error clearing cart: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
