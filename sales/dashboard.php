<?php 

include '../connection.php';  // Include your existing connection file

session_start();

// Check if the user is logged in; if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit(); // Ensure the script stops executing after the redirect
}

// Get the logged-in user ID
$userId = $_SESSION['user_id'];

// Initialize variables
$cartItems = [];
$cartSubtotal = 0;
$uniqueItemCount = 0; // Track number of unique items
$tax = 0;
$payableAmount = 0;

// Fetch grouped cart items (group by product to sum the quantity)
// Use EditedPrice instead of SellingPrice
$query = "SELECT p.ID, p.ProductName, p.Image, p.EditedPrice, SUM(c.Quantity) as Quantity 
          FROM cart c 
          INNER JOIN products p ON c.ProductID = p.ID 
          WHERE c.UserID = ? 
          GROUP BY p.ID";
$stmt = $conn->prepare($query);  // Use $conn from connection.php
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Store cart items and calculate totals
while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
    
    // Calculate using EditedPrice instead of SellingPrice
    $cartSubtotal += $row['EditedPrice'] * $row['Quantity'];
    $uniqueItemCount++; // Increment for each unique product
}

$tax = $cartSubtotal * (18 / 118);  // 18% Tax
$payableAmount = $cartSubtotal;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
  POS
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <style>
  /* Cart Dropdown Styling */
.cart-dropdown-menu {
  width: 320px;
  max-height: 400px; /* Limit the height */
  overflow-y: auto; /* Enable scrolling */
  border-radius: 10px;
  background-color: #f9f9f9;
  box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
}

/* Cart Header Styling */
.cart-header {
  padding: 10px 15px;
  background-color: #fff;
  border-bottom: 1px solid #eee;
}

/* Cart Icon Styling */
.cart-icons i {
  margin-left: 10px;
  font-size: 18px;
  cursor: pointer;
}

/* Cart Items */
.cart-items .list-group-item {
  padding: 10px 15px;
  background-color: #fff;
  border: 1px solid #eee;
  border-radius: 5px;
  margin-bottom: 5px;
}

/* Cart Totals */
.cart-totals p {
  font-size: 14px;
  margin: 0;
}

/* Cart Actions */
.cart-actions button {
  font-size: 12px;
  padding: 5px 10px;
}

/* Mobile Friendly */
@media (max-width: 576px) {
  .cart-dropdown-menu {
    width: 100%; /* Make it full width on mobile */
    max-height: 300px; /* Reduce height on mobile */
  }

  .cart-header, .cart-items .list-group-item, .cart-summary-section, .cart-totals, .cart-actions {
    padding: 5px 10px;
  }
}

  </style>
  <style>
  /* Ensure the container behaves properly */
  .nav-item {
    position: relative;
  }

  /* Styling for the cart icon and badge */
  .cart-icon {
    font-size: 28px; /* Adjust icon size */
    position: relative;
  }

  .cart-badge {
    position: absolute;
    top: -10px;
    right: -10px;
    background-color: #de3742; /* Light blue as in your design */
    color: white;
    border-radius: 50%;
    font-size: 12px;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
  }

  .cart-label {
    margin-top: 5px;
    text-align: center;
    font-size: 16px;
    color: white;
  }

  /* Ensure dropdown content is styled and doesn't overlap */
  .dropdown-menu {
    width: 300px;
    max-height: 400px;
    overflow-y: auto;
  }
</style>
</head>
<body class="g-sidenav-show   bg-gray-100">

  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="dashboard.html" target="_blank">
        <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">POS</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
<div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link active" href="">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-tachometer-alt text-primary text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="sales.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-hand-holding-usd text-warning text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Sales</span>
      </a>
    </li>
   <li class="nav-item">
      <a class="nav-link" href="proformainvoices.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-file-invoice-dollar text-success text-sm opacity-10"></i>
        </div>
       <span class="nav-link-text ms-1">Proforma Invoices</span>
      </a>
    </li>
    <li class="nav-item">
  <a class="nav-link" href="invoices.php">
    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
      <i class="fas fa-file-invoice text-primary text-sm opacity-10"></i>
    </div>
    <span class="nav-link-text ms-1">Invoices</span>
  </a>
