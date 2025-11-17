
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
</head>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href=" ../index2.php " target="_blank">
        <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">POS</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
<div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="dashboard.php">
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
  <a class="nav-link" href="">
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
    <div class="sidenav-footer mx-3 ">
      <div class="card card-plain shadow-none" id="sidenavCard">
        <img class="w-50 mx-auto" src="../assets/img/illustrations/icon-documentation.svg" alt="sidebar_illustration">
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
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Tables</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Tables</h6>
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
                <span class="d-sm-inline d-none">Sign In</span>
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
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <?php
include '../connection.php';

// Fetch all customers for the dropdown
$customersQuery = "SELECT CustomerID, CustomerName FROM customers";
$customersResult = mysqli_query($conn, $customersQuery);

if (isset($_GET['customer_id'])) {
    $customerId = $_GET['customer_id'];

    // Fetch orders for the selected customer
    $query = "
        SELECT 
            o.ID AS OrderID, u.username AS Sales, c.CustomerName, 
            oi.Quantity, p.ProductName, oi.Price AS TotalPrice, 
            o.MobileProvider, o.PaymentMode, o.AddedDate AS OrderDate, 
            o.PaymentStatus, o.Status
        FROM orders o
        JOIN users u ON o.UserID = u.id 
        JOIN customers c ON o.CustomerID = c.CustomerID 
        JOIN order_items oi ON o.ID = oi.OrderID 
        JOIN products p ON oi.ProductID = p.ID 
        WHERE o.CustomerID = ?
        ORDER BY o.AddedDate DESC
    ";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $customerId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $result = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Report</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <style>
        .table th, .table td {
            font-size: 0.8rem;
        }
        .search-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .search-container input {
            width: 300px;
            padding: 5px;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Select Customer</h6>
                    <form method="GET" action="">
                        <select name="customer_id" onchange="this.form.submit()" required>
                            <option value="">Select Customer</option>
                            <?php
                            while ($customer = mysqli_fetch_assoc($customersResult)) {
                                echo '<option value="' . $customer['CustomerID'] . '">' . 
                                     htmlspecialchars($customer['CustomerName']) . '</option>';
                            }
                            ?>
                        </select>
                    </form>

                    <?php if ($result): ?>
                        <div class="search-container mt-3">
                            <input type="text" id="searchInput" placeholder="Search by name or salesperson...">
                            <button id="download" class="btn btn-primary">Download Excel</button>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0" id="customer-table">
                            <thead>
                                <tr>
                                    <th>Order No</th>
                                    <th>Sales</th>
                                    <th>Customer Name</th>
                                    <th>Product Details</th>
                                    <th>Total Price</th>
                                    <th>Mobile Provider</th>
                                    <th>Payment Mode</th>
                                    <th>Order Date</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td>#<?= htmlspecialchars($row['OrderID']) ?></td>
                                        <td><?= htmlspecialchars($row['Sales']) ?></td>
                                        <td><?= htmlspecialchars($row['CustomerName']) ?></td>
                                        <td><?= htmlspecialchars($row['ProductName']) ?> - <?= htmlspecialchars($row['Quantity']) ?> @ Tsh <?= number_format($row['TotalPrice'], 2) ?></td>
                                        <td>Tsh <?= number_format($row['TotalPrice'] * $row['Quantity'], 2) ?></td>
                                        <td><?= htmlspecialchars($row['MobileProvider']) ?></td>
                                        <td><?= htmlspecialchars($row['PaymentMode']) ?></td>
                                        <td><?= htmlspecialchars($row['OrderDate']) ?></td>
                                        <td><?= htmlspecialchars($row['Status']) ?></td>
                                        <td><?= htmlspecialchars($row['PaymentStatus']) ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php elseif ($result): ?>
                    <p class="text-center mt-3">No orders found for this customer.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    // Enhanced search function to filter by both customer and salesperson names
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchValue = this.value.trim().toLowerCase();
        const rows = document.querySelectorAll('#customer-table tbody tr');

        rows.forEach(row => {
            const salesName = row.cells[1].innerText.trim().toLowerCase();
            const customerName = row.cells[2].innerText.trim().toLowerCase();

            if (salesName.includes(searchValue) || customerName.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Excel download function
    document.getElementById("download")?.addEventListener("click", function() {
        const data = [];
        const headers = ["Order No", "Sales", "Customer Name", "Product Details", "Total Price", "Mobile Provider", "Payment Mode", "Order Date", "Status", "Payment Status"];
        data.push(headers);

        let paidTotal = 0;
        let unpaidTotal = 0;

        const rows = document.querySelectorAll("#customer-table tbody tr");
        rows.forEach(row => {
            const rowData = [];
            const cells = row.querySelectorAll("td");
            let paymentStatus = "";

            cells.forEach((cell, index) => {
                const value = cell.innerText;
                rowData.push(value);

                if (index === 4) { 
                    const total = parseFloat(value.replace(/[^0-9.-]+/g, ''));
                    paymentStatus = cells[9].innerText;

                    if (paymentStatus === "Paid") {
                        paidTotal += total;
                    } else if (paymentStatus === "Unpaid") {
                        unpaidTotal += total;
                    }
                }
            });
            data.push(rowData);
        });

        data.push(["", "", "", "", `Paid Total: Tsh ${paidTotal.toFixed(2)}`, "", "", "", "", ""]);
        data.push(["", "", "", "", `Unpaid Total: Tsh ${unpaidTotal.toFixed(2)}`, "", "", "", "", ""]);

        const worksheet = XLSX.utils.aoa_to_sheet(data);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, "Customer Report");

        XLSX.writeFile(workbook, "Customer_Report.xlsx");
    });
</script>

</body>
</html>


      <footer class="footer pt-3  ">
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