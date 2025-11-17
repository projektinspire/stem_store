<?php 
include '../connection.php';
session_start();

function processOrder($userID, $customerID, $totalPrice, $paymentMethod, $cartItems, $status, $conn, $isHoldOrder = false) {
    $ordersTable = $isHoldOrder ? 'hold_orders' : 'orders';
    $orderItemsTable = $isHoldOrder ? 'hold_order_item' : 'order_items';

    // Fetch LPO and Address from customers table
    $customerQuery = "SELECT LPO, Address FROM customers WHERE CustomerID = ?";
    $customerStmt = $conn->prepare($customerQuery);
    $lpo = null;
    $address = null;

    if ($customerStmt) {
        $customerStmt->bind_param("i", $customerID);

        if ($customerStmt->execute()) {
            $customerResult = $customerStmt->get_result();
            if ($customerResult->num_rows > 0) {
                $customer = $customerResult->fetch_assoc();
                $lpo = $customer['LPO'];
                $address = $customer['Address'];
            } else {
                echo "<script>alert('Customer not found.');</script>";
                error_log("Customer not found for ID: $customerID");
                return;
            }
        } else {
            error_log("Error executing customer query: " . $customerStmt->error);
            echo "<script>alert('Error fetching customer details.');</script>";
            return;
        }
        $customerStmt->close();
    } else {
        error_log("Error preparing customer query: " . $conn->error);
        echo "<script>alert('Error preparing customer query.');</script>";
        return;
    }

    // Insert order into the orders table
    $query = "INSERT INTO $ordersTable (UserID, TotalPrice, CustomerID, LPO, Address, Status, PaymentMode) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("idissss", $userID, $totalPrice, $customerID, $lpo, $address, $status, $paymentMethod);

        if ($stmt->execute()) {
            $orderID = $conn->insert_id;

            // Insert each cart item into the order items table
            $orderItemsQuery = "INSERT INTO $orderItemsTable (OrderID, ProductID, Quantity, Price, AddedDate) VALUES (?, ?, ?, ?, NOW())";
            $orderItemsStmt = $conn->prepare($orderItemsQuery);

            if ($orderItemsStmt) {
                foreach ($cartItems as $item) {
                    if (isset($item['ID'], $item['Quantity'])) {
                        $productID = $item['ID'];
                        $quantity = $item['Quantity'];

                        // Fetch product price
                        $priceQuery = "SELECT IFNULL(EditedPrice, SellingPrice) AS Price FROM products WHERE ID = ?";
                        $priceStmt = $conn->prepare($priceQuery);
                        if ($priceStmt) {
                            $priceStmt->bind_param("i", $productID);
                            $priceStmt->execute();
                            $priceResult = $priceStmt->get_result();
                            if ($priceResult->num_rows > 0) {
                                $priceRow = $priceResult->fetch_assoc();
                                $price = $priceRow['Price'];
                            } else {
                                error_log("Price not found for product ID: $productID");
                                continue;
                            }
                            $priceStmt->close();
                        } else {
                            error_log("Error preparing price query: " . $conn->error);
                            continue;
                        }

                        $orderItemsStmt->bind_param("iiid", $orderID, $productID, $quantity, $price);
                        if (!$orderItemsStmt->execute()) {
                            error_log("Error inserting order item: " . $orderItemsStmt->error);
                        }

                        // Deduct quantity from products table
                        if (!$isHoldOrder) {
                            $updateProductQuery = "UPDATE products SET Quantity = Quantity - ? WHERE ID = ? AND Quantity >= ?";
                            $updateProductStmt = $conn->prepare($updateProductQuery);
                            if ($updateProductStmt) {
                                $updateProductStmt->bind_param("iii", $quantity, $productID, $quantity);
                                if (!$updateProductStmt->execute()) {
                                    error_log("Error updating product quantity: " . $updateProductStmt->error);
                                }
                                $updateProductStmt->close();
                            } else {
                                error_log("Error preparing update product query: " . $conn->error);
                            }
                        }
                    }
                }
                $orderItemsStmt->close();
            } else {
                error_log("Error preparing order items query: " . $conn->error);
            }
        } else {
            error_log("Error inserting order: " . $stmt->error);
            echo "<script>alert('Error processing the order.');</script>";
        }
        $stmt->close();
    } else {
        error_log("Error preparing order statement: " . $conn->error);
        echo "<script>alert('Error preparing order statement.');</script>";
    }
}