</li>
<li class="nav-item">
  <a class="nav-link" href="customer_report.php">
    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
      <i class="fas fa-users text-primary text-sm opacity-10"></i>
    </div>
    <span class="nav-link-text ms-1">Customer Report</span>
  </a>
</li>
    <li class="nav-item">
      <a class="nav-link" href="profile.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-user text-dark text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Profile</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="../pages/login.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-user-plus text-info text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Log Out</span>
      </a>
    </li>
  </ul>
</div>
  </aside>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Dashboard</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Dashboard</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
          </div>

            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0">
              </a>
            </li>
            <?php
// Include the database connection file
include '../connection.php'; // Ensure this file path is correct and accessible

// Initialize the search keyword for products
$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';

// Define the $isTaxIncluded variable with a default value
$isTaxIncluded = false; // Set this to 'true' if you want tax to be included by default

// SQL query to select products, including both SellingPrice and EditedPrice
$sql = "SELECT ID, ProductName, Image, PurchasePrice, TotalCost, SellingPrice, EditedPrice, 
        Quantity, Description, AddedDate 
        FROM products 
        WHERE ProductName LIKE ? 
        ORDER BY AddedDate DESC";

// Prepare and execute the query
$stmt = $conn->prepare($sql);
$searchParam = "%$searchKeyword%";
$stmt->bind_param('s', $searchParam);
$stmt->execute();
$result = $stmt->get_result();

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    $products = null; // No products found
}

$stmt->close(); // Close the statement

// Fetch customers from the database
$customers = [];
$query = "SELECT CustomerID, CustomerName, VRN FROM customers";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }
}

// Close the database connection
$conn->close();
?>
<li class="nav-item d-flex align-items-center">
<a href="#" class="nav-link p-0" id="cartButton" onclick="toggleCartVisibility(true); return false;">
        <button class="btn" style="background-color: black; color: white;">
            <i class="fa fa-plus"></i> Place Order
        </button>
    </a>

<!-- Dropdown menu positioned in the center of the page -->
<ul class="dropdown-menu cart-dropdown-menu" id="cartDropdown" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 450px; max-width: 90vw; height: auto; max-height: 80vh; overflow-y: auto; padding: 20px;">
    <li class="cart-summary mb-2">
        <!-- Customer Section -->
        <div id="customerSection" class="mt-3">
    <!-- <button class="btn btn-primary mb-2" onclick="toggleCustomerForm()">+ Add Customer</button> -->
    
    <!-- Customer Selection Dropdown -->
<div id="customerSelection">
    <label for="customerDropdown" class="fw-bold">Select Customer:</label>
    <select name="customerID" id="customerDropdown" class="form-select" required onchange="showOptionalFields()">
        <option value="">Select Customer</option>
        <?php foreach ($customers as $customer): ?>
            <option value="<?php echo htmlspecialchars($customer['CustomerID']); ?>">
                <?php echo htmlspecialchars($customer['CustomerName']); ?> (<?php echo htmlspecialchars($customer['VRN']); ?>)
            </option>
        <?php endforeach; ?>
    </select>
</div>

<!-- LPO and Address Input Fields -->
<div id="optionalFields" style="display:none;" class="mt-2">
    <label for="lpoInput" class="fw-bold">Enter LPO for Selected Customer (Optional):</label>
    <input type="number" name="LPO" id="lpoInput" placeholder="Enter LPO" class="form-control mb-2">

    <label for="addressInput" class="fw-bold">Enter Address for Selected Customer (Optional):</label>
    <input type="text" name="Address" id="addressInput" placeholder="Enter Address" class="form-control mb-2">

    <button type="button" class="btn btn-primary" onclick="saveLpoAndAddress()">Save LPO and Address</button>
</div>

