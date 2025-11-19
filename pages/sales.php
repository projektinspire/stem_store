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


<style>
  
              .search-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 10px;
        }
        #searchInput, #startDate, #endDate {
            padding: 8px;
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            position: relative;
        }
        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
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
            background-color: #e9ecef;
            color: #495057;
            z-index: 10;
            box-shadow: 0 2px 3px rgba(0,0,0,0.1);
            padding: 12px 10px;
            font-weight: 600;
            border-bottom: 2px solid #f0f0f0;
        }
        .toggle-items {
            color: #5e72e4;
            margin-left: 5px;
            font-size: 16px;
            font-weight: bold;
        }
        .order-link {
            color: #5e72e4;
            text-decoration: none;
            font-weight: bold;
        }
        .order-link:hover {
            text-decoration: underline;
        }
        #extra-items-container {
            margin-top: 8px;
            padding-left: 10px;
            border-left: 2px solid #eee;
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
        .table thead tr {
            background-color: white;
        }
        .sticky-header {
            position: sticky;
            top: 0;
            background-color: white;
            z-index: 100;
        }
    </style>
</head>

<body class="g-sidenav-show g-sidenav-pinned  bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl fixed-start ms-4" id="sidenav-main" style="height: 100vh; position: fixed; top: 0; bottom: 0; overflow: hidden;">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="../index2.php" target="_blank">
      <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
      <span class="ms-1 font-weight-bold">STEM STORE</span>
    </a>
  </div>

  <hr class="horizontal dark mt-0 mb-2">

  <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main" style="overflow: hidden;">
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
        <a class="nav-link active" href="">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-hand-holding-usd text-warning text-sm opacity-10"></i>
          </div>
         <span class="nav-link-text ms-1">Return Products</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="../pages/products.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-boxes text-danger text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Manage Products</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="../pages/addproducts.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-plus-square text-success text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Add Products</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="../pages/Manageadmin.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-user-shield text-info text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Manage Admin</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="../pages/users.php">
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
        <a class="nav-link" href="../pages/register.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-user-plus text-success text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Register</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="../pages/customer_report.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-chart-bar text-primary text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Users Report</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="../pages/report.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-chart-line text-success text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Reports</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="../pages/profile.php">
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
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <?php
include '../connection.php';

// Check if tax is included in the total
$includeTax = isset($_GET['includeTax']) && $_GET['includeTax'] == '1';
$taxRate = 0.18;

