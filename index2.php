<?php 

include 'connection.php';  // Database connection

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <link rel="stylesheet" href="./assets/css/theme.css" />

</head>
<body class="g-sidenav-show   bg-gray-100">
<div class="min-height-300 bg-primary position-absolute w-100"></div>

<?php include "pages/side_navigations/navigations.php" ?>

<main class="main-content position-relative border-radius-lg">
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
                include 'connection.php';

                // Define the $isTaxIncluded variable with a default value
                $isTaxIncluded = false;

                // SQL query to select ALL products for the modal so Autosearch works
                $sql = "SELECT ID, ProductName, Image, prod_price, 
                        Quantity, Description, AddedDate 
                        FROM products 
                        ORDER BY AddedDate DESC";

                // Prepare and execute the query
                $stmt = $conn->prepare($sql);
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

                // Close the database connection (It will be opened again later in the orders section)
                $conn->close(); 
                ?>

                <li class="nav-item d-flex align-items-center">
                    <a href="#" class="nav-link p-0" id="cartButton" onclick="toggleCartVisibility(true); return false;">
                        <button class="btn" style="background-color: black; color: white;">
                            <i class="fa fa-plus"></i> Place Order
                        </button>
                    </a>

                    <ul class="dropdown-menu cart-dropdown-menu" id="cartDropdown" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 450px; max-width: 90vw; height: auto; max-height: 80vh; overflow-y: auto; padding: 20px;">
                        <li class="cart-summary mb-2">
                            <div id="customerSection" class="mt-3">
                                <button class="btn btn-primary mb-2" onclick="toggleCustomerForm()">+ Add Store keeper</button>
    
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

                                <form action="add_customer.php" method="post" id="addCustomerForm" style="display:none;" class="mt-2">
                                    <input type="text" name="Store keeper" placeholder="Store keeper" required class="form-control mb-2">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <button type="button" class="btn btn-secondary" onclick="toggleCustomerForm()">Cancel</button>
                                    </div>
                                </form>
                            </div>

                            <div id="addToCartSection" class="mt-3">
                                <button class="btn btn-success" style="background-color:rgb(7, 166, 197); border: none;" onclick="toggleCartVisibility(false); openProductSelectionModal()">+ Add Products</button>
                            </div>

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

                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                <form action="pages/clear_cart.php" method="POST" class="d-inline">
                                    <button type="submit" class="btn btn-danger btn-sm" style="background-color: #C94F60; border: none; color: white;">Clear Cart</button>
                                </form>

                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-secondary btn-sm" style="background-color: #C94F60; border: none;" onclick="toggleCartVisibility(false)">Cancel</button>

                                    <form action="submit_order.php" method="post" id="orderForm" class="d-inline">
                                        <input type="hidden" name="cartItems" value="<?php echo htmlspecialchars(json_encode($cartItems ?? [])); ?>">
                                        <input type="hidden" name="totalPrice" id="totalPrice" value="<?php echo htmlspecialchars($payableAmount ?? 0); ?>">
                                        <input type="hidden" name="includeTax" id="includeTaxHidden" value="<?php echo $isTaxIncluded ? '1' : '0'; ?>">
                                        <input type="hidden" name="customerID" id="selectedCustomerID">
                                        
                                        <button type="submit" name="submit" class="btn btn-success btn-sm" style="background-color: #16A645; border: none;">Proceed</button>
                                    </form>
                                </div>
                            </div>
                            </li>
                    </ul>
