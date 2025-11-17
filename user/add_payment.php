<?php
// add_payment.php
include '../connection.php'; // Ensure this connects to your database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerId = $_POST['customer_id'] ?? null;
    $amount = $_POST['amount'] ?? null;
    $date = $_POST['date'] ?? null;

    // Validate inputs
    if (!$customerId || !is_numeric($customerId)) {
        http_response_code(400);
        echo "Invalid customer ID.";
        exit;
    }

    if (!$amount || !is_numeric($amount) || $amount <= 0) {
        http_response_code(400);
        echo "Invalid payment amount.";
        exit;
    }

    if (!$date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        http_response_code(400);
        echo "Invalid date format. Use YYYY-MM-DD.";
        exit;
    }

    // Check if customer exists
    $checkCustomer = "SELECT CustomerID FROM customers WHERE CustomerID = ?";
    $stmt = mysqli_prepare($conn, $checkCustomer);
    mysqli_stmt_bind_param($stmt, "i", $customerId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) === 0) {
        http_response_code(404);
        echo "Customer not found.";
        exit;
    }
    mysqli_stmt_close($stmt);

    // Insert payment
    $query = "INSERT INTO payments (CustomerID, Amount, PaymentDate) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ids", $customerId, $amount, $date);
    
    if (mysqli_stmt_execute($stmt)) {
        // Get the payment ID
        $paymentId = mysqli_insert_id($conn);
        
        // Return success response
        echo json_encode([
            'success' => true,
            'message' => 'Payment added successfully!',
            'payment_id' => $paymentId
        ]);
    } else {
        http_response_code(500);
        echo "Database error: " . mysqli_error($conn);
    }
    
    mysqli_stmt_close($stmt);
} else {
    http_response_code(405);
    echo "Method not allowed.";
}
?>
