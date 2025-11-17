<?php 
include 'connection.php';
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("Please log in to add a customer."); window.location.href = "index2.php";</script>';
    exit();
}

$userID = $_SESSION['user_id'];

// Check if the form was submitted using POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize customer name
    $customerName = isset($_POST['customerName']) ? trim($_POST['customerName']) : '';

    if (!empty($customerName)) {
        // Check if the customer already exists
        $selectSql = "SELECT CustomerID FROM customers WHERE CustomerName = ?";
        $stmt = $conn->prepare($selectSql);

        if ($stmt) {
            $stmt->bind_param("s", $customerName);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Customer already exists
                echo '<script>alert("Customer already exists."); window.location.href = "index2.php";</script>';
            } else {
                // Insert new customer
                $insertSql = "INSERT INTO customers (CustomerName) VALUES (?)";
                $insertStmt = $conn->prepare($insertSql);

                if ($insertStmt) {
                    $insertStmt->bind_param("s", $customerName);
                    if ($insertStmt->execute()) {
                        echo '<script>alert("Customer added successfully."); window.location.href = "index2.php";</script>';
                    } else {
                        echo '<script>alert("Failed to add customer: ' . $insertStmt->error . '"); window.location.href = "index2.php";</script>';
                    }
                    $insertStmt->close();
                } else {
                    echo '<script>alert("Database error: Could not prepare insert statement."); window.location.href = "index2.php";</script>';
                }
            }
            $stmt->close();
        } else {
            echo '<script>alert("Database error: Could not prepare select statement."); window.location.href = "index2.php";</script>';
        }
    } else {
        echo '<script>alert("Please enter a customer name."); window.location.href = "index2.php";</script>';
    }

    $conn->close();
} else {
    echo '<script>alert("Invalid request method."); window.location.href = "index2.php";</script>';
}
?>
