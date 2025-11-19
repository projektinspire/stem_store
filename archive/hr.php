<?php
session_start();
include 'connection.php';

$sql1="SELECT * FROM users";
$result1 = $conn->query($sql1);

// Debugging: Check session user_id
if (isset($_SESSION['user_id'])) {
    error_log("Index Page, User ID: " . $_SESSION['user_id']);
} else {
    error_log("User not logged in");
}
?>

<?php 
include 'connection.php';

// Check if the user is logged in; if not, redirect to the login page
$userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;

if (!isset($_SESSION['user_id'])) {
    header("Location: pages/login.php");
    exit(); // Ensure the script stops executing after the redirect
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/white.png">
  <title>
  POS
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
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
</head>
<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="index2.php" target="_blank">
        <img src="./assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">POS</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
<div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link active" href="index2.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-tachometer-alt text-primary text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="pages/sales.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-hand-holding-usd text-warning text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Sales</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="pages/products.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
        <i class="fas fa-building text-danger text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Manage Products </span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="pages/addproducts.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
       <i class="fas fa-building text-danger text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Add Products </span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="pages/Manageadmin.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
        <i class="fas fa-users-cog text-info text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Manage admin</span>
      </a>
    </li>
        <li class="nav-item">
      <a class="nav-link" href="pages/Manageadmin.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
        <i class="fas fa-users-cog text-info text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Manage Users</span>
      </a>
    </li>
    <li class="nav-item"> 
    <a class="nav-link" href="pages/customers.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"> 
            <i class="fas fa-users text-info text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Manage Customers</span>
    </a>
</li>
    <li class="nav-item">
      <a class="nav-link" href="pages/register.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-user-plus text-success text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Register</span>
      </a>
    <li class="nav-item">
      <a class="nav-link" href="pages/report.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-user text-dark text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Profile</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="pages/invoices.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-file-invoice-dollar text-success text-sm opacity-10"></i>
        </div>
       <span class="nav-link-text ms-1">Proforma Invoices</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="pages/report.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-file-invoice-dollar text-success text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Reports</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="pages/login.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-user-plus text-info text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Log Out</span>
      </a>
    </li>
  </ul>
</div>
    <div class="sidenav-footer mx-3 ">
      <div class="card card-plain shadow-none" id="sidenavCard">
        <img class="w-50 mx-auto" src="./assets/img/illustrations/icon-documentation.svg" alt="sidebar_illustration">
        <div class="card-body text-center p-3 w-100 pt-0">
          <div class="docs-info">
            <h6 class="mb-0">Need help?</h6>
            <p class="text-xs font-weight-bold mb-0">Please check our docs</p>
          </div>
        </div>
      </div>
      <a href="" target="_blank" class="btn btn-dark btn-sm w-100 mb-3">Documentation</a>
      <a class="btn btn-primary btn-sm mb-0 w-100" href="" type="button">Upgrade to pro</a>
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
            <div class="input-group">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" class="form-control" placeholder="Type here...">
            </div>
          </div>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">Log Out</span>
              </a>
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
              <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
               <i class="fa fa-shopping-cart text-white"></i>
              </a>
             <ul class="dropdown-menu cart-dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
  <!-- Cart Summary -->
  <li class="cart-summary mb-2">
<!-- Customer Section -->
<div class="cart-header d-flex justify-content-between align-items-center mb-2">
  <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#addCustomerModal">+ Add Customer</button>
  <div class="cart-icons">
    <!-- Cart icon -->
    <i class="fa fa-shopping-cart text-primary"></i>
    <!-- Search icon -->
    <i class="fa fa-search text-primary"></i>
  </div>
</div>
<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCustomerModalLabel">Add Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addCustomerForm">
          <div class="form-group">
            <label for="customerName">Customer Name</label>
            <input type="text" class="form-control" id="customerName" required>
          </div>
          <div class="form-group">
            <label for="customerEmail">Email</label>
            <input type="email" class="form-control" id="customerEmail" required>
          </div>
          <div class="form-group">
            <label for="customerPhone">Phone</label>
            <input type="tel" class="form-control" id="customerPhone" required>
          </div>
          <div class="form-group">
            <label for="customerAddress">Address</label>
            <textarea class="form-control" id="customerAddress" rows="3" required></textarea>
          </div>
          <div class="form-group">
            <label for="customerNotes">Notes</label>
            <textarea class="form-control" id="customerNotes" rows="3"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveCustomerButton">Save Customer</button>
      </div>
    </div>
  </div>
</div>


    <!-- Cart Items List (Scrollable) -->
    <ul class="cart-items list-group mb-3">
      <!-- Cart Item 1 -->
      <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="cart-item-details">
          <p class="mb-0">1 Schezwan Egg Noodles</p>
          <p class="text-muted">$25.00</p>
        </div>
        <i class="fa fa-times text-danger"></i>
      </li>

      <!-- Cart Item 2 with discount -->
      <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="cart-item-details">
          <p class="mb-0">2 Spicy Shrimp Soup</p>
          <small class="text-muted">Medium - Half Grilled</small>
          <p class="text-muted">$40.00 <del>$50.00</del></p>
        </div>
        <i class="fa fa-times text-danger"></i>
      </li>

      <!-- Editable Item with quantity and discount -->
      <li class="list-group-item">
        <div class="d-flex justify-content-between">
          <div>
            <p class="mb-0">1 Thai Style Fried Noodles</p>
            <small class="text-muted">Medium</small>
            <p class="text-muted">$40.00 <del>$50.00</del></p>
          </div>
          <i class="fa fa-times text-danger"></i>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-2">
          <div>
            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" value="1" class="form-control form-control-sm">
          </div>
          <div>
            <label for="discount">Discount (%)</label>
            <input type="number" id="discount" value="20" class="form-control form-control-sm">
          </div>
        </div>
      </li>

      <!-- Cart Item 3 -->
      <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="cart-item-details">
          <p class="mb-0">3 Fried Basil</p>
          <p class="text-muted">$75.00</p>
        </div>
        <i class="fa fa-times text-danger"></i>
      </li>
    </ul>

    <!-- Cart Summary -->
    <div class="cart-summary-section bg-light p-2 mb-2">
      <button class="btn btn-link btn-sm">Coupon Code</button>
      <button class="btn btn-link btn-sm">Note</button>
    </div>

    <!-- Subtotal, Tax, and Payable Amount -->
    <div class="cart-totals d-flex flex-column">
      <div class="d-flex justify-content-between">
        <p>Subtotal</p>
        <p>$200.00</p>
      </div>
      <div class="d-flex justify-content-between">
        <p>Tax</p>
        <p>$45.00</p>
      </div>
      <div class="d-flex justify-content-between fw-bold">
        <p>Payable Amount</p>
        <p>$195.00</p>
      </div>
    </div>

    <!-- Cart Action Buttons -->
    <div class="cart-actions d-flex justify-content-between">
      <button class="btn btn-warning btn-sm">Hold Order</button>
      <button class="btn btn-success btn-sm">Proceed</button>
    </div>
  </li>
</ul>

            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Today's Money</p>
                    <h5 class="font-weight-bolder">
                      Tsh 53,000
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
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
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Today's Users</p>
                    <h5 class="font-weight-bolder">
                      2,300
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
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
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">New Clients</p>
                    <h5 class="font-weight-bolder">
                      3,462
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
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
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Sales</p>
                    <h5 class="font-weight-bolder">
                      Tsh 103,430
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
<div class="container py-4">
  <div class="row">
    <div class="col-12">
      <div class="row">
        <!-- Repeat this block for each product -->
        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4"> <!-- Adjusted grid sizes for smaller cards -->
          <div class="card h-100" style="max-width: 150px;"> <!-- Limiting card width -->
            <img src="product-image.jpg" class="card-img-top" alt="Product Name" style="height: 100px; object-fit: cover;"> <!-- Smaller image size -->
            <div class="card-body p-2"> <!-- Reduced padding -->
              <h6 class="card-title" style="font-size: 0.9rem;">Schezwan Egg </h6> <!-- Smaller title -->
              <p class="card-text" style="font-size: 0.8rem;">Tsh 55,000</p> <!-- Changed to Tsh -->
              <button class="btn btn-primary btn-sm" onclick="addToCart('Schezwan Egg Noodles', 55000)">Add</button> <!-- Updated value -->
            </div>
          </div>
        </div>
        <!-- Repeat for each additional product -->
        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4"> 
          <div class="card h-100" style="max-width: 150px;">
            <img src="product-image.jpg" class="card-img-top" alt="Product Name" style="height: 100px; object-fit: cover;">
            <div class="card-body p-2">
              <h6 class="card-title" style="font-size: 0.9rem;">Spicy Shrimp</h6>
              <p class="card-text" style="font-size: 0.8rem;">Tsh 60,000</p> <!-- Changed to Tsh -->
              <button class="btn btn-primary btn-sm" onclick="addToCart('Spicy Shrimp Soup', 60000)">Add</button> <!-- Updated value -->
            </div>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4"> 
          <div class="card h-100" style="max-width: 150px;">
            <img src="product-image.jpg" class="card-img-top" alt="Product Name" style="height: 100px; object-fit: cover;">
            <div class="card-body p-2">
              <h6 class="card-title" style="font-size: 0.9rem;">Thai Style Fried</h6>
              <p class="card-text" style="font-size: 0.8rem;">Tsh 48,000</p> <!-- Changed to Tsh -->
              <button class="btn btn-primary btn-sm" onclick="addToCart('Thai Style Fried Noodles', 48000)">Add</button> <!-- Updated value -->
            </div>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4"> 
          <div class="card h-100" style="max-width: 150px;">
            <img src="product-image.jpg" class="card-img-top" alt="Product Name" style="height: 100px; object-fit: cover;">
            <div class="card-body p-2">
              <h6 class="card-title" style="font-size: 0.9rem;">Fried Basil</h6>
              <p class="card-text" style="font-size: 0.8rem;">Tsh 75,000</p> <!-- Changed to Tsh -->
              <button class="btn btn-primary btn-sm" onclick="addToCart('Fried Basil', 75000)">Add</button> <!-- Updated value -->
            </div>
          </div>
        </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4"> 
          <div class="card h-100" style="max-width: 150px;">
            <img src="product-image.jpg" class="card-img-top" alt="Product Name" style="height: 100px; object-fit: cover;">
            <div class="card-body p-2">
              <h6 class="card-title" style="font-size: 0.9rem;">Fried Basil</h6>
              <p class="card-text" style="font-size: 0.8rem;">Tsh 75,000</p> <!-- Changed to Tsh -->
              <button class="btn btn-primary btn-sm" onclick="addToCart('Fried Basil', 75000)">Add</button> <!-- Updated value -->
            </div>
          </div>
        </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4"> 
          <div class="card h-100" style="max-width: 150px;">
            <img src="product-image.jpg" class="card-img-top" alt="Product Name" style="height: 100px; object-fit: cover;">
            <div class="card-body p-2">
              <h6 class="card-title" style="font-size: 0.9rem;">Fried Basil</h6>
              <p class="card-text" style="font-size: 0.8rem;">Tsh 75,000</p> <!-- Changed to Tsh -->
              <button class="btn btn-primary btn-sm" onclick="addToCart('Fried Basil', 75000)">Add</button> <!-- Updated value -->
            </div>
          </div>
        </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4"> 
          <div class="card h-100" style="max-width: 150px;">
            <img src="product-image.jpg" class="card-img-top" alt="Product Name" style="height: 100px; object-fit: cover;">
            <div class="card-body p-2">
              <h6 class="card-title" style="font-size: 0.9rem;">Fried Basil</h6>
              <p class="card-text" style="font-size: 0.8rem;">Tsh 75,000</p> <!-- Changed to Tsh -->
              <button class="btn btn-primary btn-sm" onclick="addToCart('Fried Basil', 75000)">Add</button> <!-- Updated value -->
            </div>
          </div>
        </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4"> 
          <div class="card h-100" style="max-width: 150px;">
            <img src="product-image.jpg" class="card-img-top" alt="Product Name" style="height: 100px; object-fit: cover;">
            <div class="card-body p-2">
              <h6 class="card-title" style="font-size: 0.9rem;">Fried Basil</h6>
              <p class="card-text" style="font-size: 0.8rem;">Tsh 75,000</p> <!-- Changed to Tsh -->
              <button class="btn btn-primary btn-sm" onclick="addToCart('Fried Basil', 75000)">Add</button> <!-- Updated value -->
            </div>
          </div>
        </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4"> 
          <div class="card h-100" style="max-width: 150px;">
            <img src="product-image.jpg" class="card-img-top" alt="Product Name" style="height: 100px; object-fit: cover;">
            <div class="card-body p-2">
              <h6 class="card-title" style="font-size: 0.9rem;">Fried Basil</h6>
              <p class="card-text" style="font-size: 0.8rem;">Tsh 75,000</p> <!-- Changed to Tsh -->
              <button class="btn btn-primary btn-sm" onclick="addToCart('Fried Basil', 75000)">Add</button> <!-- Updated value -->
            </div>
          </div>
        </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4"> 
          <div class="card h-100" style="max-width: 150px;">
            <img src="product-image.jpg" class="card-img-top" alt="Product Name" style="height: 100px; object-fit: cover;">
            <div class="card-body p-2">
              <h6 class="card-title" style="font-size: 0.9rem;">Fried Basil</h6>
              <p class="card-text" style="font-size: 0.8rem;">Tsh 75,000</p> <!-- Changed to Tsh -->
              <button class="btn btn-primary btn-sm" onclick="addToCart('Fried Basil', 75000)">Add</button> <!-- Updated value -->
            </div>
          </div>
        </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4"> 
          <div class="card h-100" style="max-width: 150px;">
            <img src="product-image.jpg" class="card-img-top" alt="Product Name" style="height: 100px; object-fit: cover;">
            <div class="card-body p-2">
              <h6 class="card-title" style="font-size: 0.9rem;">Fried Basil</h6>
              <p class="card-text" style="font-size: 0.8rem;">Tsh 75,000</p> <!-- Changed to Tsh -->
              <button class="btn btn-primary btn-sm" onclick="addToCart('Fried Basil', 75000)">Add</button> <!-- Updated value -->
            </div>
          </div>
        </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4"> 
          <div class="card h-100" style="max-width: 150px;">
            <img src="product-image.jpg" class="card-img-top" alt="Product Name" style="height: 100px; object-fit: cover;">
            <div class="card-body p-2">
              <h6 class="card-title" style="font-size: 0.9rem;">Fried Basil</h6>
              <p class="card-text" style="font-size: 0.8rem;">Tsh 75,000</p> <!-- Changed to Tsh -->
              <button class="btn btn-primary btn-sm" onclick="addToCart('Fried Basil', 75000)">Add</button> <!-- Updated value -->
            </div>
          </div>
        </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4"> 
          <div class="card h-100" style="max-width: 150px;">
            <img src="product-image.jpg" class="card-img-top" alt="Product Name" style="height: 100px; object-fit: cover;">
            <div class="card-body p-2">
              <h6 class="card-title" style="font-size: 0.9rem;">Fried Basil</h6>
              <p class="card-text" style="font-size: 0.8rem;">Tsh 75,000</p> <!-- Changed to Tsh -->
              <button class="btn btn-primary btn-sm" onclick="addToCart('Fried Basil', 75000)">Add</button> <!-- Updated value -->
            </div>
          </div>
        </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4"> 
          <div class="card h-100" style="max-width: 150px;">
            <img src="product-image.jpg" class="card-img-top" alt="Product Name" style="height: 100px; object-fit: cover;">
            <div class="card-body p-2">
              <h6 class="card-title" style="font-size: 0.9rem;">Fried Basil</h6>
              <p class="card-text" style="font-size: 0.8rem;">Tsh 75,000</p> <!-- Changed to Tsh -->
              <button class="btn btn-primary btn-sm" onclick="addToCart('Fried Basil', 75000)">Add</button> <!-- Updated value -->
            </div>
          </div>
        </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4"> 
          <div class="card h-100" style="max-width: 150px;">
            <img src="product-image.jpg" class="card-img-top" alt="Product Name" style="height: 100px; object-fit: cover;">
            <div class="card-body p-2">
              <h6 class="card-title" style="font-size: 0.9rem;">Fried Basil</h6>
              <p class="card-text" style="font-size: 0.8rem;">Tsh 75,000</p> <!-- Changed to Tsh -->
              <button class="btn btn-primary btn-sm" onclick="addToCart('Fried Basil', 75000)">Add</button> <!-- Updated value -->
            </div>
          </div>
        </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4"> 
          <div class="card h-100" style="max-width: 150px;">
            <img src="product-image.jpg" class="card-img-top" alt="Product Name" style="height: 100px; object-fit: cover;">
            <div class="card-body p-2">
              <h6 class="card-title" style="font-size: 0.9rem;">Fried Basil</h6>
              <p class="card-text" style="font-size: 0.8rem;">Tsh 75,000</p> <!-- Changed to Tsh -->
              <button class="btn btn-primary btn-sm" onclick="addToCart('Fried Basil', 75000)">Add</button> <!-- Updated value -->
            </div>
          </div>
        </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4"> 
          <div class="card h-100" style="max-width: 150px;">
            <img src="product-image.jpg" class="card-img-top" alt="Product Name" style="height: 100px; object-fit: cover;">
            <div class="card-body p-2">
              <h6 class="card-title" style="font-size: 0.9rem;">Fried Basil</h6>
              <p class="card-text" style="font-size: 0.8rem;">Tsh 75,000</p> <!-- Changed to Tsh -->
              <button class="btn btn-primary btn-sm" onclick="addToCart('Fried Basil', 75000)">Add</button> <!-- Updated value -->
            </div>
          </div>
        </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4"> 
          <div class="card h-100" style="max-width: 150px;">
            <img src="product-image.jpg" class="card-img-top" alt="Product Name" style="height: 100px; object-fit: cover;">
            <div class="card-body p-2">
              <h6 class="card-title" style="font-size: 0.9rem;">Fried Basil</h6>
              <p class="card-text" style="font-size: 0.8rem;">Tsh 75,000</p> <!-- Changed to Tsh -->
              <button class="btn btn-primary btn-sm" onclick="addToCart('Fried Basil', 75000)">Add</button> <!-- Updated value -->
            </div>
          </div>
        </div>
        <!-- End of product block -->
      </div>
    </div>
  </div>
</div>

<script>
function addToCart(productName, price) {
  alert(`${productName} has been added to your cart at Tsh${price}`);
}
</script>

        <!--/* <div class="col-lg-5">
          <div class="card">
            <div class="card-header pb-0 p-3">
              <h6 class="mb-0">Categories</h6>
            </div>
            <div class="card-body p-3">
              <ul class="list-group">
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex align-items-center">
                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                      <i class="ni ni-mobile-button text-white opacity-10"></i>
                    </div>
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm">Devices</h6>
                      <span class="text-xs">250 in stock, <span class="font-weight-bold">346+ sold</span></span>
                    </div>
                  </div>
                  <div class="d-flex">
                    <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
                  </div>
                </li>
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex align-items-center">
                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                      <i class="ni ni-tag text-white opacity-10"></i>
                    </div>
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm">Tickets</h6>
                      <span class="text-xs">123 closed, <span class="font-weight-bold">15 open</span></span>
                    </div>
                  </div>
                  <div class="d-flex">
                    <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
                  </div>
                </li>
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex align-items-center">
                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                      <i class="ni ni-box-2 text-white opacity-10"></i>
                    </div>
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm">Error logs</h6>
                      <span class="text-xs">1 is active, <span class="font-weight-bold">40 closed</span></span>
                    </div>
                  </div>
                  <div class="d-flex">
                    <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
                  </div>
                </li>
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
                  <div class="d-flex align-items-center">
                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                      <i class="ni ni-satisfied text-white opacity-10"></i>
                    </div>
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm">Happy users</h6>
                      <span class="text-xs font-weight-bold">+ 430</span>
                    </div>
                  </div>
                  <div class="d-flex">
                    <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div> */-->
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
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="./assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>