<?php 

include '../connection.php';  // Database connection

session_start();

// Check if both user_id and username exist in the session
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header("Location: pages/login.php");
    exit();
}

// Retrieve user information from session
$userId = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Initialize cart variables
$cartItems = [];
$cartSubtotal = 0;
$uniqueItemCount = 0;
$tax = 0;
$payableAmount = 0;

// Fetch cart items grouped by product (calculating total quantity)
$query = "SELECT p.ID, p.ProductName, p.Image, SUM(c.Quantity) AS Quantity 
          FROM cart c 
          INNER JOIN products p ON c.ProductID = p.ID 
          WHERE c.UserID = ? 
          GROUP BY p.ID";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Process cart items and calculate totals
while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
    $cartSubtotal += $row['Quantity'];
    $uniqueItemCount++;
}

// Calculate tax (18%)
$tax = $cartSubtotal * (18 / 118);
$payableAmount = $cartSubtotal;

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/white.png">
  <title>
  STEM STORE
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/theme.css" />
            border: 1px solid #ddd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        thead th {
            position: sticky;
            top: 0;
            background-color: white;
            z-index: 2;
        }
        .dots {
            cursor: pointer;
            font-size: 18px;
            color: #333;
        }
        .popup {
            display: none;
            position: fixed;
            z-index: 100;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        @media (max-width: 768px) {
            .table-responsive {
                max-height: 300px;
            }
        }

    </style>

</head>
<body class="g-sidenav-show   bg-gray-100">
<div class="min-height-300 bg-primary position-absolute w-100"></div>

<?php include "side_navigations/navigations.php" ?>

<main class="main-content position-relative border-radius-lg">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
        <div class="container-fluid py-1 px-3">
            <p style="color:white;">
                <i><strong><?php echo strtoupper($username); ?></strong></i>
            </p> 
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
                include '../connection.php';

                // Initialize the search keyword for products
                $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';

                // Define the $isTaxIncluded variable with a default value
                $isTaxIncluded = false;

                // SQL query to select products
                $sql = "SELECT ID, ProductName, Image, prod_price, 
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
                    $products = null;
                }

                $stmt->close();

                // Fetch customers from the database (only CustomerID and CustomerName)
                $customers = [];
                $query = "SELECT CustomerID, CustomerName FROM customers";
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

                    <!-- Order Dropdown Menu -->
                    <ul class="dropdown-menu cart-dropdown-menu" id="cartDropdown" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 450px; max-width: 90vw; height: auto; max-height: 80vh; overflow-y: auto; padding: 20px;">
                        <li class="cart-summary mb-2">
                            <!-- Customer Section -->
                            <div id="customerSection" class="mt-3">
                                <button class="btn btn-primary mb-2" onclick="toggleCustomerForm()">+ Add Store keeper</button>
    
                                <!-- Customer Selection Dropdown -->
                                <div id="customerSelection">
                                    <label for="customerDropdown" class="fw-bold">Select Store keeper:</label>
                                    <select name="customerID" id="customerDropdown" class="form-select" required>
                                        <option value="">Select Store keeper</option>
                                        <?php foreach ($customers as $customer): ?>
                                            <option value="<?php echo htmlspecialchars($customer['CustomerID']); ?>">
                                                <?php echo htmlspecialchars($customer['CustomerName']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Add Customer Form -->
                                <form action="add_customer.php" method="post" id="addCustomerForm" style="display:none;" class="mt-2">
                                    <input type="text" name="Store keeper" placeholder="Store keeper" required class="form-control mb-2">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <button type="button" class="btn btn-secondary" onclick="toggleCustomerForm()">Cancel</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Add Products Section -->
                            <div id="addToCartSection" class="mt-3">
                                <button class="btn btn-success" style="background-color:rgb(7, 166, 197); border: none;" onclick="toggleCartVisibility(false); openProductSelectionModal()">+ Add Products</button>
                            </div>

                            <!-- Cart Items -->
                            <ul class="cart-items list-group mb-3">
                                <?php if (isset($uniqueItemCount) && $uniqueItemCount > 0): ?>
                                    <?php foreach ($cartItems as $item): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-start cart-item">
                                            <div class="cart-item-details d-flex">
                                                <img src="pages/<?php echo $item['Image']; ?>" class="img-fluid rounded" style="width: 50px; height: 50px;">
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
                                                        <input 
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
                                    <li class="list-group-item text-center">No items selected.</li>
                                <?php endif; ?>
                            </ul>

                            <!-- Clear Cart Button -->
                            <div class="d-flex justify-content-between mb-3">
                                <form action="pages/clear_cart.php" method="POST" class="d-inline">
                                    <button type="submit" class="btn btn-danger btn-sm" style="background-color: #C94F60; border: none; color: white;">Clear Cart</button>
                                </form>
                            </div>

                            <!-- Order Form -->
                            <form action="submit_order.php" method="post" id="orderForm">
                                <!-- Hidden Inputs for Cart Data and Order Submission -->
                                <input type="hidden" name="cartItems" value="<?php echo htmlspecialchars(json_encode($cartItems ?? [])); ?>">
                                <input type="hidden" name="totalPrice" id="totalPrice" value="<?php echo htmlspecialchars($payableAmount ?? 0); ?>">
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
            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px 15px;">
                <h5 class="modal-title" id="productSelectionModalLabel" style="font-size: 16px;">Select Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" style="padding: 15px; max-height: 400px; overflow-y: auto;">
                <!-- Search Input and Button -->
                <div class="input-group mb-3">
                    <input type="text" class="form-control form-control-sm" placeholder="Search by Product Name" id="productSearchInput">
                    <button class="btn btn-success btn-sm" type="button" onclick="searchProducts()">Search</button>
                    <button class="btn btn-secondary btn-sm" type="button" onclick="clearSearch()">Clear</button>
                </div>

                <!-- Product List -->
                <ul class="list-group" id="productList">
                    <?php if ($products): ?>
                        <?php 
                        // Sort products alphabetically by ProductName
                        usort($products, function($a, $b) {
                            return strcasecmp($a['ProductName'], $b['ProductName']);
                        });
                        ?>
                        <?php foreach ($products as $product): ?>
                            <?php if (!empty(trim($product['ProductName']))): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-start product-item"
                                data-name="<?php echo strtolower(htmlspecialchars($product['ProductName'])); ?>">
                                <!-- Product Details -->
                                <div class="d-flex align-items-center">
                                    <img src="pages/<?php echo $product['Image']; ?>" alt="<?php echo htmlspecialchars($product['ProductName']); ?>" 
                                        class="rounded" style="width: 35px; height: 35px; margin-right: 10px;">
                                    <div class="product-details">
                                        <p class="mb-0" style="font-size: 13px;"><?php echo htmlspecialchars($product['ProductName']); ?></p>
                                        <p class="text-muted mb-0" style="font-size: 12px;">Price: Tsh <?php echo $product['prod_price']; ?></p>
                                        <p class="text-muted mb-0" style="font-size: 12px;">Available: <?php echo $product['Quantity'] > 0 ? $product['Quantity'] : 'Out of stock'; ?></p>
                                    </div>
                                </div>

                                <!-- Editable Fields -->
                                <div class="d-flex flex-column align-items-center">
                                    <input type="number" id="quantity-<?php echo $product['ID']; ?>" class="form-control form-control-sm" 
                                        min="1" max="<?php echo $product['Quantity']; ?>" value="1" style="width: 70px;" 
                                        <?php echo $product['Quantity'] > 0 ? '' : 'disabled'; ?>>
                                    <input type="hidden" id="price-<?php echo $product['ID']; ?>" value="<?php echo $product['prod_price']; ?>">
                                </div>

                                <!-- Add Button -->
                                <button type="button" class="btn btn-primary btn-sm" 
                                    onclick="addToCart('<?php echo $product['ID']; ?>')" 
                                    <?php echo $product['Quantity'] > 0 ? '' : 'disabled'; ?>>
                                    Add
                                </button>
                            </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item text-center">No products found.</li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer" style="padding: 10px;">
                <button type="button" class="btn btn-danger btn-sm" onclick="fastCancelAndShowCart()">Cancel</button>
                <!-- <button type="button" class="btn btn-warning btn-sm" onclick="holdOrder()">Hold</button> -->
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    // Variable to track if items have been added to cart
    let itemsAddedToCart = false;

    // Function to search products by name
    function searchProducts() {
        const searchInput = document.getElementById('productSearchInput').value.trim().toLowerCase();
        const productItems = document.querySelectorAll('.product-item');
        let hasResults = false;

        productItems.forEach(item => {
            const productName = item.getAttribute('data-name');
            if (productName.includes(searchInput)) {
                item.style.display = 'flex';
                hasResults = true;
            } else {
                item.style.display = 'none';
            }
        });

        if (!hasResults) {
            alert('No products match your search!');
        }
    }

    // Function to clear search and reset the list
    function clearSearch() {
        document.getElementById('productSearchInput').value = '';
        const productItems = document.querySelectorAll('.product-item');
        productItems.forEach(item => {
            item.style.display = 'flex';
        });
    }

    // Function to handle adding a product to cart
    function addToCart(productId) {
        const price = parseFloat(document.getElementById(`price-${productId}`).value);
        const quantity = parseFloat(document.getElementById(`quantity-${productId}`).value);

        if (isNaN(quantity) || quantity <= 0 || isNaN(price) || price <= 0) {
            alert('Please enter valid quantity and price.');
            return;
        }

        fetch('add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `product_id=${productId}&quantity=${quantity}&price=${price}`
        })
        .then(response => response.text())
        .then(data => {
            if (data.includes("successfully")) {
                alert("Product added to cart!");
                itemsAddedToCart = true; // Track that items have been added
                
                // Reset quantity input to 1 after adding
                document.getElementById(`quantity-${productId}`).value = 1;
            } else {
                alert(data);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while adding the product to cart.');
        });
    }

    // Function to open product selection modal
    function openProductSelectionModal() {
        toggleCartVisibility(false);
        itemsAddedToCart = false; // Reset the flag when opening the modal
        const modal = new bootstrap.Modal(document.getElementById('productSelectionModal'));
        modal.show();
    }

    // OPTIMIZED: Fast cancel and show cart with immediate refresh
    function fastCancelAndShowCart() {
        // Close modal immediately
        const modal = bootstrap.Modal.getInstance(document.getElementById('productSelectionModal'));
        if (modal) {
            modal.hide();
        }
        
        // Set flags for fast cart display
        sessionStorage.setItem('showCartAfterRefresh', 'true');
        sessionStorage.setItem('fastRefresh', 'true');
        
        // Immediate refresh - no delay
        location.reload();
    }

    // OPTIMIZED: Fast clear cart function
    function fastClearCart() {
        if (confirm('Are you sure you want to clear the cart?')) {
            // Set flags for fast refresh and cart display
            sessionStorage.setItem('showCartAfterRefresh', 'true');
            sessionStorage.setItem('fastRefresh', 'true');
            sessionStorage.setItem('clearCartAction', 'true');
            
            // Immediate refresh
            location.reload();
        }
        return false;
    }

    // OPTIMIZED: Fast remove item function
    function fastRemoveItem(cartItemId) {
        if (confirm('Are you sure you want to remove this item from cart?')) {
            // Set flags for fast refresh and cart display
            sessionStorage.setItem('showCartAfterRefresh', 'true');
            sessionStorage.setItem('fastRefresh', 'true');
            sessionStorage.setItem('removeItemAction', cartItemId);
            
            // Immediate refresh
            location.reload();
        }
        return false;
    }

    // Function to toggle cart visibility
    function toggleCartVisibility(show) {
        const cartDropdown = document.getElementById('cartDropdown');
        if (cartDropdown) {
            cartDropdown.style.display = show ? 'block' : 'none';
        }
    }

    // OPTIMIZED: Use fast functions for cart operations
    function clearCart() {
        return fastClearCart();
    }

    function cancelCartItem(cartItemId) {
        return fastRemoveItem(cartItemId);
    }

    // Function to toggle customer form
    function toggleCustomerForm() {
        const form = document.getElementById('addCustomerForm');
        const selection = document.getElementById('customerSelection');
        
        if (form.style.display === 'none' || form.style.display === '') {
            form.style.display = 'block';
            selection.style.display = 'none';
        } else {
            form.style.display = 'none';
            selection.style.display = 'block';
        }
    }

    // Event listener for customer dropdown change
    document.getElementById('customerDropdown')?.addEventListener('change', function () {
        const selectedCustomerIDField = document.getElementById('selectedCustomerID');
        if (selectedCustomerIDField) {
            selectedCustomerIDField.value = this.value;
        }
    });

    // Event listener for order form submission
    document.getElementById('orderForm')?.addEventListener('submit', function(e) {
        const selectedCustomer = document.getElementById('customerDropdown')?.value;
        if (!selectedCustomer) {
            alert('Please select a customer before proceeding.');
            e.preventDefault();
            return false;
        }
        
        const includeTaxChecked = document.getElementById('includeTax') ? document.getElementById('includeTax').checked : false;
        const includeTaxHidden = document.getElementById('includeTaxHidden');
        if (includeTaxHidden) {
            includeTaxHidden.value = includeTaxChecked ? '1' : '0';
        }
    });

    // Event listener for modal close events (X button or ESC key)
    document.getElementById('productSelectionModal')?.addEventListener('hidden.bs.modal', function () {
        // Fast refresh when modal is closed if items were added
        if (itemsAddedToCart) {
            sessionStorage.setItem('showCartAfterRefresh', 'true');
            sessionStorage.setItem('fastRefresh', 'true');
            location.reload();
        }
    });

    // OPTIMIZED: Fast page load handler for immediate cart display
    document.addEventListener('DOMContentLoaded', function() {
        // Check if this is a fast refresh
        const isFastRefresh = sessionStorage.getItem('fastRefresh') === 'true';
        const showCart = sessionStorage.getItem('showCartAfterRefresh') === 'true';
        const clearCartAction = sessionStorage.getItem('clearCartAction') === 'true';
        const removeItemAction = sessionStorage.getItem('removeItemAction');
        
        if (isFastRefresh) {
            // Clear all flags immediately
            sessionStorage.removeItem('fastRefresh');
            sessionStorage.removeItem('showCartAfterRefresh');
            sessionStorage.removeItem('clearCartAction');
            sessionStorage.removeItem('removeItemAction');
            
            // Handle cart actions first
            if (clearCartAction) {
                // Clear cart via AJAX
                fetch('clear_cart.php', {
                    method: 'POST'
                }).then(() => {
                    // Load and show cart immediately
                    if (typeof loadCartItems === 'function') {
                        loadCartItems();
                    }
                    showCartImmediately();
                }).catch(error => {
                    console.error('Error clearing cart:', error);
                    showCartImmediately();
                });
            } else if (removeItemAction) {
                // Remove item via AJAX
                fetch('remove_cart_item.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `cart_item_id=${removeItemAction}`
                }).then(() => {
                    // Load and show cart immediately
                    if (typeof loadCartItems === 'function') {
                        loadCartItems();
                    }
                    showCartImmediately();
                }).catch(error => {
                    console.error('Error removing item:', error);
                    showCartImmediately();
                });
            } else if (showCart) {
                // Just show cart immediately
                showCartImmediately();
            }
        }
    });

    // OPTIMIZED: Function to show cart immediately without delays
    function showCartImmediately() {
        // Show cart dropdown immediately
        const cartDropdown = document.getElementById('cartDropdown');
        if (cartDropdown) {
            cartDropdown.style.display = 'block';
            
            // Load cart items if function exists
            if (typeof loadCartItems === 'function') {
                loadCartItems();
            }
            
            // Scroll to cart immediately - no delay
            cartDropdown.scrollIntoView({ 
                behavior: 'auto', // Use 'auto' for immediate scroll
                block: 'nearest' 
            });
            
            // Focus on cart for better UX
            cartDropdown.focus();
        }
    }

    // Enhanced search functionality - search on Enter key press
    document.getElementById('productSearchInput')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchProducts();
        }
    });

    // Real-time search as user types
    document.getElementById('productSearchInput')?.addEventListener('input', function() {
        const searchInput = this.value.trim().toLowerCase();
        const productItems = document.querySelectorAll('.product-item');
        
        // If search input is empty, show all products
        if (searchInput === '') {
            productItems.forEach(item => {
                item.style.display = 'flex';
            });
            return;
        }
        
        // Filter products based on search input
        productItems.forEach(item => {
            const productName = item.getAttribute('data-name');
            if (productName.includes(searchInput)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // PERFORMANCE OPTIMIZATION: Preload cart functions
    document.addEventListener('DOMContentLoaded', function() {
        // Preload cart items function if it exists
        if (typeof loadCartItems === 'function') {
            // Cache the function for faster execution
            window.cachedLoadCartItems = loadCartItems;
        }
    });
</script>

    </nav>
    <!-- End Navbar -->


<?php
include '../connection.php';

// Check if tax is included in the total
$includeTax = isset($_GET['includeTax']) && $_GET['includeTax'] == '1';
$taxRate = 0.18;

// Get search input
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query to fetch order data (removed LPO, Address, PaymentMode)
$query = "
    SELECT 
        o.ID AS OrderID, u.username AS UserName, c.CustomerName, oi.Quantity, 
        p.ProductName, oi.Price AS OrderedPrice, o.TotalPrice, o.AddedDate,
        o.PaymentStatus, o.Status
    FROM orders o
    JOIN users u ON o.UserID = u.id 
    JOIN customers c ON o.CustomerID = c.CustomerID 
    JOIN order_items oi ON o.ID = oi.OrderID 
    JOIN products p ON oi.ProductID = p.ID 
    WHERE 
        c.CustomerName LIKE ? OR 
        o.ID LIKE ? OR 
        u.username LIKE ?
    ORDER BY o.AddedDate DESC
";

$stmt = $conn->prepare($query);
$searchParam = "%{$search}%";
$stmt->bind_param('sss', $searchParam, $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();

// Group items by OrderID
$orders = [];
while ($row = $result->fetch_assoc()) {
    $orderID = $row['OrderID'];
    if (!isset($orders[$orderID])) {
        $orders[$orderID] = [
            'OrderID' => $orderID,
            'UserName' => $row['UserName'],
            'CustomerName' => $row['CustomerName'],
            'AddedDate' => $row['AddedDate'],
            'PaymentStatus' => $row['PaymentStatus'] ?: 'Unpaid',
            'Status' => $row['Status'] ?: 'Pending',
            'TotalPrice' => $row['TotalPrice'],
            'Items' => []
        ];
    }
    $orders[$orderID]['Items'][] = [
        'ProductName' => $row['ProductName'],
        'Quantity' => $row['Quantity'],
        'OrderedPrice' => $row['OrderedPrice']
    ];
}
?>

<style>
.table th, .table td {
    font-size: 0.9rem;
    vertical-align: middle;
}
.form-inline .form-control {
    width: 250px;
}
.toggle-items {
    font-size: 1.1rem;
    font-weight: bold;
    color: #007bff;
    cursor: pointer;
    margin-left: 5px;
    transition: color 0.3s;
}
.toggle-items:hover {
    color: #0056b3;
}
.extra-items {
    margin-top: 8px;
    padding-left: 15px;
    border-left: 3px solid #e9ecef;
    background-color: #f8f9fa;
    border-radius: 4px;
    padding: 8px;
}
.table-primary {
    background-color: rgba(13, 110, 253, 0.1) !important;
}
.badge {
    font-size: 0.75rem;
}
.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}
.sticky-header {
    position: sticky;
    top: 0;
    background-color: #fff;
    z-index: 10;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">All Orders</h6>
                        <div class="d-flex align-items-center">
                            <form method="GET" action="" class="form-inline d-flex">
                                <input type="text" name="search" placeholder="Search by Order No, Customer, or User" 
                                       value="<?= htmlspecialchars($search) ?>" class="form-control me-2">
                                <input type="hidden" name="includeTax" value="<?= $includeTax ? '1' : '0' ?>">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <?php if ($search): ?>
                                    <a href="?" class="btn btn-secondary ms-2">Clear</a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead class="sticky-header">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Order No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Store keeper Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Details</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Order Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Store keeper Note</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($orders) > 0): ?>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td>
                                                <a href="#" class="text-primary fw-bold order-link" data-order-id="<?= $order['OrderID'] ?>">
                                                    #<?= htmlspecialchars($order['OrderID']) ?>
                                                </a>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?= htmlspecialchars($order['UserName']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?= htmlspecialchars($order['CustomerName']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if (count($order['Items']) > 1): ?>
                                                    <div>
                                                        <div class="text-xs">
                                                            <strong><?= htmlspecialchars($order['Items'][0]['ProductName']) ?></strong><br>
                                                            Qty: <?= htmlspecialchars($order['Items'][0]['Quantity']) ?> @ 
                                                            Tsh <?= number_format($order['Items'][0]['OrderedPrice'], 2) ?>
                                                        </div>
                                                        <span class="toggle-items" data-order-id="<?= $order['OrderID'] ?>" title="View more items">
                                                            +<?= count($order['Items']) - 1 ?> more
                                                        </span>
                                                        <div id="extra-items-<?= $order['OrderID'] ?>" class="extra-items" style="display: none;">
                                                            <?php for ($i = 1; $i < count($order['Items']); $i++): ?>
                                                                <div class="text-xs mb-1">
                                                                    <strong><?= htmlspecialchars($order['Items'][$i]['ProductName']) ?></strong><br>
                                                                    Qty: <?= htmlspecialchars($order['Items'][$i]['Quantity']) ?> @ 
                                                                    Tsh <?= number_format($order['Items'][$i]['OrderedPrice'], 2) ?>
                                                                </div>
                                                            <?php endfor; ?>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="text-xs">
                                                        <strong><?= htmlspecialchars($order['Items'][0]['ProductName']) ?></strong><br>
                                                        Qty: <?= htmlspecialchars($order['Items'][0]['Quantity']) ?> @ 
                                                        Tsh <?= number_format($order['Items'][0]['OrderedPrice'], 2) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <!-- <td>
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    Tsh <?= number_format($includeTax ? $order['TotalPrice'] * (1 + $taxRate) : $order['TotalPrice'], 2) ?>
                                                </span>
                                            </td> -->
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?= date('M j, Y g:i A', strtotime($order['AddedDate'])) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-sm bg-gradient-<?= $order['Status'] === 'Pending' ? 'info' : ($order['Status'] === 'Approved' ? 'success' : 'danger') ?>">
                                                    <?= htmlspecialchars($order['Status']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($order['Status'] === 'Approved'): ?>
                                                    <a href="delivery_note/delivery_note.php?order_id=<?= $order['OrderID'] ?>" 
                                                       class="btn btn-sm btn-outline-primary" target="_blank">
                                                        <i class="fas fa-file-alt"></i> View Note
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-secondary text-xs">Not Available</span>
                                                <?php endif; ?>
                                            </td>
                                            <!-- <td>
                                                <button class="btn btn-sm btn-outline-<?= $order['PaymentStatus'] === 'Unpaid' ? 'danger' : ($order['PaymentStatus'] === 'Pending' ? 'warning' : 'success') ?> update-payment" 
                                                        data-order-id="<?= $order['OrderID'] ?>" 
                                                        data-current-status="<?= $order['PaymentStatus'] ?>"
                                                        title="Click to update payment status">
                                                    <i class="fas fa-<?= $order['PaymentStatus'] === 'Paid' ? 'check-circle' : ($order['PaymentStatus'] === 'Pending' ? 'clock' : 'times-circle') ?>"></i>
                                                    <?= htmlspecialchars($order['PaymentStatus']) ?>
                                                </button>
                                            </td> -->
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                                            id="actionDropdown<?= $order['OrderID'] ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="actionDropdown<?= $order['OrderID'] ?>">
                                                        <li>
                                                            <h6 class="dropdown-header">Order Actions</h6>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <a href="pages/edit_order.php?order_id=<?= $order['OrderID'] ?>" class="dropdown-item">
                                                                <i class="fas fa-edit text-primary"></i> Edit Order
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item text-danger delete-order" data-order-id="<?= $order['OrderID'] ?>">
                                                                <i class="fas fa-trash"></i> Delete Order
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="10" class="text-center py-4">
                                            <div class="text-center">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <h6 class="text-muted">No orders found</h6>
                                                <?php if ($search): ?>
                                                    <p class="text-muted">Try adjusting your search criteria</p>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Handle toggle for extra items
    document.querySelectorAll('.toggle-items').forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const orderId = this.getAttribute('data-order-id');
            const extraItemsDiv = document.getElementById(`extra-items-${orderId}`);
            
            if (extraItemsDiv.style.display === 'none') {
                extraItemsDiv.style.display = 'block';
                this.innerHTML = '<i class="fas fa-minus"></i> Hide';
                this.classList.remove('text-primary');
                this.classList.add('text-danger');
            } else {
                extraItemsDiv.style.display = 'none';
                const itemCount = extraItemsDiv.children.length;
                this.innerHTML = `+${itemCount} more`;
                this.classList.remove('text-danger');
                this.classList.add('text-primary');
            }
        });
    });

    // Make order numbers clickable to highlight the row
    document.querySelectorAll('.order-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove highlight from all rows
            document.querySelectorAll('tbody tr').forEach(row => {
                row.classList.remove('table-primary');
            });
            
            // Highlight this row
            this.closest('tr').classList.add('table-primary');
            
            // Show a toast or notification
            showNotification(`Order #${this.getAttribute('data-order-id')} selected`, 'info');
        });
    });

    // Handle payment status updates
    document.querySelectorAll('.update-payment').forEach(button => {
        button.addEventListener('click', function () {
            const orderId = this.getAttribute('data-order-id');
            const currentStatus = this.getAttribute('data-current-status');
            let newStatus;

            // Determine the next status
            if (currentStatus === 'Unpaid') {
                newStatus = 'Pending';
            } else if (currentStatus === 'Pending') {
                newStatus = 'Paid';
            } else {
                showNotification('Payment is already marked as Paid.', 'warning');
                return;
            }

            if (confirm(`Mark order #${orderId} payment as ${newStatus}?`)) {
                // Show loading state
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
                this.disabled = true;

                fetch('update_payment_status.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ order_id: orderId, status: newStatus })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Payment status updated successfully.', 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showNotification('Error updating payment status: ' + data.message, 'error');
                        this.innerHTML = originalText;
                        this.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('An error occurred while updating the payment status.', 'error');
                    this.innerHTML = originalText;
                    this.disabled = false;
                });
            }
        });
    });

    // Handle order deletion
    document.querySelectorAll('.delete-order').forEach(button => {
        button.addEventListener('click', function () {
            const orderId = this.getAttribute('data-order-id');
            if (confirm(`Are you sure you want to delete order #${orderId}?\n\nThis action cannot be undone.`)) {
                // Show loading state
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
                this.disabled = true;

                fetch('delete_order.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ order_id: orderId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Order deleted successfully.', 'success');
                        // Remove the row with animation
                        const row = this.closest('tr');
                        row.style.transition = 'opacity 0.5s';
                        row.style.opacity = '0';
                        setTimeout(() => {
                            row.remove();
                            // Check if table is empty
                            if (document.querySelectorAll('tbody tr').length === 0) {
                                location.reload();
                            }
                        }, 500);
                    } else {
                        showNotification('Error deleting order: ' + data.message, 'error');
                        this.innerHTML = '<i class="fas fa-trash"></i> Delete Order';
                        this.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('An error occurred while deleting the order.', 'error');
                    this.innerHTML = '<i class="fas fa-trash"></i> Delete Order';
                    this.disabled = false;
                });
            }
        });
    });

    // Utility function to show notifications
    function showNotification(message, type) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : type === 'warning' ? 'warning' : 'info'} alert-dismissible fade show position-fixed`;
        notification.style.top = '20px';
        notification.style.right = '20px';
        notification.style.zIndex = '9999';
        notification.style.minWidth = '300px';
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : type === 'warning' ? 'exclamation-circle' : 'info-circle'}"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }
});
</script>

      <footer class="footer pt-3  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <!-- <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script><i class="fa fa-heart"></i>
                <a href="index.html" class="font-weight-bold" target="_blank"></a>
              </div> -->
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
  <!--   Core JS Files   -->
  <script src="./assets/js/core/popper.min.js"></script>
  <script src="./assets/js/core/bootstrap.min.js"></script>
  <script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="./assets/js/plugins/chartjs.min.js"></script>
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
  
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const todoList = document.getElementById('todoList');
    const addTaskBtn = document.getElementById('addTaskBtn');
    const todoInput = document.getElementById('todoInput');

    // Load tasks on page load
    loadTasks();

    addTaskBtn.addEventListener('click', function() {
      const taskText = todoInput.value.trim();
      if (taskText) {
        const task = {
          text: taskText,
          timestamp: new Date().getTime()  // Save the current time when adding task
        };
        addTask(task);
        saveTask(task);
        todoInput.value = '';  // Clear input after adding
      }
    });

    // Function to add task to the DOM
    function addTask(task) {
      const li = document.createElement('li');
      li.innerHTML = `
        <div class="form-check form-check-primary">
          <label class="form-check-label">
            <input class="checkbox" type="checkbox"> ${task.text}
          </label>
        </div>
        <i class="remove mdi mdi-close-box"></i>
      `;
      todoList.appendChild(li);

      // Add remove functionality
      li.querySelector('.remove').addEventListener('click', function() {
        removeTask(task.text);
        li.remove();
      });
    }

    // Function to save task to localStorage
    function saveTask(task) {
      const tasks = getStoredTasks();
      tasks.push(task);
      localStorage.setItem('tasks', JSON.stringify(tasks));
    }

    // Function to remove task from localStorage
    function removeTask(taskText) {
      let tasks = getStoredTasks();
      tasks = tasks.filter(task => task.text !== taskText);
      localStorage.setItem('tasks', JSON.stringify(tasks));
    }

    // Load stored tasks and display them
    function loadTasks() {
      const tasks = getStoredTasks();
      const currentTime = new Date().getTime();

      tasks.forEach(task => {
        // Check if the task is less than 24 hours old (86400000 ms)
        if (currentTime - task.timestamp < 86400000) {
          addTask(task);  // Add valid task to the list
        }
      });

      // Remove tasks older than 24 hours from localStorage
      const recentTasks = tasks.filter(task => currentTime - task.timestamp < 86400000);
      localStorage.setItem('tasks', JSON.stringify(recentTasks));
    }

    // Get stored tasks from localStorage
    function getStoredTasks() {
      return JSON.parse(localStorage.getItem('tasks')) || [];
    }
  });
</script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="./assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>