<!-- Add Customer Form -->
<form action="add_customer.php" method="post" id="addCustomerForm" style="display:none;" class="mt-2">
    <input type="text" name="customerName" placeholder="Customer Name" required class="form-control mb-2">
    <input type="text" name="TINNumber" placeholder="TIN Number" required class="form-control mb-2">
    <input type="text" name="VRN" placeholder="VRN" required class="form-control mb-2">
    <input type="text" name="LPO" placeholder="LPO (Optional)" class="form-control mb-2">
    <div class="text-center">
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-secondary" onclick="toggleCustomerForm()">Cancel</button>
    </div>
</form>

<!-- JavaScript Functions -->
<script>
// Toggle the visibility of the add customer form
function toggleCustomerForm() {
    const form = document.getElementById('addCustomerForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

// Show LPO and Address input fields when a customer is selected
function showOptionalFields() {
    const customerDropdown = document.getElementById('customerDropdown');
    const optionalFields = document.getElementById('optionalFields');

    if (customerDropdown.value !== "") {
        optionalFields.style.display = 'block';
    } else {
        optionalFields.style.display = 'none';
        document.getElementById('lpoInput').value = '';
        document.getElementById('addressInput').value = '';
    }
}

// Save LPO and Address using AJAX
function saveLpoAndAddress() {
    const customerDropdown = document.getElementById('customerDropdown');
    const customerID = customerDropdown.value;
    const lpo = document.getElementById('lpoInput').value;
    const address = document.getElementById('addressInput').value;

    if (customerID === "") {
        alert("Please select a customer.");
        return;
    }

    // AJAX request to save LPO and Address
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../save_lpo.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert(xhr.responseText);
            // Reset the form fields, but retain customer selection
            document.getElementById('lpoInput').value = "";
            document.getElementById('addressInput').value = "";
            optionalFields.style.display = 'none'; // Hide optional fields after save
        }
    };
    xhr.send("customerID=" + encodeURIComponent(customerID) + "&LPO=" + encodeURIComponent(lpo) + "&Address=" + encodeURIComponent(address));
}
</script>

</div>
<div id="addToCartSection" class="mt-3">
    <button class="btn btn-success" style="background-color: #16A645; border: none;" onclick="toggleCartVisibility(false); openProductSelectionModal()">+ Add Products</button>
</div>


<!-- Cart Items -->
<ul class="cart-items list-group mb-3">
    <?php if ($uniqueItemCount > 0): ?>
        <?php foreach ($cartItems as $item): ?>
            <li class="list-group-item d-flex justify-content-between align-items-start cart-item">
                <div class="cart-item-details d-flex">
                    <img src="../pages/<?php echo $item['Image']; ?>" class="img-fluid rounded" style="width: 50px; height: 50px;">
                    <div style="margin-left: 10px;">
                        <p class="mb-0 fw-bold"><?php echo htmlspecialchars($item['ProductName']); ?></p>
                        <p class="text-muted d-flex align-items-center">
                            <span>Qty:</span>
                            <input 
                                type="number" 
                                value="<?php echo $item['Quantity']; ?>" 
                                min="1" 
                                class="form-control quantity-input" 
                                style="display: inline-block; width: 60px; margin-left: 5px;" 
                                data-id="<?php echo $item['ID']; ?>" 
                                readonly
                            > 
                            <span style="margin-left: 10px;">x Tsh</span>
                            <input 
                                type="text" 
                                value="<?php echo number_format($item['EditedPrice'], 2, '.', ''); ?>"
                                min="0" 
                                class="form-control price-input" 
                                style="display: inline-block; width: 80px; margin-left: 5px;" 
                                data-id="<?php echo $item['ID']; ?>" 
                                readonly
                            >
                        </p>
                    </div>
                </div>
                <form action="delete_cart_item.php" method="post" class="d-inline">
                    <input type="hidden" name="productId" value="<?php echo $item['ID']; ?>">
                    <button type="submit" class="delete btn p-0 text-danger">
                        <i class="fa fa-times"></i>
                    </button>
                </form>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li class="list-group-item text-center">No items in cart.</li>
    <?php endif; ?>
</ul>