// Get search input
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query to fetch order data
$query = "
    SELECT 
        o.ID AS OrderID, u.username AS UserName, c.CustomerName, oi.Quantity, 
        p.ProductName, oi.Price AS OrderedPrice, o.TotalPrice, o.PaymentMode, o.AddedDate,
        o.PaymentStatus, o.Status, o.LPO, o.Address
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
            'PaymentMode' => $row['PaymentMode'],
            'AddedDate' => $row['AddedDate'],
            'PaymentStatus' => $row['PaymentStatus'],
            'Status' => $row['Status'] ?: 'Pending',
            'TotalPrice' => $row['TotalPrice'],
            'LPO' => $row['LPO'],
            'Address' => $row['Address'],
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
    font-size: 0.8rem;
}
.form-inline .form-control {
    width: 250px;
}
.more-items-toggle {
    font-size: 1.2rem;
    font-weight: bold;
    color: black;
    cursor: pointer;
    margin-left: 5px;
}
</style>

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <div class="d-flex justify-content-between align-items-center">
            <h6 class="mb-0">All Orders</h6>
            <form method="GET" action="" class="form-inline d-flex orders-search-form">
              <input id="orderSearchInput" type="text" name="search" placeholder="Search Order No" aria-label="Search Order No"
                     value="<?= htmlspecialchars($search) ?>" class="form-control me-2" autocomplete="off">
              <input type="hidden" name="includeTax" value="<?= $includeTax ? '1' : '0' ?>">
              <button type="submit" class="btn btn-primary">Search</button>
              <?php if ($search): ?>
                <a href="?" class="btn btn-secondary ms-2">Clear</a>
              <?php endif; ?>
            </form>
          </div>
        </div>
        <script>
          // Live filter (no refresh): filters rows by Order No on typing
          document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('.orders-search-form');
            const input = document.getElementById('orderSearchInput');
            const tbody = document.getElementById('ordersTableBody') || document.querySelector('.table.align-items-center tbody');
            if (!input || !tbody) return;

            const NO_ROW_ID = 'ordersNoRows';
            function ensureNoRowsRow() {
              let row = document.getElementById(NO_ROW_ID);
              if (!row) {
                row = document.createElement('tr');
                row.id = NO_ROW_ID;
                const td = document.createElement('td');
                td.colSpan = 10;
                td.className = 'text-center py-4';
                td.innerHTML = '<div class="text-center"><i class="fas fa-inbox fa-3x text-muted mb-3"></i><h6 class="text-muted">No orders found</h6></div>';
                row.appendChild(td);
                row.style.display = 'none';
                tbody.appendChild(row);
              }
              return row;
            }

            function applyFilter() {
              const val = (input.value || '').trim().replace(/^#/,'').toLowerCase();
              const rows = Array.from(tbody.querySelectorAll('tr'))
                .filter(r => r.id !== NO_ROW_ID);
              let visible = 0;
              rows.forEach(row => {
                const id = (row.dataset.orderId || '').toLowerCase();
                const show = val.length >= 2 ? id.includes(val) : true;
                row.style.display = show ? '' : 'none';
                if (show) visible++;
              });
              const emptyRow = ensureNoRowsRow();
              emptyRow.style.display = visible === 0 ? '' : 'none';
            }

            input.addEventListener('input', function () { applyFilter(); });
            form?.addEventListener('submit', function (e) { e.preventDefault(); applyFilter(); });

            // Initial pass
            applyFilter();
          });
        </script>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead class="sticky-header">
                <tr>
                  <th>Order No</th>
                  <th>User Name</th>
                  <th>Store Keeper Name</th>
                  <th>Product Details</th>
                  <th>Order Date</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="ordersTableBody">
                <?php if (count($orders) > 0): ?>
                    <?php foreach ($orders as $order): ?>
                        <tr data-order-id="<?= $order['OrderID'] ?>">
                            <td>
                                <a href="#" class="text-primary fw-bold order-link" data-order-id="<?= $order['OrderID'] ?>">
                                    #<?= htmlspecialchars($order['OrderID']) ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($order['UserName']) ?></td>
                            <td><?= htmlspecialchars($order['CustomerName']) ?></td>
                            <td>
                                <?php if (count($order['Items']) > 1): ?>
                                    <div>
                                        <?= htmlspecialchars($order['Items'][0]['ProductName']) ?> -
                                        <?= htmlspecialchars($order['Items'][0]['Quantity']) ?> @ Tsh
                                        <?= number_format($order['Items'][0]['OrderedPrice'], 2) ?>
                                        <span class="text-primary toggle-items" data-order-id="<?= $order['OrderID'] ?>" style="cursor: pointer; font-weight: bold;">...</span>
                                    </div>
                                    <div id="extra-items-<?= $order['OrderID'] ?>" style="display: none; margin-top: 8px; padding-left: 10px; border-left: 2px solid #eee;">
                                        <?php for ($i = 1; $i < count($order['Items']); $i++): ?>
                                            <div style="margin-bottom: 4px;">
                                                <?= htmlspecialchars($order['Items'][$i]['ProductName']) ?> -
                                                <?= htmlspecialchars($order['Items'][$i]['Quantity']) ?> @ Tsh
                                                <?= number_format($order['Items'][$i]['OrderedPrice'], 2) ?>
                                            </div>
                                        <?php endfor; ?>
                                    </div>
                                <?php else: ?>
                                    <?= htmlspecialchars($order['Items'][0]['ProductName']) ?> -
                                    <?= htmlspecialchars($order['Items'][0]['Quantity']) ?> @ Tsh
                                    <?= number_format($order['Items'][0]['OrderedPrice'], 2) ?>
                                <?php endif; ?>
                            </td>                            
                            <td><?= htmlspecialchars($order['AddedDate']) ?></td>
                            <td>
                                <span class="badge <?= $order['Status'] === 'Pending' ? 'bg-info' : ($order['Status'] === 'Approved' ? 'bg-success' : 'bg-danger') ?>">
                                    <?= htmlspecialchars($order['Status']) ?>
                                </span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="actionDropdown<?= $order['OrderID'] ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                        Select Action
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="actionDropdown<?= $order['OrderID'] ?>">
                                        <li>
                                            <form method="POST" action="update_status_form.php">
                                                <input type="hidden" name="order_id" value="<?= $order['OrderID'] ?>">
                                                <button type="submit" name="status" value="Approved" class="dropdown-item">Approve</button>
                                                <button type="submit" name="status" value="Rejected" class="dropdown-item">Reject</button>
                                            </form>
                                        </li>
                                        <li>
                                            <a href="edit_order.php?order_id=<?= $order['OrderID'] ?>" class="dropdown-item">Return Form</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="13" class="text-center">No orders found</td>
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
                    this.textContent = '▲'; // Up arrow when expanded
                } else {
                    extraItemsDiv.style.display = 'none';
                    this.textContent = '...'; // Three dots when collapsed
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
                    alert('Payment is already marked as Paid.');
                    return;
                }

                if (confirm(`Mark this order as ${newStatus}?`)) {
                    fetch('update_payment_status.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ order_id: orderId, status: newStatus })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Payment status updated successfully.');
                            location.reload();
                        } else {
                            alert('Error updating payment status: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while updating the payment status.');
                    });
                }
            });
        });

        // Handle order deletion
        document.querySelectorAll('.delete-order').forEach(button => {
            button.addEventListener('click', function () {
                const orderId = this.getAttribute('data-order-id');
                if (confirm('Are you sure you want to delete this order?')) {
                    fetch('delete_order.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ order_id: orderId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Order deleted successfully.');
                            location.reload();
                        } else {
                            alert('Error deleting order: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the order.');
                    });
                }
            });
        });
    });
</script>

<script>
    function generatePDF(orderID, userName, customerName, productName, quantity, price) {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.setFontSize(12);
        doc.text('Delivery Note', 10, 10);

        doc.setFontSize(8);
        doc.text(`Order No: ${orderID}`, 10, 20);
        doc.text(`User Name: ${userName}`, 10, 30);
        doc.text(`Customer Name: ${customerName}`, 10, 40);
        doc.text(`Product Name: ${productName}`, 10, 50);
        doc.text(`Quantity: ${quantity}`, 10, 60);
        doc.text(`Price per Unit: Tsh ${price}`, 10, 70);
        doc.text(`Total Price: Tsh ${quantity * price}`, 10, 80);

        doc.save(`delivery_note_order_${orderID}.pdf`);
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