<div class="modal fade" id="productSelectionModal" tabindex="-1" aria-labelledby="productSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 460px;">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header">
                <h5 class="modal-title" id="productSelectionModalLabel">Select Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                <input type="text" id="productSearchInput" class="form-control mb-3" placeholder="Search products..." autofocus autocomplete="off">

                <ul class="list-group" id="productList">
                    <?php if ($products): ?>
                        <?php usort($products, fn($a,$b) => strcasecmp($a['ProductName'], $b['ProductName'])); ?>
                        <?php foreach ($products as $product): 
                            $stock = (int)$product['Quantity'];
                            $outOfStock = $stock <= 0;
                        ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center product-item p-3"
                                data-name="<?= strtolower(htmlspecialchars($product['ProductName'])) ?>">
                                <div class="d-flex align-items-center flex-grow-1">
                                    <img src="pages/<?= htmlspecialchars($product['Image']) ?>" 
                                         class="rounded me-3" style="width:50px;height:50px;object-fit:cover;">
                                    <div>
                                        <strong class="d-block"><?= htmlspecialchars($product['ProductName']) ?></strong>
                                        <small class="text-muted">
                                           
                                            Stock: <span class="<?= $stock <= 5 ? 'text-danger fw-bold' : '' ?>">
                                                <?= $stock > 0 ? $stock : 'Out of Stock' ?>
                                            </span>
                                        </small>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <input type="number" 
                                           id="quantity-<?= $product['ID'] ?>" 
                                           class="form-control form-control-sm text-center"
                                           value="1" 
                                           min="1" 
                                           max="<?= $stock ?>" 
                                           style="width:70px;"
                                           <?= $outOfStock ? 'disabled' : '' ?>
                                           oninput="validateQuantity(this, <?= $stock ?>, <?= $product['ID'] ?>)">

                                    <input type="hidden" id="price-<?= $product['ID'] ?>" value="<?= $product['prod_price'] ?>">

                                    <button type="button" 
                                            id="addBtn-<?= $product['ID'] ?>"
                                            class="btn btn-sm <?= $outOfStock ? 'btn-secondary' : 'btn-primary' ?>"
                                            onclick="addToCart('<?= $product['ID'] ?>')"
                                            <?= $outOfStock ? 'disabled' : '' ?>>
                                        <?= $outOfStock ? 'No Stock' : 'Add' ?>
                                    </button>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item text-center text-muted py-4">No products found in database</li>
                    <?php endif; ?>
                </ul>
                <div id="noResultsMessage" class="text-center text-muted py-4" style="display: none;">
                    <i class="fas fa-search fa-2x mb-3 opacity-5"></i>
                    <p class="mb-0">No products match your search.</p>
                </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Variable to track if items have been added to cart
    let itemsAddedToCart = false;

    // Function to filter products by name in real-time
    function filterProducts() {
        const searchInput = document.getElementById('productSearchInput');
        const filterValue = searchInput.value.trim().toLowerCase();
        const productItems = document.querySelectorAll('.product-item');
        const noResultsMsg = document.getElementById('noResultsMessage');
        let visibleCount = 0;

        productItems.forEach(item => {
            // Get product name from data attribute
            const productName = item.getAttribute('data-name') || '';
            
            // Check if name contains search term
            if (productName.includes(filterValue)) {
                item.style.setProperty('display', 'flex', 'important'); // Force display flex
                visibleCount++;
            } else {
                item.style.setProperty('display', 'none', 'important'); // Force hide
            }
        });

        // Toggle "No Results" message based on visible items
        if (visibleCount === 0 && productItems.length > 0) {
            noResultsMsg.style.display = 'block';
        } else {
            noResultsMsg.style.display = 'none';
        }
    }

    // Function to handle adding a product to cart
  // Updated: Add to cart SILENTLY – no popup message
