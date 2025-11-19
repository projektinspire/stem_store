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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/theme.css" />
  <link rel="stylesheet" href="../assets/css/custom-theme.css?v=20251118" />
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
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main" style="height: 100vh; position: fixed; overflow: hidden;">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="../index2.php" target="_blank">
        <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">STEM STORE</span>
      </a>
    </div>

    <hr class="horizontal dark mt-0 mb-2">

  <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main" style="height: calc(100vh - 100px); overflow-y: auto;">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="../index2.php">
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
      <a class="nav-link" href="products.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-boxes text-danger text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Manage Products</span>
      </a>
    </li>
    
    <li class="nav-item">
      <a class="nav-link " href="addproducts.php">
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
      <a class="nav-link" href="customers.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-user-friends text-primary text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">manage Store Keepers</span>
      </a>
    </li>
    
    <li class="nav-item">
      <a class="nav-link" href="register.php">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="fas fa-user-plus text-success text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Register</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link active" href="customer_report.php">
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
      <a class="nav-link" href="login.php">
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
        <!-- <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Tables</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Tables</h6>
        </nav> -->
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <ul class="navbar-nav  justify-content-end">
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

if (!$customersResult) {
    die("Error fetching customers: " . mysqli_error($conn));
}

$customerId = $_GET['customer_id'] ?? null;
$fromDate = $_GET['from_date'] ?? null;
$toDate = $_GET['to_date'] ?? null;

$ordersResult = null;
$paymentsResult = null;