<!-- Cart Totals -->
<div class="d-flex justify-content-between">
    <p>Subtotal:</p>
    <p id="subtotalAmount">Tsh <?php echo rtrim(rtrim(sprintf('%.15f', $cartSubtotal), '0'), '.'); ?></p>
</div>

<!-- Tax Exclusion Checkbox -->
<div class="d-flex justify-content-between">
    <label for="excludeTax">Exclude VAT (18%):</label>
    <input type="checkbox" id="excludeTax" name="excludeTax" onclick="updateCartSummary()">
</div>

<!-- VAT Amount Section -->
<div class="d-flex justify-content-between" id="vatAmountSection">
    <p>VAT (18%):</p>
    <p id="vatAmount">Tsh 0.00</p>
</div>

<!-- Total Amount Section -->
<div class="d-flex justify-content-between fw-bold">
    <p>Total:</p>
    <p id="totalAmount">Tsh <?php echo rtrim(rtrim(sprintf('%.15f', $payableAmount), '0'), '.'); ?></p>
</div>

<!-- JavaScript Code -->
 <script>
document.addEventListener('DOMContentLoaded', function() {
    /**
     * Function to update cart summary with VAT inclusion or exclusion
     */
    function updateCartSummary() {
        let subtotal = 0;
        const cartItems = document.querySelectorAll('.cart-item');
        const excludeTax = document.getElementById('excludeTax').checked;

        // Calculate the subtotal
        cartItems.forEach(item => {
            const id = item.querySelector('.price-input').dataset.id;
            const quantityInput = item.querySelector(`.quantity-input[data-id="${id}"]`);
            const priceInput = item.querySelector(`.price-input[data-id="${id}"]`);

            const quantity = parseFloat(quantityInput.value) || 1;
            const price = parseFloat(priceInput.value) || 0;

            subtotal += price * quantity;
        });

        // Calculate VAT using formula VAT = Subtotal * (18 / 118)
        const vatAmount = subtotal * (18 / 118);
        document.getElementById('vatAmount').innerText = `Tsh ${vatAmount.toFixed(2).replace(/\.?0+$/, '')}`;

        // Calculate total
        const totalAmount = excludeTax ? subtotal - vatAmount : subtotal;
        document.getElementById('totalAmount').innerText = `Tsh ${totalAmount.toFixed(2).replace(/\.?0+$/, '')}`;
    }

    // Attach event listener to the checkbox and update on page load
    document.getElementById('excludeTax').addEventListener('change', updateCartSummary);
    updateCartSummary();
});
</script>



        <div class="d-flex justify-content-between mb-3">
    <form action="clear_cart.php" method="POST" class="d-inline">
        <button type="submit" class="btn btn-danger btn-sm" style="background-color: #C94F60; border: none; color: white;">Clear Cart</button>
    </form>
</div>

        <!-- Order Form -->
        <form action="submit_order.php" method="post" id="orderForm">
    <!-- Payment Mode Section -->
    <div class="mt-3">
        <label for="paymentMode" class="fw-bold">Payment Mode:</label>
        <select name="paymentMode" id="paymentMode" required>
            <option value="cash">Cash</option>
            <option value="credit">Credit</option>
        </select>
    </div>

    <!-- Hidden Inputs for Cart Data and Order Submission -->
    <input type="hidden" name="cartItems" value="<?php echo htmlspecialchars(json_encode($cartItems)); ?>">
    <input type="hidden" name="totalPrice" id="totalPrice" value="<?php echo htmlspecialchars($payableAmount); ?>">
    <input type="hidden" name="includeTax" id="includeTaxHidden" value="<?php echo $isTaxIncluded ? '1' : '0'; ?>">
    <input type="hidden" name="customerID" id="selectedCustomerID">

    <!-- Cart Actions -->
    <div class="d-flex justify-content-between mt-2">
        <button type="submit" name="hold" class="btn btn-warning btn-sm">Hold Order</button>
        <button type="submit" name="submit" class="btn btn-success btn-sm" style="background-color: #16A645; border: none;">Proceed</button>
    </div>
