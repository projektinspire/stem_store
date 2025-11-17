<?php
session_start();
include '../connection.php'; // Changed from '../config/db_connection.php' to match your project structure

// Function to process the order
function processOrder($userID, $customerID, $totalPrice, $paymentMethod, $cartItems, $status, $conn) {
    // Check if connection is valid
    if (!$conn) {
        echo "<script>alert('Database connection error. Please try again later.'); window.history.back();</script>";
        exit;
    }

    // Get additional data from the form
    $lpo = isset($_POST['lpo']) ? $_POST['lpo'] : null;
    $address = isset($_POST['address']) ? $_POST['address'] : null;
    $mobileProvider = isset($_POST['mobileProvider']) ? $_POST['mobileProvider'] : null;
    $paymentStatus = isset($_POST['paymentStatus']) ? $_POST['paymentStatus'] : 'Unpaid';

    // Insert into orders table
    $orderQuery = "INSERT INTO orders (UserID, CustomerID, LPO, Address, Status, TotalPrice, PaymentMode, MobileProvider, PaymentStatus) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $orderStmt = mysqli_prepare($conn, $orderQuery);
    
    if (!$orderStmt) {
        echo "<script>alert('Error preparing order statement: " . mysqli_error($conn) . "'); window.history.back();</script>";
        exit;
    }
    
    mysqli_stmt_bind_param($orderStmt, "iisssdsss", 
        $userID, 
        $customerID, 
        $lpo, 
        $address, 
        $status, 
        $totalPrice, 
        $paymentMethod, 
        $mobileProvider, 
        $paymentStatus
    );
    
    if (!mysqli_stmt_execute($orderStmt)) {
        echo "<script>alert('Error executing order statement: " . mysqli_stmt_error($orderStmt) . "'); window.history.back();</script>";
        mysqli_stmt_close($orderStmt);
        exit;
    }
    
    $orderID = mysqli_insert_id($conn);
    mysqli_stmt_close($orderStmt);
    
    // Process each item in the cart
    foreach ($cartItems as $item) {
        // Extract item data
        $productID = isset($item['ID']) ? $item['ID'] : 0;
        $quantity = isset($item['Quantity']) ? $item['Quantity'] : 0;
        $price = isset($item['Price']) ? $item['Price'] : 0;
        
        if ($productID && $quantity && $price) {
            // Insert into order_items table
            $itemQuery = "INSERT INTO order_items (OrderID, ProductID, Quantity, Price) 
                          VALUES (?, ?, ?, ?)";
            
            $itemStmt = mysqli_prepare($conn, $itemQuery);
            
            if (!$itemStmt) {
                echo "<script>alert('Error preparing item statement: " . mysqli_error($conn) . "'); window.history.back();</script>";
                continue;
            }
            
            mysqli_stmt_bind_param($itemStmt, "iiid", $orderID, $productID, $quantity, $price);
            
            if (!mysqli_stmt_execute($itemStmt)) {
                echo "<script>alert('Error executing item statement: " . mysqli_stmt_error($itemStmt) . "'); window.history.back();</script>";
            }
            
            mysqli_stmt_close($itemStmt);
            
            // Update product quantity
            $updateQuery = "UPDATE products SET Quantity = Quantity - ? WHERE ID = ? AND Quantity >= ?";
            $updateStmt = mysqli_prepare($conn, $updateQuery);
            
            if ($updateStmt) {
                mysqli_stmt_bind_param($updateStmt, "iii", $quantity, $productID, $quantity);
                mysqli_stmt_execute($updateStmt);
                mysqli_stmt_close($updateStmt);
            }
        }
    }
    
    return $orderID;
}