if ($customerId) {
    // Query for orders
    $ordersQuery = "
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
    ";

    // Query for payments
    $paymentsQuery = "
    SELECT 
        Amount AS PaymentAdded, PaymentDate
    FROM payments
    WHERE CustomerID = ?
    ";

    $params = [$customerId];
    $types = 'i';

    if ($fromDate && $toDate) {
        $ordersQuery .= " AND o.AddedDate BETWEEN ? AND ?";
        $paymentsQuery .= " AND PaymentDate BETWEEN ? AND ?";
        $params[] = $fromDate;
        $params[] = $toDate;
        $types .= 'ss';
    }

    $ordersQuery .= " ORDER BY o.AddedDate DESC";
    $paymentsQuery .= " ORDER BY PaymentDate DESC";

    // Prepare and execute the orders query
    if ($stmt = mysqli_prepare($conn, $ordersQuery)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        if (mysqli_stmt_execute($stmt)) {
            $ordersResult = mysqli_stmt_get_result($stmt);
        } else {
            echo "Error executing orders query: " . mysqli_error($conn);
        }
    } else {
        echo "Error preparing orders query: " . mysqli_error($conn);
    }

    // Prepare and execute the payments query
    if ($stmt = mysqli_prepare($conn, $paymentsQuery)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        if (mysqli_stmt_execute($stmt)) {
            $paymentsResult = mysqli_stmt_get_result($stmt);
        } else {
            echo "Error executing payments query: " . mysqli_error($conn);
        }
    } else {
        echo "Error preparing payments query: " . mysqli_error($conn);
    }
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
            padding: 0.5rem;
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
        .highlight {
            background-color: #e0f7fa !important;
        }
        .payments-table {
            margin-top: 2rem;
            border-top: 2px solid #333;
        }
        .payments-table th {
            background-color: #e8f5e9;
        }
    </style>
</head>
<body>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Filter Store keeper Report</h6>
                    <form method="GET" action="">
                        <select name="customer_id" onchange="this.form.submit()" required>
                            <option value="">Select Store keeper</option>
                            <?php
                            while ($customer = mysqli_fetch_assoc($customersResult)) {
                                echo '<option value="' . $customer['CustomerID'] . '"' . 
                                     ($customerId == $customer['CustomerID'] ? ' selected' : '') . '>' . 
                                     htmlspecialchars($customer['CustomerName']) . '</option>';
                            }
                            ?>
                        </select>
                        
                        <?php if ($customerId): ?>
                            <div class="mt-3">
                                <label>From Date:</label>
                                <input type="date" name="from_date" value="<?= htmlspecialchars($fromDate) ?>">
                                <label>To Date:</label>
                                <input type="date" name="to_date" value="<?= htmlspecialchars($toDate) ?>">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        <?php endif; ?>
                    </form>

                    <?php if ($ordersResult || $paymentsResult): ?>
                        <div class="search-container mt-3">
                            <input type="text" id="searchInput" placeholder="Search by name or salesperson...">
                            <button id="download" class="btn btn-primary">Download Excel</button>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($ordersResult && mysqli_num_rows($ordersResult) > 0): ?>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0" id="orders-table">
                            <thead>
                                <tr>
                                    <th>Order No</th>
                                    <th>User</th>
                                    <th>Store keeper Name</th>
                                    <th>Product Details</th>
                                    <!-- <th>Total Price</th>
                                    <th>Payment Mode</th> -->
                                    <th>Order Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($ordersResult)): ?>
                                    <tr>
                                        <td>#<?= htmlspecialchars($row['OrderID']) ?></td>
                                        <td><?= htmlspecialchars($row['Sales']) ?></td>
                                        <td><?= htmlspecialchars($row['CustomerName']) ?></td>
                                        <td><?= htmlspecialchars($row['ProductName']) ?> - <?= htmlspecialchars($row['Quantity']) ?> @ Tsh <?= number_format($row['TotalPrice'], 2) ?></td>
                                        <!-- <td>Tsh <?= number_format($row['TotalPrice'] * $row['Quantity'], 2) ?></td>
                                        <td><?= htmlspecialchars($row['PaymentMode']) ?></td> -->
                                        <td><?= htmlspecialchars($row['OrderDate']) ?></td>
                                        <td><?= htmlspecialchars($row['Status']) ?></td>
                                        <!-- <td><?= htmlspecialchars($row['PaymentStatus']) ?></td> -->
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($paymentsResult && mysqli_num_rows($paymentsResult) > 0): ?>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 payments-table" id="payments-table">
                            <thead>
                                <tr>
                                    <th>Payment Amount</th>
                                    <th>Payment Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($paymentsResult)): ?>
                                    <tr>
                                        <td>Tsh <?= number_format($row['PaymentAdded'], 2) ?></td>
                                        <td><?= htmlspecialchars($row['PaymentDate']) ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ((!$ordersResult || mysqli_num_rows($ordersResult) == 0) && (!$paymentsResult || mysqli_num_rows($paymentsResult) == 0)): ?>
                    <p class="text-center mt-3">No orders found for this store keeper in the selected date range.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const addPaymentButton = document.getElementById("addPayment");
    const paymentAmountInput = document.getElementById("paymentAmount");
    const paymentDateInput = document.getElementById("paymentDate");
    const customerIdInput = document.getElementById("customerId");
    const paymentsTable = document.getElementById("payments-table")?.querySelector("tbody");

    addPaymentButton?.addEventListener("click", function () {
        const paymentAmount = parseFloat(paymentAmountInput.value.trim());
        const paymentDate = paymentDateInput.value;
        const customerId = customerIdInput.value;
        
        if (isNaN(paymentAmount) || paymentAmount <= 0) {
            alert("Please enter a valid payment amount.");
            return;
        }
        
        if (!paymentDate) {
            alert("Please select a payment date.");
            return;
        }

        // Show loading state
        addPaymentButton.disabled = true;
        addPaymentButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...';

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "add_payment.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                addPaymentButton.disabled = false;
                addPaymentButton.textContent = "Add Payment";
                
                if (xhr.status === 200) {
                    // Add the new payment to the table without reloading
                    if (paymentsTable) {
                        const newRow = paymentsTable.insertRow(0);
                        newRow.classList.add("highlight");
                        newRow.insertCell(0).textContent = `Tsh ${paymentAmount.toFixed(2)}`;
                        newRow.insertCell(1).textContent = paymentDate;
                        
                        // Remove highlight after 2 seconds
                        setTimeout(() => {
                            newRow.classList.remove("highlight");
                        }, 2000);
                    }
                    
                    alert("Payment added successfully!");
                    paymentAmountInput.value = "";
                } else {
                    alert("Error adding payment: " + xhr.responseText);
                }
            }
        };

        xhr.send(`customer_id=${customerId}&amount=${paymentAmount}&date=${paymentDate}`);
    });

    document.getElementById("download")?.addEventListener("click", function () {
        const data = [];
        const headers = [
            "Order No", "Sales", "Customer Name", "Product Details", "Total Price", 
            "Payment Mode", "Order Date", "Status", "Payment Status", 
            "Payment Amount", "Payment Date"
        ];
        data.push(headers);
        
        let totalOrders = 0;
        let totalPayments = 0;

        const ordersTable = document.getElementById("orders-table");
        if (ordersTable) {
            ordersTable.querySelectorAll("tbody tr").forEach(row => {
                const rowData = Array.from(row.querySelectorAll("td")).map(td => td.textContent);
                totalOrders += parseFloat(rowData[4].replace('Tsh ', '').replace(',', '')) || 0;
                rowData.push('', '');
                data.push(rowData);
            });
        }

        const paymentsTable = document.getElementById("payments-table");
        if (paymentsTable) {
            paymentsTable.querySelectorAll("tbody tr").forEach(row => {
                const cells = row.querySelectorAll("td");
                const paymentAmount = cells[0].textContent;
                const paymentDate = cells[1].textContent;
                totalPayments += parseFloat(paymentAmount.replace('Tsh ', '').replace(',', '')) || 0;
                
                const paymentRow = new Array(headers.length - 2).fill('');
                paymentRow.push(paymentAmount, paymentDate);
                data.push(paymentRow);
            });
        }

        data.push(new Array(headers.length).fill(''));
        data.push(["Total Paid", "", "", "", "", "", "", "", "", `Tsh ${totalPayments.toFixed(2)}`, ""]);
        data.push(["Total Unpaid", "", "", "", "", "", "", "", "", `Tsh ${(totalOrders - totalPayments).toFixed(2)}`, ""]);

        const worksheet = XLSX.utils.aoa_to_sheet(data);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, "Customer Report");
        
        XLSX.writeFile(workbook, "Customer_Report.xlsx");
    });

    document.getElementById("searchInput")?.addEventListener("input", function () {
        const searchValue = this.value.trim().toLowerCase();
        document.querySelectorAll("#orders-table tbody tr, #payments-table tbody tr").forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(searchValue) ? "" : "none";
        });
    });
});
</script>

</body>
</html>
<!-- 
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
      </footer> -->
    </div>
  </main>
  
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