</form>

        <!-- Cancel Button -->
        <div class="d-flex justify-content-end mt-3">
    <button type="button" class="btn btn-secondary" style="background-color: #C94F60; border: none;" onclick="toggleCartVisibility(false)">Cancel</button>
</div>
    </li>
</ul>
<!-- Product Selection Modal -->
<div class="modal fade" id="productSelectionModal" tabindex="-1" aria-labelledby="productSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 450px;">
        <div class="modal-content" style="border-radius: 6px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);">
            <div class="modal-header" style="padding: 10px 15px;">
                <h5 class="modal-title" id="productSelectionModalLabel" style="font-size: 16px; margin-bottom: 0;">Select Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" style="padding: 15px; max-height: 400px; overflow-y: auto;">
                <!-- Search Input and Button -->
                <form action="" method="GET" class="input-group mb-3" id="productSearchForm">
                    <input type="text" class="form-control form-control-sm" placeholder="Search by Product Name or ID" name="search" id="productSearchInput">
                    <button class="btn btn-success btn-sm" type="button" style="width: 100px;" onclick="searchProducts()">Search</button>
                </form>
                
                <!-- Product List (Scrollable) -->
                <ul class="list-group" id="productList">
                    <?php if ($products): ?>
                        <?php foreach ($products as $product): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-start product-item">
                                <div class="d-flex align-items-center">
                                    <img src="../pages/<?php echo $product['Image']; ?>" alt="<?php echo htmlspecialchars($product['ProductName']); ?>" class="rounded" style="width: 35px; height: 35px; margin-right: 10px;">
                                    <div class="product-details">
                                        <p class="product-name mb-0" style="font-size: 13px;"><?php echo htmlspecialchars($product['ProductName']); ?></p>
                                        <p class="text-muted mb-0" style="font-size: 12px;">Price: Tsh <?php echo rtrim(rtrim(sprintf('%.15f', $product['SellingPrice']), '0'), '.'); ?></p>
                                        <!-- Available Quantity -->
                                        <p class="text-muted mb-0" style="font-size: 12px;">Available: <?php echo $product['Quantity'] > 0 ? $product['Quantity'] : 'Out of stock'; ?></p>
                                    </div>
                                </div>
                                
                                <!-- Editable Price and Quantity Input Fields -->
                                <div class="d-flex flex-column align-items-center" style="gap: 5px;">
                                    <!-- Editable Price Input Field -->
                                    <input type="text" id="price-<?php echo $product['ID']; ?>" class="form-control form-control-sm mb-1" value="<?php echo rtrim(rtrim(sprintf('%.15f', $product['SellingPrice']), '0'), '.'); ?>" min="0" style="width: 70px;" placeholder="Price">
                                    <!-- Editable Quantity Input Field -->
                                    <input type="number" id="quantity-<?php echo $product['ID']; ?>" class="form-control form-control-sm" min="1" max="<?php echo $product['Quantity']; ?>" value="1" style="width: 70px;" <?php echo $product['Quantity'] > 0 ? '' : 'disabled'; ?>>
                                </div>
                                
                                <!-- Add Button -->
                                <button type="button" class="btn btn-primary btn-sm" onclick="addToCart('<?php echo $product['ID']; ?>')" <?php echo $product['Quantity'] > 0 ? '' : 'disabled'; ?>>Add</button>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item text-center">No products found.</li>
                    <?php endif; ?>
                </ul>
            </div>
            <!-- Modal Footer with Stationary Cancel Button -->
            <div class="modal-footer" style="padding: 10px;">
                <button type="button" class="btn btn-danger btn-sm" onclick="cancelAndRefresh()">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- JavaScript for Adding to Cart and Canceling -->
