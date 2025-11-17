<?php
// Initialize database connection and session
include '../connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to continue.'); window.location.href = '../login.php';</script>";
    exit;
}

// Initialize variables with default values
$orderId = isset($_GET['OrderID']) ? intval($_GET['OrderID']) : 0;
$customerName = '';
$customerId = 0;
$paymentMethod = '';
$lpo = '';
$address = '';
$paymentStatus = 'Unpaid';
$mobileProvider = '';
$products = [];

// Fetch customers for dropdown
$customersQuery = "SELECT CustomerID, CustomerName, LPO, Address FROM customers ORDER BY CustomerName";
$customersResult = mysqli_query($conn, $customersQuery);

if (!$customersResult) {
    echo "<div class='alert alert-danger'>Error fetching customers: " . mysqli_error($conn) . "</div>";
}

// If order ID is provided, fetch order details
if ($orderId > 0) {
    // Fetch order details
    $orderQuery = "SELECT o.*, c.CustomerName, c.CustomerID 
                  FROM orders o 
                  JOIN customers c ON o.CustomerID = c.CustomerID 
                  WHERE o.ID = ?";
    
    $stmt = mysqli_prepare($conn, $orderQuery);
    mysqli_stmt_bind_param($stmt, "i", $orderId);
    mysqli_stmt_execute($stmt);
    $orderResult = mysqli_stmt_get_result($stmt);
    
    if ($orderRow = mysqli_fetch_assoc($orderResult)) {
        $customerName = $orderRow['CustomerName'];
        $customerId = $orderRow['CustomerID'];
        $paymentMethod = $orderRow['PaymentMode'];
        $lpo = $orderRow['LPO'];
        $address = $orderRow['Address'];
        $paymentStatus = $orderRow['PaymentStatus'];
        $mobileProvider = $orderRow['MobileProvider'];
        $totalPrice = $orderRow['TotalPrice'];
        
        // Fetch order items
        $itemsQuery = "SELECT oi.*, p.ProductName 
                      FROM order_items oi 
                      JOIN products p ON oi.ProductID = p.ID 
                      WHERE oi.OrderID = ?";
        
        $stmt = mysqli_prepare($conn, $itemsQuery);
        mysqli_stmt_bind_param($stmt, "i", $orderId);
        mysqli_stmt_execute($stmt);
        $itemsResult = mysqli_stmt_get_result($stmt);
        
        while ($item = mysqli_fetch_assoc($itemsResult)) {
            $products[] = [
                'ProductID' => $item['ProductID'],
                'ProductName' => $item['ProductName'],
                'Quantity' => $item['Quantity'],
                'Price' => $item['Price']
            ];
        }
    } else {
        echo "<div class='alert alert-danger'>Order not found.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>No order ID provided.</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        .invoice-container { max-width: 800px; margin: auto; border: 2px solid black; padding: 20px; box-sizing: border-box; }
        @media print { .invoice-container { width: 100%; margin: 0; page-break-after: always; } button { display: none; } }
        .header { text-align: center; }
        .header img { width: 100px; margin-bottom: 10px; }
        .company-customer-info { display: flex; justify-content: space-between; margin-top: 20px; flex-wrap: wrap; }
        .details-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .details-table th, .details-table td { border: 1px solid black; padding: 8px; text-align: left; }
        .details-table th { background-color: #f2f2f2; font-weight: bold; }
        .button-section { display: flex; justify-content: center; margin-top: 20px; gap: 10px; }
        button { padding: 10px 20px; background-color: #28a745; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; }
        button:hover { background-color: #320f44; }
        .edit-button { background-color: #007bff; }
        .edit-button:hover { background-color: #0056b3; }
        .form-group { margin-bottom: 10px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group select, .form-group input { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .form-row { display: flex; gap: 15px; }
        .form-row .form-group { flex: 1; }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            text-align: center;
        }
        .status-unpaid { background-color: #ffcccc; color: #cc0000; }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-paid { background-color: #d4edda; color: #155724; }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <img src="../assets/img/logo-ct-dark.png" alt="Company Logo">
            <h1>MANNYA COMPANY LIMITED</h1>
            <p>Tabata Old Dampo, Mandera Street, P.O. Box 32055, Dar es Salaam, Tanzania</p>
            <h2>Edit Invoice #<?php echo $orderId; ?></h2>
        </div>
        
        <form id="invoiceForm" method="POST" action="sales_submission.php">
            <input type="hidden" name="originalOrderID" value="<?php echo $orderId; ?>">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="customerID">Customer:</label>
                    <select name="customerID" id="customerID" required onchange="updateCustomerDetails(this)">
                        <option value="">Select Customer</option>
                        <?php
                        if ($customersResult) {
                            mysqli_data_seek($customersResult, 0);
                            while ($customer = mysqli_fetch_assoc($customersResult)) {
                                $selected = ($customer['CustomerID'] == $customerId) ? 'selected' : '';
                                echo "<option value='{$customer['CustomerID']}' data-lpo='{$customer['LPO']}' data-address='{$customer['Address']}' {$selected}>{$customer['CustomerName']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="paymentMode">Payment Method:</label>
                    <select name="paymentMode" id="paymentMode" required>
                        <option value="">Select Payment Method</option>
                        <option value="Cash" <?php echo ($paymentMethod == 'Cash') ? 'selected' : ''; ?>>Cash</option>
                        <option value="Credit Card" <?php echo ($paymentMethod == 'Credit Card') ? 'selected' : ''; ?>>Credit Card</option>
                        <option value="Bank Transfer" <?php echo ($paymentMethod == 'Bank Transfer') ? 'selected' : ''; ?>>Bank Transfer</option>
                        <option value="Mobile Money" <?php echo ($paymentMethod == 'Mobile Money') ? 'selected' : ''; ?>>Mobile Money</option>
                        <option value="Cheque" <?php echo ($paymentMethod == 'Cheque') ? 'selected' : ''; ?>>Cheque</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="lpo">LPO:</label>
                    <input type="text" name="lpo" id="lpo" value="<?php echo htmlspecialchars($lpo); ?>">
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($address); ?>">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="mobileProvider">Mobile Provider (if applicable):</label>
                    <input type="text" name="mobileProvider" id="mobileProvider" value="<?php echo htmlspecialchars($mobileProvider); ?>">
                </div>
                <div class="form-group">
                    <label for="paymentStatus">Payment Status:</label>
                    <select name="paymentStatus" id="paymentStatus">
                        <option value="Unpaid" <?php echo ($paymentStatus == 'Unpaid') ? 'selected' : ''; ?>>Unpaid</option>
                        <option value="Pending" <?php echo ($paymentStatus == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                        <option value="Paid" <?php echo ($paymentStatus == 'Paid') ? 'selected' : ''; ?>>Paid</option>
                    </select>
                </div>
            </div>

            <table class="details-table" id="invoiceTable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="productRows">
                    <?php
                    $counter = 1;
                    $totalAmount = 0;
                    foreach ($products as $product) {
                        $lineTotal = $product['Quantity'] * $product['Price'];
                        $totalAmount += $lineTotal;

                        echo "<tr data-product-id='{$product['ProductID']}'>
                            <td>{$counter}</td>
                            <td><input type='text' name='products[{$counter}][ProductName]' value='" . htmlspecialchars($product['ProductName']) . "' readonly></td>
                            <td><input type='number' name='products[{$counter}][Quantity]' value='{$product['Quantity']}' min='1' oninput='updateCalculations()' required></td>
                            <td><input type='number' name='products[{$counter}][Price]' value='{$product['Price']}' min='0.01' step='0.01' oninput='updateCalculations()' required></td>
                            <td class='total-price'>" . number_format($lineTotal, 2) . "</td>
                            <td><button type='button' onclick='removeProduct(this)'>Remove</button></td>
                            <input type='hidden' name='products[{$counter}][ProductID]' value='{$product['ProductID']}'>
                        </tr>";
                        $counter++;
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:right; font-weight:bold;">Total:</td>
                        <td id="totalAmount"><?php echo number_format($totalAmount, 2); ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <input type="hidden" name="totalPrice" id="hiddenTotalPrice" value="<?php echo $totalAmount; ?>">
            <input type="hidden" name="cartItems" id="hiddenCartItems" value="">

            <div class="button-section">
                <button type="button" onclick="addProduct()">Add Product</button>
                <button type="submit" name="submit_edited_invoice">Submit as New Order</button>
                <button type="button" onclick="window.history.back()">Cancel</button>
            </div>
        </form>
    </div>

    <script>
        // Initialize cart items on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCalculations();
            updateCartItems();
        });

        function updateCustomerDetails(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            document.getElementById('lpo').value = selectedOption.getAttribute('data-lpo') || '';
            document.getElementById('address').value = selectedOption.getAttribute('data-address') || '';
        }

        function addProduct() {
            // In a real implementation, you would open a product selection modal
            // For now, we'll just add a blank row
            let table = document.getElementById("productRows");
            let rowCount = table.rows.length + 1;
            let row = table.insertRow();
            row.innerHTML = ` 
                <td>${rowCount}</td>
                <td><input type='text' name='products[${rowCount}][ProductName]' required></td>
                <td><input type='number' name='products[${rowCount}][Quantity]' min='1' value='1' oninput='updateCalculations()' required></td>
                <td><input type='number' name='products[${rowCount}][Price]' min='0.01' step='0.01' value='0.00' oninput='updateCalculations()' required></td>
                <td class='total-price'>0.00</td>
                <td><button type='button' onclick='removeProduct(this)'>Remove</button></td>
                <input type='hidden' name='products[${rowCount}][ProductID]' value='0'>
            `;
            updateCalculations();
        }

        function updateCalculations() {
            let rows = document.querySelectorAll("#productRows tr");
            let totalAmount = 0;

            rows.forEach(row => {
                let quantity = parseFloat(row.querySelector("input[name*='[Quantity]']").value) || 0;
                let price = parseFloat(row.querySelector("input[name*='[Price]']").value) || 0;
                let totalPrice = quantity * price;

                row.querySelector(".total-price").textContent = totalPrice.toFixed(2);
                totalAmount += totalPrice;
            });

            document.getElementById("totalAmount").textContent = totalAmount.toFixed(2);
            document.getElementById("hiddenTotalPrice").value = totalAmount.toFixed(2);
            
            updateCartItems();
        }

        function updateCartItems() {
            let rows = document.querySelectorAll("#productRows tr");
            let cartItems = [];

            rows.forEach(row => {
                let productId = row.querySelector("input[name*='[ProductID]']").value;
                let quantity = parseFloat(row.querySelector("input[name*='[Quantity]']").value) || 0;
                let price = parseFloat(row.querySelector("input[name*='[Price]']").value) || 0;
                let productName = row.querySelector("input[name*='[ProductName]']").value;

                cartItems.push({
                    ID: productId,
                    ProductName: productName,
                    Quantity: quantity,
                    Price: price
                });
            });

            document.getElementById("hiddenCartItems").value = JSON.stringify(cartItems);
        }

        function removeProduct(button) {
            let row = button.closest("tr");
            row.remove();
            updateCalculations();
            
            // Renumber the rows
            let rows = document.querySelectorAll("#productRows tr");
            rows.forEach((row, index) => {
                row.cells[0].textContent = index + 1;
            });
        }

        // Validate form before submission
        document.getElementById("invoiceForm").addEventListener("submit", function(e) {
            let rows = document.querySelectorAll("#productRows tr");
            if (rows.length === 0) {
                e.preventDefault();
                alert("Please add at least one product to the invoice.");
                return false;
            }

            let customerID = document.getElementById("customerID").value;
            if (!customerID) {
                e.preventDefault();
                alert("Please select a customer.");
                return false;
            }

            let paymentMode = document.getElementById("paymentMode").value;
            if (!paymentMode) {
                e.preventDefault();
                alert("Please select a payment method.");
                return false;
            }

            updateCartItems(); // Ensure cart items are updated before submission
            return true;
        });
    </script>
</body>
</html>
