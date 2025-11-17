<?php
// Database connection
include '../connection.php';  // Include the connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerID = intval($_POST['customerID']);
    $LPO = intval($_POST['LPO']);

    if ($customerID && $LPO) {
        // Update the LPO for the selected customer
        $sql = "UPDATE customers SET LPO = ? WHERE CustomerID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $LPO, $customerID);

        if ($stmt->execute()) {
            echo "LPO has been successfully updated.";
        } else {
            echo "Error updating LPO: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Invalid input. Please provide both CustomerID and LPO.";
    }

    $conn->close();
}
?>