// Handle the form submission for edited invoices
if (isset($_POST['submit_edited_invoice']) || isset($_POST['originalOrderID'])) {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('Please log in to continue.'); window.location.href = '../login.php';</script>";
        exit;
    }
    
    // Check if customer is selected
    if (empty($_POST['customerID'])) {
        echo "<script>alert('Customer is not selected.'); window.history.back();</script>";
        exit;
    }
    
    // Check if required fields are present
    if (!isset($_POST['totalPrice']) || !isset($_POST['cartItems'])) {
        echo "<script>alert('Error: Required fields are missing.'); window.history.back();</script>";
        exit;
    }
    
    // Get form data
    $customerID = $_POST['customerID'];
    $totalPrice = (float)$_POST['totalPrice'];
    $paymentMethod = $_POST['paymentMode'];
    $cartItems = json_decode($_POST['cartItems'], true);
    $userID = $_SESSION['user_id'];
    $originalOrderID = $_POST['originalOrderID'];
    
    // Display loading animation
    echo "<style>body {display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #f0f0f0;}</style>
          <div id='loading'>
              <h2>Processing your request...</h2>
              <div class='spinner'></div>
          </div>
          <style>
              .spinner {
                  border: 16px solid #f3f3f3;
                  border-top: 16px solid #3498db;
                  border-radius: 50%;
                  width: 80px;
                  height: 80px;
                  animation: spin 2s linear infinite;
                  margin: 20px auto;
              }
              @keyframes spin {
                  0% { transform: rotate(0deg); }
                  100% { transform: rotate(360deg); }
              }
          </style>";
    
    // Process the edited invoice as a new order
    $newOrderID = processOrder($userID, $customerID, $totalPrice, $paymentMethod, $cartItems, 'Pending', $conn);
    
    if ($newOrderID) {
        // Update the original order status to indicate it was edited
        $updateQuery = "UPDATE orders SET Status = 'Edited', UpdatedDate = NOW() WHERE ID = ?";
        $updateStmt = mysqli_prepare($conn, $updateQuery);
        
        if ($updateStmt) {
            mysqli_stmt_bind_param($updateStmt, "i", $originalOrderID);
            mysqli_stmt_execute($updateStmt);
            mysqli_stmt_close($updateStmt);
            
            echo "<script>
                setTimeout(function() {
                    alert('Invoice successfully edited and saved as a new order #" . $newOrderID . "');
                    window.location.href = '../pages/sales.php';
                }, 1500);
            </script>";
        } else {
            echo "<script>
                setTimeout(function() {
                    alert('Invoice saved as a new order, but failed to update original order status.');
                    window.location.href = '../pages/sales.php';
                }, 1500);
            </script>";
        }
    } else {
        echo "<script>
            setTimeout(function() {
                alert('Error creating new order from edited invoice.');
                window.history.back();
            }, 1500);
        </script>";
    }
}

// Handle the form submission for regular orders
if (isset($_POST['submit'])) {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('Please log in to continue.'); window.location.href = '../login.php';</script>";
        exit;
    }
    
    // Check if customer is selected
    if (empty($_POST['customerID'])) {
        echo "<script>alert('Customer is not selected.'); window.history.back();</script>";
        exit;
    }
    
    // Check if required fields are present
    if (!isset($_POST['totalPrice']) || !isset($_POST['cartItems'])) {
        echo "<script>alert('Error: Required fields are missing.'); window.history.back();</script>";
        exit;
    }
    
    // Get form data
    $customerID = $_POST['customerID'];
    $totalPrice = (float)$_POST['totalPrice'];
    $paymentMethod = $_POST['paymentMode'];
    $cartItems = json_decode($_POST['cartItems'], true);
    $userID = $_SESSION['user_id'];
    
    // Display loading animation
    echo "<style>body {display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #f0f0f0;}</style>
          <div id='loading'>
              <h2>Processing your order...</h2>
              <div class='spinner'></div>
          </div>
          <style>
              .spinner {
                  border: 16px solid #f3f3f3;
                  border-top: 16px solid #3498db;
                  border-radius: 50%;
                  width: 80px;
                  height: 80px;
                  animation: spin 2s linear infinite;
                  margin: 20px auto;
              }
              @keyframes spin {
                  0% { transform: rotate(0deg); }
                  100% { transform: rotate(360deg); }
              }
          </style>";
    
    // Process the order
    $orderID = processOrder($userID, $customerID, $totalPrice, $paymentMethod, $cartItems, 'Pending', $conn);
    
    if ($orderID) {
        echo "<script>
            setTimeout(function() {
                alert('Order #" . $orderID . " created successfully!');
                window.location.href = '../pages/sales.php';
            }, 1500);
        </script>";
    } else {
        echo "<script>
            setTimeout(function() {
                alert('Error creating order.');
                window.history.back();
            }, 1500);
        </script>";
    }
}

// Handle the form submission for hold orders
if (isset($_POST['hold'])) {
    // Similar implementation as above, but for hold orders
    // This would be implemented if needed
}
?>