<script>
function addToCart(productID) {
    // Get the quantity and price entered by the user for the selected product
    const quantity = parseFloat(document.getElementById('quantity-' + productID).value);
    const price = parseFloat(document.getElementById('price-' + productID).value);

    // Validate inputs
    if (isNaN(quantity) || quantity <= 0 || isNaN(price) || price <= 0) {
        alert('Please enter valid quantity and price.');
        return;
    }

    // Send an AJAX request to add_to_cart.php with the product ID, entered quantity, and price
    fetch('add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `product_id=${productID}&quantity=${quantity}&price=${price}`
    })
    .then(response => response.text())
    .then(data => {
        // Display the response message
        alert(data.includes("successfully") ? "Product added to cart!" : data);
        // Reopen the cart after adding a product
        toggleCartVisibility(true);
    })
    .catch(error => console.error('Error:', error));
}


function openProductSelectionModal() {
    toggleCartVisibility(false);
    const modal = new bootstrap.Modal(document.getElementById('productSelectionModal'));
    modal.show();
}

function cancelAndRefresh() {
    // Close the modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('productSelectionModal'));
    modal.hide();

    // Reload the page
    location.reload();
}

function toggleCartVisibility(show) {
    const cartDropdown = document.getElementById('cartDropdown');
    cartDropdown.style.display = show ? 'block' : 'none';
}

// Toggle between customer form and customer selection dropdown
function toggleCustomerForm() {
    const form = document.getElementById('addCustomerForm');
    const selection = document.getElementById('customerSelection');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
    selection.style.display = selection.style.display === 'none' ? 'block' : 'none';
}

// Show/hide mobile payment options based on the selected payment mode
document.getElementById('paymentMode').addEventListener('change', function () {
    const mobilePaymentOptions = document.getElementById('mobilePaymentOptions');
    mobilePaymentOptions.style.display = this.value === 'mobile_payment' ? 'block' : 'none';
});

// Update selected customer ID before submitting the order
document.getElementById('customerDropdown').addEventListener('change', function () {
    document.getElementById('selectedCustomerID').value = this.value;
});

// Update total based on tax inclusion and ensure totalPrice is updated for submission
function updateTotal() {
    const includeTax = document.getElementById('includeTax').checked;
    const taxSection = document.getElementById('taxAmountSection');
    const taxAmount = <?php echo $tax; ?>;
    const subtotal = <?php echo $cartSubtotal; ?>;
    const totalAmountElement = document.getElementById('totalAmount');
    const totalPriceInput = document.getElementById('totalPrice');  // Hidden input for totalPrice

    let total = subtotal;

    if (includeTax) {
        taxSection.style.display = 'flex';
        total += taxAmount;
    } else {
        taxSection.style.display = 'none';
    }

    // Update the displayed total
    totalAmountElement.innerHTML = 'Tsh ' + rtrim(rtrim(total.toFixed(15), '0'), '.');

    // Update the hidden totalPrice input for form submission
    totalPriceInput.value = rtrim(rtrim(total.toFixed(15), '0'), '.');
}

// Update hidden input and checkbox state before form submission
document.getElementById('orderForm').addEventListener('submit', function() {
    const includeTaxChecked = document.getElementById('includeTax').checked;
    
    // Update hidden field for tax inclusion
    document.getElementById('includeTaxHidden').value = includeTaxChecked ? '1' : '0';

    // Ensure totalPrice is updated before submission
    updateTotal();
});

// Initially hide the cart and set up event listener to show it after page load
document.addEventListener('DOMContentLoaded', function() {
    toggleCartVisibility(false);
    
    // Check if we need to show the cart (e.g., after a page reload)
    if (sessionStorage.getItem('showCart') === 'true') {
        toggleCartVisibility(true);
        sessionStorage.removeItem('showCart');
    }
});

// Set a flag to show the cart after page reload
window.addEventListener('beforeunload', function() {
    sessionStorage.setItem('showCart', 'true');
});
</script>



    </nav>
    <!-- End Navbar -->
    
    <?php
include '../connection.php';

// Initialize the $products array
$products = [];

// Get the search keyword from the query string
$searchKeyword = isset($_GET['search']) ? trim($_GET['search']) : '';