function addToCart(productId) {
    const priceInput = document.getElementById(`price-${productId}`);
    const quantityInput = document.getElementById(`quantity-${productId}`);
    const addBtn = document.getElementById(`addBtn-${productId}`);

    if (!priceInput || !quantityInput || !addBtn) return;

    const price = parseFloat(priceInput.value);
    const quantity = parseFloat(quantityInput.value);

    if (isNaN(quantity) || quantity <= 0 || isNaN(price)) return;

    // Show loading spinner
    const originalText = addBtn.innerHTML;
    addBtn.disabled = true;
    addBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

    fetch('add_to_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `product_id=${productId}&quantity=${quantity}&price=${price}`
    })
    .then(r => r.text())
    .then(data => {
        if (data.trim().toLowerCase().includes("successfully") || data.trim() === "1") {
            // SUCCESS – just reset quantity, stay in modal
            quantityInput.value = 1;
            itemsAddedToCart = true;

            // Optional: tiny visual feedback (very subtle)
            addBtn.innerHTML = '<i class="fas fa-check text-white"></i>';
            setTimeout(() => {
                addBtn.innerHTML = 'Add';
                addBtn.disabled = false;
            }, 800);
        } else {
            alert("Error: " + data);
            addBtn.innerHTML = originalText;
            addBtn.disabled = false;
        }
    })
    .catch(err => {
        console.error(err);
        alert("Network error");
        addBtn.innerHTML = originalText;
        addBtn.disabled = false;
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
        const searchInput = document.getElementById('productSearchInput');
        const noResultsMsg = document.getElementById('noResultsMessage');
        const productItems = document.querySelectorAll('.product-item');

        // 1. Clear the search input
        if (searchInput) {
            searchInput.value = '';
        }

        // 2. Hide the "No Results" message
        if (noResultsMsg) {
            noResultsMsg.style.display = 'none';
        }

        // 3. Reset all products to be visible again
        productItems.forEach(item => {
            item.style.display = 'flex'; 
        });

        // Fast refresh when modal is closed if items were added
        if (itemsAddedToCart) {
            sessionStorage.setItem('showCartAfterRefresh', 'true');
            sessionStorage.setItem('fastRefresh', 'true');
            location.reload();
        }
    });

    // OPTIMIZED: Fast page load handler for immediate cart display
    document.addEventListener('DOMContentLoaded', function() {
        // NEW: Check for URL parameter from PHP redirect (added for your delete logic)
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('cart') === 'open') {
            showCartImmediately();
            // Optional: Clean URL so it doesn't reopen on manual refresh
            const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            window.history.replaceState({path: newUrl}, '', newUrl);
        }

        // Check if this is a fast refresh (Existing Logic)
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

    // Enhanced search functionality - search on Enter key press (Removed as 'input' listener handles it)
    
    // Real-time search as user types
    document.getElementById('productSearchInput')?.addEventListener('input', function() {
        filterProducts();
    });

    // PERFORMANCE OPTIMIZATION: Preload cart functions
    document.addEventListener('DOMContentLoaded', function() {
        // Preload cart items function if it exists
        if (typeof loadCartItems === 'function') {
            // Cache the function for faster execution
            window.cachedLoadCartItems = loadCartItems;
        }
        
        // Focus the input field automatically when modal opens
        document.getElementById('productSelectionModal')?.addEventListener('shown.bs.modal', function () {
            document.getElementById('productSearchInput')?.focus();
        });
    });
</script>

    </nav>
    <?php
include 'connection.php'; // Include DB connection

// Get today's date
$today = date('Y-m-d');

// === Card 1: Staff ===
$staffQuery = "SELECT COUNT(*) as total_staff FROM users";
$staffResult = $conn->query($staffQuery)->fetch_assoc();
$totalStaff = $staffResult['total_staff'];

// === Card 2: Products (count distinct product types) ===
$productQuery = "SELECT COUNT(*) as total_products FROM products";
$productResult = $conn->query($productQuery)->fetch_assoc();
$totalProducts = $productResult['total_products'];

// === Card 3: Orders Today ===
$ordersTodayQuery = "SELECT COUNT(*) as total_orders_today FROM orders WHERE DATE(AddedDate) = ?";
$stmt = $conn->prepare($ordersTodayQuery);
$stmt->bind_param("s", $today);
$stmt->execute();
$ordersTodayResult = $stmt->get_result()->fetch_assoc();
$totalOrdersToday = $ordersTodayResult['total_orders_today'] ?? 0;

// === Card 4: Total Cost (sum of prod_price) ===
$totalCostQuery = "SELECT SUM(prod_price) as total_cost FROM products";
$totalCostResult = $conn->query($totalCostQuery)->fetch_assoc();
$totalCost = $totalCostResult['total_cost'] ?? 0;

$conn->close();
?>

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Staff</p>
                <h5 class="font-weight-bolder"><?= number_format($totalStaff, 0) ?></h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Products</p>
                <h5 class="font-weight-bolder"><?= number_format($totalProducts, 0) ?></h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                <i class="ni ni-box-2 text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Orders Today</p>
                <h5 class="font-weight-bolder"><?= number_format($totalOrdersToday, 0) ?></h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                <i class="ni ni-delivery-fast text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Cost</p>
                <h5 class="font-weight-bolder"><?= number_format($totalCost, 0) ?></h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php
include 'connection.php';

// Check if tax is included in the total
$includeTax = isset($_GET['includeTax']) && $_GET['includeTax'] == '1';
$taxRate = 0.18;

// Get search input
$search = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($searchKeyword)) {
    // Escape for LIKE search
    $searchPattern = "%" . str_replace(['%', '_'], ['\\%', '\\_'], $searchKeyword) . "%";
    $whereConditions[] = "ProductName LIKE ?";
    $params[] = $searchPattern;
    $types .= 's';

}

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
// ... the rest of the file

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

// Convert PHP array to JSON for use in JavaScript
$ordersJson = json_encode($orders);
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
                                                            Qty: <?= htmlspecialchars($order['Items'][0]['Quantity']) ?> 
                                                          
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
                                            <td>
                                               
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

