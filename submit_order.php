<?php
include 'connection.php';
session_start();

function processOrder($userID, $customerID, $totalPrice, $paymentMethod, $cartItems, $status, $conn, $isHoldOrder = false) {
    $ordersTable = $isHoldOrder ? 'hold_orders' : 'orders';
    $orderItemsTable = $isHoldOrder ? 'hold_order_item' : 'order_items';

    // Insert order into the orders table (removed LPO and Address)
    $query = "INSERT INTO $ordersTable (UserID, TotalPrice, CustomerID, Status, PaymentMode) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("idiss", $userID, $totalPrice, $customerID, $status, $paymentMethod);

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

                        // Fetch product price - using prod_price instead of EditedPrice/SellingPrice
                        $priceQuery = "SELECT prod_price AS Price FROM products WHERE ID = ?";
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

                        // Deduct quantity from products table (only for completed orders, not hold orders)
                        if (!$isHoldOrder) {
                            $updateProductQuery = "UPDATE products SET Quantity = Quantity - ? WHERE ID = ? AND Quantity >= ?";
                            $updateProductStmt = $conn->prepare($updateProductQuery);
                            if ($updateProductStmt) {
                                $updateProductStmt->bind_param("iii", $quantity, $productID, $quantity);
                                if (!$updateProductStmt->execute()) {
                                    error_log("Error updating product quantity: " . $updateProductStmt->error);
                                } else {
                                    // Check if quantity update was successful
                                    if ($updateProductStmt->affected_rows == 0) {
                                        error_log("Warning: Product quantity not updated for ID: $productID (insufficient stock)");
                                    }
                                }
                                $updateProductStmt->close();
                            } else {
                                error_log("Error preparing update product query: " . $conn->error);
                            }
                        }
                    }
                }
                $orderItemsStmt->close();
                
                // Success message
                if ($isHoldOrder) {
                    echo "<script>alert('Order held successfully!');</script>";
                } else {
                    echo "<script>alert('Order processed successfully!');</script>";
                }
            } else {
                error_log("Error preparing order items query: " . $conn->error);
                echo "<script>alert('Error processing order items.');</script>";
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
    // Check if customer is selected
    if (empty($_POST['customerID'])) {
        echo "<script>alert('Store keeper is not selected.'); window.location.href = 'index2.php';</script>";
        exit;
    }
    
    if (isset($_POST['totalPrice'], $_POST['cartItems'])) {
        // Retrieve form data
        $customerID = $_POST['customerID'];
        $totalPrice = (float)$_POST['totalPrice'];
        
        // Set default payment method if not provided
        $paymentMethod = isset($_POST['paymentMode']) ? $_POST['paymentMode'] : 'cash';
        
        $cartItems = json_decode($_POST['cartItems'], true);
        
        // Check if cart items are valid
        if (!$cartItems || empty($cartItems)) {
            echo "<script>alert('Cart is empty. Please add items to cart.'); window.location.href = 'index2.php';</script>";
            exit;
        }
        
        $userID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        
        if (!$userID) {
            echo "<script>alert('User not logged in.'); window.location.href = 'login.php';</script>";
            exit;
        }

        // Check if VAT should be included
        $includeTax = isset($_POST['includeTax']) && $_POST['includeTax'] == '1';

        // Adjust totalPrice based on includeTax
        if ($includeTax) {
            // Tax is already included in totalPrice, no further adjustment needed
            $finalPrice = $totalPrice;
        } else {
            // If tax is not included, calculate VAT excluded price
            $tax = $totalPrice * 0.18;
            $finalPrice = $totalPrice - $tax;
        }

        // Display loading animation
        echo "<style>body {display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #f0f0f0;}</style>
              <script src='https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs' type='module'></script>
              <dotlottie-player src='https://lottie.host/8f6bd224-1379-48d8-a43c-210cb7ac1475/cU4cgfUfDn.json' background='transparent' speed='1' style='width: 300px; height: 300px;' loop autoplay></dotlottie-player>";

        // Process the order
        processOrder($userID, $customerID, $finalPrice, $paymentMethod, $cartItems, 'Pending', $conn);

        // Clear the cart after successful order
        if (isset($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }

        echo "<script>setTimeout(function(){ window.location.href = 'index2.php'; }, 4000);</script>";
    } else {
        echo "<script>alert('Error: Required fields are missing.'); setTimeout(function(){ window.location.href = 'index2.php'; }, 2000);</script>";
    }
}

// Handle the form submission for hold order
if (isset($_POST['hold'])) {
    // Check if customer is selected
    if (empty($_POST['customerID'])) {
        echo "<script>alert('Customer is not selected.'); window.location.href = 'index2.php';</script>";
        exit;
    }
    
    if (isset($_POST['totalPrice'], $_POST['cartItems'])) {
        $customerID = $_POST['customerID'];
        $totalPrice = (float)$_POST['totalPrice'];
        
        // Set default payment method if not provided
        $paymentMethod = isset($_POST['paymentMode']) ? $_POST['paymentMode'] : 'cash';
        
        $cartItems = json_decode($_POST['cartItems'], true);
        
        // Check if cart items are valid
        if (!$cartItems || empty($cartItems)) {
            echo "<script>alert('Cart is empty. Please add items to cart.'); window.location.href = 'index2.php';</script>";
            exit;
        }
        
        $userID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        
        if (!$userID) {
            echo "<script>alert('User not logged in.'); window.location.href = 'login.php';</script>";
            exit;
        }
        
        $includeTax = isset($_POST['includeTax']) && $_POST['includeTax'] == '1';

        // Adjust totalPrice based on includeTax
        if (!$includeTax) {
            $tax = $totalPrice * 0.18;
            $totalPrice += $tax;
        }

        // Display loading animation
        echo "<style>body {display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #f0f0f0;}</style>
              <script src='https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs' type='module'></script>
              <dotlottie-player src='https://lottie.host/8f6bd224-1379-48d8-a43c-210cb7ac1475/cU4cgfUfDn.json' background='transparent' speed='1' style='width: 300px; height: 300px;' loop autoplay></dotlottie-player>";

        // Process the hold order
        processOrder($userID, $customerID, $totalPrice, $paymentMethod, $cartItems, 'Pending', $conn, true);

        // Clear the cart after successful hold order
        if (isset($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }

        echo "<script>setTimeout(function(){ window.location.href = 'pages/proformainvoices.php'; }, 4000);</script>";
    } else {
        echo "<script>alert('Error: Required fields are missing.'); setTimeout(function(){ window.location.href = 'index2.php'; }, 2000);</script>";
    }
}

$conn->close();
?>