if (!empty($searchKeyword)) {
    // Prepare the SQL query to search by ProductName or Product Code
    $sql = "SELECT ID, ProductName, Image, SellingPrice, Quantity, Description 
            FROM products 
            WHERE ProductName LIKE ? 
            OR LOWER(CONCAT('MNY', ID)) = LOWER(?)";

    // Use prepared statements for security
    $stmt = $conn->prepare($sql);
    $searchParam = "%$searchKeyword%";
    $stmt->bind_param('ss', $searchParam, $searchKeyword);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch products into the $products array
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    $stmt->close();
}

$conn->close();
?>

<!-- Search Form -->
<div class="container py-3">
    <form method="GET" class="d-flex mb-3">
        <input type="text" name="search" placeholder="Search by Product Name or Code" 
               value="<?php echo htmlspecialchars($searchKeyword); ?>" 
               class="form-control me-2" style="max-width: 300px;">
        <button type="submit" class="btn btn-secondary">Search</button>
    </form>
</div>

<!-- Product Display -->
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <!-- Only display products if the search keyword is not empty and products are found -->
                <?php if (!empty($searchKeyword) && !empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                            <div class="card h-100" style="max-width: 150px;">
                                <!-- Product Image -->
                                <img src="../pages/<?php echo htmlspecialchars($product['Image']); ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo htmlspecialchars($product['ProductName']); ?>" 
                                     style="height: 100px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <!-- Product Name -->
                                    <h6 class="card-title" style="font-size: 0.9rem;">
                                        <?php echo htmlspecialchars($product['ProductName']); ?>
                                    </h6>
                                    <!-- Product Price -->
                                    <p class="card-text" style="font-size: 0.8rem;">
                                        Tsh <?php echo number_format($product['SellingPrice'], 2); ?>
                                    </p>
                                    <!-- Quantity Input Field -->
                                    <form action="add_to_cart.php" method="POST">
                                        <div class="input-group mb-2">
                                            <input type="number" name="quantity" value="1" min="1" 
                                                   max="<?php echo $product['Quantity']; ?>" 
                                                   class="form-control form-control-sm" required>
                                        </div>
                                        <!-- Hidden fields to pass the product ID -->
                                        <input type="hidden" name="product_id" value="<?php echo $product['ID']; ?>">
                                        <button type="submit" class="btn btn-primary btn-sm">Add</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Display a message if no products are found or if no search is performed -->
                    <?php if (!empty($searchKeyword)): ?>
                        <p>No products found. Please try a different search.</p>
                    <?php else: ?>
                        <p>Please enter a product name or code to search.</p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
      <footer class="footer pt-3  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script><i class="fa fa-heart"></i>
                <a href="index2.php" class="font-weight-bold" target="_blank"></a>
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="fa fa-cog py-2"> </i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3 ">
        <div class="float-start">
          <h5 class="mt-3 mb-0"></h5>
          <p></p>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="fa fa-close"></i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0 overflow-auto">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Sidebar Colors</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-gradient-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Sidenav Type</h6>
          <p class="text-sm">Choose between 2 different sidenav types.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-primary w-100 px-3 mb-2 active me-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
          <button class="btn bg-gradient-primary w-100 px-3 mb-2" data-class="bg-default" onclick="sidebarType(this)">Dark</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
        <!-- Navbar Fixed -->
        <div class="d-flex my-3">
          <h6 class="mb-0">Navbar Fixed</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
          </div>
        </div>
        <hr class="horizontal dark my-sm-4">
        <div class="mt-2 mb-5 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
          </div>
        </div>
        <a class="btn bg-gradient-dark w-100" href="https://www.creative-tim.com/product/argon-dashboard">Free Download</a>
        <a class="btn btn-outline-dark w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/license/argon-dashboard">View documentation</a>
        <div class="w-100 text-center">
          <a class="github-button" href="https://github.com/creativetimofficial/argon-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star creativetimofficial/argon-dashboard on GitHub">Star</a>
          <h6 class="mt-3">Thank you for sharing!</h6>
          <a href="https://twitter.com/intent/tweet?text=Check%20Argon%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fargon-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
          </a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/argon-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
          </a>
        </div>
      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <script>
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
    new Chart(ctx1, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Mobile apps",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#fbfbfb',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#ccc',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  </script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>