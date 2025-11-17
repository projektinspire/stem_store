<?php
include '../connection.php';

if (isset($_GET['id'])) {
    $customerID = $_GET['id'];

    // Prepare and execute the delete statement
    $sql = "DELETE FROM customers WHERE CustomerID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customerID);

    if ($stmt->execute()) {
        echo "<script>alert('Customer deleted successfully'); window.location.href='customers.php';</script>";
    } else {
        echo "Error deleting customer: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No customer ID provided.";
}
?>