// Handle the form submission for order submission
if (isset($_POST['submit'])) {
    if (empty($_POST['customerID'])) {
        echo "<script>alert('Customer is not selected.'); window.location.href = 'dashboard.php';</script>";
    } else if (isset($_POST['totalPrice'], $_POST['cartItems'])) {
        $customerID = $_POST['customerID'];
        $totalPrice = $_POST['totalPrice'];
        $paymentMethod = $_POST['paymentMode'];
        $cartItems = json_decode($_POST['cartItems'], true);
        $userID = $_SESSION['user_id'];

        // Display loading animation
        echo "<style>body {display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #f0f0f0;}</style>
              <script src='https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs' type='module'></script>
              <dotlottie-player src='https://lottie.host/8f6bd224-1379-48d8-a43c-210cb7ac1475/cU4cgfUfDn.json' background='transparent' speed='1' style='width: 300px; height: 300px;' loop autoplay></dotlottie-player>";

        // Check if user is logged in
        if ($userID) {
            // Process the order with status 'Pending'
            processOrder($userID, $customerID, $totalPrice, $paymentMethod, $cartItems, 'Pending', $conn);
        } else {
            echo "<script>alert('User not logged in.');</script>";
        }

        // Redirect after 4 seconds
        echo "<script>setTimeout(function(){ window.location.href = 'sales.php'; }, 4000);</script>";
    } else {
        echo "<script>alert('Error: Required fields are missing.'); setTimeout(function(){ window.location.href = 'sales.php'; }, 4000);</script>";
    }
}

// Handle the form submission for hold order
if (isset($_POST['hold'])) {
    if (empty($_POST['customerID'])) {
        echo "<script>alert('Customer is not selected.'); window.location.href = 'dashboard.php';</script>";
    } else if (isset($_POST['totalPrice'], $_POST['cartItems'])) {
        $customerID = $_POST['customerID'];
        $totalPrice = $_POST['totalPrice'];
        $paymentMethod = $_POST['paymentMode'];
        $cartItems = json_decode($_POST['cartItems'], true);
        $userID = $_SESSION['user_id'];

        // Display loading animation
        echo "<style>body {display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #f0f0f0;}</style>
              <script src='https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs' type='module'></script>
              <dotlottie-player src='https://lottie.host/8f6bd224-1379-48d8-a43c-210cb7ac1475/cU4cgfUfDn.json' background='transparent' speed='1' style='width: 300px; height: 300px;' loop autoplay></dotlottie-player>";

        // Check if user is logged in
        if ($userID) {
            // Process the hold order with status 'Pending'
            processOrder($userID, $customerID, $totalPrice, $paymentMethod, $cartItems, 'Pending', $conn, true);
        } else {
            echo "<script>alert('User not logged in.');</script>";
        }

        // Redirect after 4 seconds
        echo "<script>setTimeout(function(){ window.location.href = 'proformainvoices.php'; }, 4000);</script>";
    } else {
        echo "<script>alert('Error: Required fields are missing.'); setTimeout(function(){ window.location.href = 'proformainvoices.php'; }, 4000);</script>";
    }
}

// Handling the approval or rejection of an order
if (isset($_POST['approve_order']) || isset($_POST['reject_order'])) {
    $orderID = $_POST['orderID'];

    // Check if approve or reject button is clicked
    $status = isset($_POST['approve_order']) ? 'Approved' : 'Rejected';

    // Update the order status
    $updateStatusQuery = "UPDATE orders SET Status = ? WHERE OrderID = ?";
    $stmt = $conn->prepare($updateStatusQuery);

    if ($stmt) {
        $stmt->bind_param("si", $status, $orderID);
        if ($stmt->execute()) {
            echo "<script>alert('Order status updated successfully to $status'); window.location.href = 'orders.php';</script>";
        } else {
            echo "<script>alert('Error updating order status: " . $stmt->error . "'); window.location.href = 'orders.php';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing update statement: " . $conn->error . "'); window.location.href = 'orders.php';</script>";
    }
}

$conn->close();

?>