<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="orderDetailsModalLabel">Order Details - <span id="modalOrderId"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Customer:</strong> <span id="modalCustomerName"></span></p>
                <p><strong>Order User:</strong> <span id="modalUserName"></span></p>
                <p><strong>Date:</strong> <span id="modalOrderDate"></span></p>
                <p><strong>Status:</strong> <span id="modalOrderStatus" class="badge"></span></p>
                
                <h6 class="mt-3">Items:</h6>
                <ul id="modalOrderItems" class="list-group">
                    </ul>
                
                <h5 class="mt-3 pt-3 border-top"> <span id="modalTotalPrice" class="text-success fw-bold"></span></h5>
            </div>
            <div class="modal-footer justify-content-between">
                <div class="d-flex gap-2">
                    <button type="button" id="approveOrderBtn" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Approve</button>
                    <button type="button" id="rejectOrderBtn" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Reject</button>
                    <a href="#" id="editOrderLink" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                </div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

    // Get the PHP orders array as a JavaScript object
    const ordersData = <?= $ordersJson ?? '[]' ?>;

    // --- New: Handle Order Link Click to Show Modal ---
    document.querySelectorAll('.order-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            // Clear any previous highlighting
            document.querySelectorAll('tbody tr').forEach(row => {
                row.classList.remove('table-primary');
            });
            
            // Highlight the current row
            const currentRow = this.closest('tr');
            currentRow.classList.add('table-primary');

            const orderId = this.getAttribute('data-order-id');
            const order = ordersData[orderId];

            if (order) {
                // Populate Modal Content
                document.getElementById('modalOrderId').textContent = order.OrderID;
                document.getElementById('modalCustomerName').textContent = order.CustomerName;
                document.getElementById('modalUserName').textContent = order.UserName;
                document.getElementById('modalOrderDate').textContent = new Date(order.AddedDate).toLocaleString();
                
                // Status Badge
                const statusSpan = document.getElementById('modalOrderStatus');
                statusSpan.textContent = order.Status;
                statusSpan.className = 'badge'; // Reset classes
                let badgeClass = 'bg-gradient-info';
                if (order.Status === 'Approved') badgeClass = 'bg-gradient-success';
                else if (order.Status === 'Rejected') badgeClass = 'bg-gradient-danger';
                statusSpan.classList.add('badge-sm', badgeClass);

                // Populate Items List
                const itemsList = document.getElementById('modalOrderItems');
                itemsList.innerHTML = '';
                order.Items.forEach(item => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item d-flex justify-content-between align-items-center';
                    li.innerHTML = `
                        <div>
                            <strong>${item.ProductName}</strong> 
                            <small class="text-muted">(${item.Quantity} units)</small>
                        </div>
                        
                    `;
                    itemsList.appendChild(li);
                });
                
                // Update Action Buttons
                document.getElementById('approveOrderBtn').onclick = () => updateOrderStatus(orderId, 'Approved');
                document.getElementById('rejectOrderBtn').onclick = () => updateOrderStatus(orderId, 'Rejected');
                document.getElementById('editOrderLink').href = `pages/edit_order.php?order_id=${orderId}`;
                document.getElementById('approveOrderBtn').disabled = order.Status === 'Approved';
                document.getElementById('rejectOrderBtn').disabled = order.Status === 'Rejected';

                // Show the modal using Bootstrap's JavaScript API
                const modal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
                modal.show();

            } else {
                showNotification(`Order #${orderId} details not found.`, 'error');
            }
        });
    });

    // --- New: Centralized Function to Update Order Status ---
    function updateOrderStatus(orderId, newStatus) {
        if (confirm(`Are you sure you want to mark Order #${orderId} as ${newStatus}?`)) {
            // Disable buttons to prevent double click
            document.getElementById('approveOrderBtn').disabled = true;
            document.getElementById('rejectOrderBtn').disabled = true;

            fetch('pages/update_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `order_id=${orderId}&status=${newStatus}`
            })
            .then(r => r.text())
            .then(data => {
                // Check for success condition (assuming 'successfully' is part of a success message or the script returns 1)
                if (data.includes('successfully') || data.includes('already') || data.trim() === '1') {
                    showNotification(`Order #${orderId} status updated to ${newStatus}.`, 'success');
                    // Reload the page after a short delay to reflect changes in the main table
                    setTimeout(() => location.reload(), 800);
                } else {
                    showNotification('Error updating status: ' + data, 'error');
                    document.getElementById('approveOrderBtn').disabled = false;
                    document.getElementById('rejectOrderBtn').disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred during status update.', 'error');
                document.getElementById('approveOrderBtn').disabled = false;
                document.getElementById('rejectOrderBtn').disabled = false;
            });
        }
    }


    // Handle payment status updates (existing logic)
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

    // Handle order deletion (existing logic)
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
<script>
// Real-time validation: Disable "Add" button if quantity > stock
function validateQuantity(input, availableStock, productId) {
    const qty = parseInt(input.value) || 0;
    const addBtn = document.getElementById('addBtn-' + productId);

    if (qty > availableStock || qty < 1 || availableStock <= 0) {
        addBtn.disabled = true;
        addBtn.classList.remove('btn-primary');
        addBtn.classList.add('btn-secondary');
        addBtn.textContent = 'Invalid';
    } else {
        addBtn.disabled = false;
        addBtn.classList.remove('btn-secondary');
        addBtn.classList.add('btn-primary');
        addBtn.textContent = 'Add';
    }
}

// Also run validation on page load (in case of pre-filled values)
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[id^="quantity-"]').forEach(input => {
        const productId = input.id.split('-')[1];
        const stock = parseInt(input.max);
        validateQuantity(input, stock, productId);
    });
});
</script>
      <footer class="footer pt-3  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
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
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="./assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>