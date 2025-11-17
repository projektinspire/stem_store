<?php
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['order_id'] ?? null;

    if ($orderId) {
        // Begin transaction to ensure data integrity
        mysqli_begin_transaction($conn);
        
        try {
            // Delete the order items first (foreign key constraint handling)
            $deleteItemsQuery = "DELETE FROM hold_order_item WHERE OrderID = ?";
            $stmt = mysqli_prepare($conn, $deleteItemsQuery);
            mysqli_stmt_bind_param($stmt, 'i', $orderId);
            mysqli_stmt_execute($stmt);

            // Now delete the main order
            $deleteOrderQuery = "DELETE FROM hold_orders WHERE ID = ?";
            $stmt = mysqli_prepare($conn, $deleteOrderQuery);
            mysqli_stmt_bind_param($stmt, 'i', $orderId);
            mysqli_stmt_execute($stmt);

            // Commit transaction
            mysqli_commit($conn);

            // Redirect back with a success message
            header("Location: {$_SERVER['HTTP_REFERER']}?status=deleted");
            exit();
        } catch (Exception $e) {
            // Rollback the transaction if any error occurs
            mysqli_roll_back($conn);
            echo "Error deleting order: " . $e->getMessage();
        }
    } else {
        echo "Invalid Order ID.";
    }
}

mysqli_close($conn);
?>
