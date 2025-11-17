<?php
include '../connection.php';

try {
    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method");
    }

    // Verify and sanitize POST data
    if (empty($_POST['order_id']) || empty($_POST['status'])) {
        throw new Exception("Order ID and status are required fields");
    }

    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    // Prepare an SQL statement to update the status
    $query = "UPDATE orders SET Status = ? WHERE ID = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $conn->error);
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("si", $status, $order_id);

    if ($stmt->execute()) {
        // Redirect back to the sales page if successful
        header("Location: ../index2.php");
        exit;
    } else {
        throw new Exception("Error updating record: " . $stmt->error);
    }
} catch (Exception $e) {
    // Display error message for debugging
    echo "Error: " . $e->getMessage();
} finally {
    // Close the statement and connection
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
}
?>
