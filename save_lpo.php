<?php
// Database connection
include 'connection.php'; // Ensure the connection file is properly included

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch and sanitize input data
    $customerID = isset($_POST['customerID']) ? intval($_POST['customerID']) : 0;
    $newLPO = isset($_POST['LPO']) && $_POST['LPO'] !== '' ? trim($_POST['LPO']) : null;
    $address = isset($_POST['Address']) && $_POST['Address'] !== '' ? trim($_POST['Address']) : null;

    if ($customerID > 0) {
        // Update existing customer: overwrite LPO and Address
        $stmt = $conn->prepare("UPDATE customers SET LPO = ?, Address = ? WHERE CustomerID = ?");
        if (!$stmt) {
            die("Prepare statement failed: " . $conn->error);
        }

        $stmt->bind_param('ssi', $newLPO, $address, $customerID);
        if ($stmt->execute()) {
            echo "Customer details have been successfully updated. Existing values were replaced.";
        } else {
            echo "Error updating customer details: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Insert a new customer if customerID is not provided
        if ($newLPO !== null || $address !== null) {
            $stmt = $conn->prepare("INSERT INTO customers (LPO, Address) VALUES (?, ?)");
            if (!$stmt) {
                die("Prepare statement failed: " . $conn->error);
            }

            $stmt->bind_param('ss', $newLPO, $address);
            if ($stmt->execute()) {
                echo "New customer added successfully with LPO and Address.";
            } else {
                echo "Error adding new customer: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Please provide valid LPO or Address to insert.";
        }
    }

    // Close database connection
    $conn->close();
} else {
    echo "Invalid request method. Please use POST.";
}
?>
