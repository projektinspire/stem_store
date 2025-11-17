
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/white.png">
  <title>
STEM STORE
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

.notification-bubble {
    position: absolute;
    top: 60px; /* Adjust based on your layout */
    right: 0;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    max-width: 200px;
}

.notification-bubble p {
    margin: 0;
    padding: 5px 0;
    font-size: 0.9rem;
    color: #333;
}

.notification-bubble::after {
    content: '';
    position: absolute;
    top: -10px; /* Adjust arrow position */
    right: 10px; /* Adjust arrow position */
    border-width: 10px;
    border-style: solid;
    border-color: transparent transparent #fff transparent;
}

  </style>
</head>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main" style="height: 100vh; position: fixed; overflow: hidden;">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href=" ../index2.php " target="_blank">
        <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">STEM STORE</span>
      </a>
    </div>
   <hr class="horizontal dark mt-0 mb-2">
  <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main" style="height: calc(100vh - 100px); overflow-y: auto;">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link active" href="../index2.php">
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
        <span class="nav-link-text ms-1">Return Products</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-boxes text-danger text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Manage Products</span>
      </a>
    </li>
    
   <li class="nav-item">
      <a class="nav-link" href="addproducts.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-plus-square text-success text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Add Products</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="Manageadmin.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-user-shield text-info text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Manage Admin</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="users.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-users text-info text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Manage Users</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="pages/customers.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-user-friends text-primary text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Manage Store keepers</span>
      </a>
    </li>
        <li class="nav-item">
      <a class="nav-link" href="pages/customers.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-user-friends text-primary text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Manage Store keepers</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="register.html">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-user-plus text-success text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Register</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="customer_report.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-chart-bar text-primary text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Users Report</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="report.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-chart-line text-success text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Reports</span>
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
          <i class="fas fa-sign-out-alt text-danger text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Logout</span>
      </a>
    </li>
  </ul>
</div>
</aside>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
            </li>
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
            <li class="nav-item dropdown pe-2 d-flex align-items-center">
             
        </div>
      </div>
    </nav>
    <?php
include '../connection.php'; // Include your database connection file

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Fetch order details
    $query = "SELECT * FROM orders WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $order_result = $stmt->get_result();
    $order = $order_result->fetch_assoc();

    // Fetch order items
    $query = "SELECT * FROM order_items WHERE OrderID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $items_result = $stmt->get_result();
    $order_items = $items_result->fetch_all(MYSQLI_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $customer_id = $_POST['customer_id'];
    $user_id = $_POST['user_id'];
    $lpo = $_POST['lpo'];
    $address = $_POST['address'];
    $total_price = $_POST['total_price'];
    $payment_mode = $_POST['payment_mode'];

    // Update orders table
    $query = "UPDATE orders SET UserID = ?, CustomerID = ?, LPO = ?, Address = ?, TotalPrice = ?, PaymentMode = ? WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iissdsi", $user_id, $customer_id, $lpo, $address, $total_price, $payment_mode, $order_id);
    $stmt->execute();

    // Update order items
    foreach ($_POST['items'] as $item_id => $item) {
        $quantity = $item['quantity'];
        $price = $item['price'];

        $query = "UPDATE order_items SET Quantity = ?, Price = ? WHERE ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("idi", $quantity, $price, $item_id);
        $stmt->execute();
    }

    echo "<script>alert('Order updated successfully!'); window.location.href='../index2.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file -->
    <script>
        function calculateTotal() {
            let totalPrice = 0;
            const itemRows = document.querySelectorAll('.item-row');
            itemRows.forEach(row => {
                const quantity = row.querySelector('.quantity').value;
                const price = row.querySelector('.price').value;
                totalPrice += quantity * price;
            });
            document.getElementById('total_price').value = totalPrice.toFixed(2);
        }
    </script>
</head>
<body>
    <div class="container-fluid py-4 d-flex justify-content-center align-items-center min-vh-100">
        <div class="row w-100">
            <div class="col-lg-6 col-md-8 col-sm-10 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h6>Edit Order</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="order_id" value="<?= $order['ID'] ?>">

                            <div class="mb-3">
                                <label for="user_id">User ID:</label>
                                <input type="text" name="user_id" id="user_id" class="form-control" value="<?= $order['UserID'] ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="customer_id">Customer ID:</label>
                                <input type="text" name="customer_id" id="customer_id" class="form-control" value="<?= $order['CustomerID'] ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="lpo">LPO:</label>
                                <input type="text" name="lpo" id="lpo" class="form-control" value="<?= $order['LPO'] ?>">
                            </div>

                            <div class="mb-3">
                                <label for="address">Address:</label>
                                <input type="text" name="address" id="address" class="form-control" value="<?= $order['Address'] ?>">
                            </div>

                            <div class="mb-3">
                                <label for="total_price">Total Price:</label>
                                <input type="number" id="total_price" class="form-control" step="0.01" name="total_price" value="<?= $order['TotalPrice'] ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="payment_mode">Payment Mode:</label>
                                <input type="text" name="payment_mode" id="payment_mode" class="form-control" value="<?= $order['PaymentMode'] ?>" required>
                            </div>

                            <h3>Order Items</h3>
                            <?php foreach ($order_items as $item) { ?>
                                <div class="item-row mb-3">
                                    <input type="hidden" name="items[<?= $item['ID'] ?>][id]" value="<?= $item['ID'] ?>">

                                    <label>Quantity:</label>
                                    <input type="number" class="form-control quantity" name="items[<?= $item['ID'] ?>][quantity]" value="<?= $item['Quantity'] ?>" oninput="calculateTotal()" required><br>

                                    <label>Price:</label>
                                    <input type="number" class="form-control price" name="items[<?= $item['ID'] ?>][price]" value="<?= $item['Price'] ?>" oninput="calculateTotal()" required><br>
                                </div>
                            <?php } ?>

                            <div class="text-center">
                                <button type="submit" class="btn btn-dark w-100 my-4">Update Order</button>
                            </div>
                            <div class="text-center">
                                <a href="../index2.php" class="btn btn-light w-100 my-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


      <!-- <footer class="footer pt-3  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script><i class="fa fa-heart"></i>
                <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank"></a>
            
              </div>
            </div>
          </div>
        </div>
      </footer> -->
    </div>
  </main>
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="fa fa-cog py-2"> </i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3 ">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Argon Configurator</h5>
          <p>See our dashboard options.</p>
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