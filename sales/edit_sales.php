
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
      <a class="nav-link" href="">
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
      <a href="https://www.creative-tim.com/learning-lab/bootstrap/license/argon-dashboard" target="_blank" class="btn btn-dark btn-sm w-100 mb-3">Documentation</a>
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
include '../connection.php';

// Check if tax is included in the total
$includeTax = isset($_GET['includeTax']) && $_GET['includeTax'] == '1';
$taxRate = 0.18;

// Get search input
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query to fetch order data, including `LPO` and `Address` directly from the `orders` table
$query = "
    SELECT 
        o.ID AS OrderID, u.username AS UserName, c.CustomerName, oi.Quantity, 
        p.ProductName, oi.Price AS OrderedPrice, o.TotalPrice, o.PaymentMode, o.AddedDate,
        o.PaymentStatus, o.Status, o.LPO, o.Address -- Fetching LPO and Address from the orders table
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
            'Status' => $row['Status'] ?: 'Pending', // Default to Pending if not set
            'TotalPrice' => $row['TotalPrice'],
            'LPO' => $row['LPO'],   // Fetching LPO from orders table
            'Address' => $row['Address'],   // Fetching Address from orders table
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
          <h6>Sales</h6>
          <form method="GET" action="" class="form-inline">
            <input type="text" name="search" placeholder="Search by Order No" 
                   value="<?= htmlspecialchars($search) ?>" class="form-control">
            <input type="hidden" name="includeTax" value="<?= $includeTax ? '1' : '0' ?>"> <br>
            <button type="submit" class="btn btn-primary ml-2">Search</button>
          </form>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th>Order No</th>
                  <th>User Name</th>
                  <th>Customer Name</th>
                  <th>LPO</th> <!-- Moved LPO here -->
                  <th>Address</th> <!-- Moved Address here -->
                  <th>Product Details</th>
                  <th>Total Price</th>
                  <th>Payment Mode</th>
                  <th>Order Date</th>
                  <th>Status</th>
                  <th>Delivery Note</th>
                  <th>Payment Status</th>
                </tr>
              </thead>
              <tbody>
                <?php if (count($orders) > 0): ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>
                                #<?= htmlspecialchars($order['OrderID']) ?>
                                <?php if (count($order['Items']) > 1): ?>
                                    <span class="more-items-toggle" onclick="toggleItems(<?= $order['OrderID'] ?>)">...</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($order['UserName']) ?></td>
                            <td><?= htmlspecialchars($order['CustomerName']) ?></td>
                            <td><?= htmlspecialchars($order['LPO']) ?></td> <!-- Display LPO value -->
                            <td><?= htmlspecialchars($order['Address']) ?></td> <!-- Display Address value -->
                            <td>
                                <?= htmlspecialchars($order['Items'][0]['ProductName']) ?> - 
                                <?= htmlspecialchars($order['Items'][0]['Quantity']) ?> @ Tsh 
                                <?= number_format($order['Items'][0]['OrderedPrice'], 2) ?>
                                <div id="extra-items-<?= $order['OrderID'] ?>" style="display:none;">
                                    <?php for ($i = 1; $i < count($order['Items']); $i++): ?>
                                        <div>
                                            <?= htmlspecialchars($order['Items'][$i]['ProductName']) ?> - 
                                            <?= htmlspecialchars($order['Items'][$i]['Quantity']) ?> @ Tsh 
                                            <?= number_format($order['Items'][$i]['OrderedPrice'], 2, '.', '') ?>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </td>
                            <td>Tsh <?= number_format($includeTax ? $order['TotalPrice'] * (1 + $taxRate) : $order['TotalPrice'], 2) ?></td>                            
                            <td><?= htmlspecialchars($order['PaymentMode']) ?></td>
                            <td><?= htmlspecialchars($order['AddedDate']) ?></td>
                            <td>
                                <span class="badge <?= $order['Status'] === 'Pending' ? 'bg-info' : ($order['Status'] === 'Approved' ? 'bg-success' : 'bg-danger') ?>">
                                    <?= htmlspecialchars($order['Status']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($order['Status'] === 'Approved'): ?>
                                    <a href="../delivery_note/delivery_note.php?order_id=<?= $order['OrderID'] ?>" 
                                       class="btn btn-sm btn-primary">View Delivery Note</a>
                                <?php else: ?>
                                    <span class="text-secondary">N/A</span>
                                <?php endif; ?>
                            </td>
                            <td>
    <?php if ($order['PaymentStatus'] === 'Unpaid'): ?>
        <button class="btn btn-sm btn-danger update-status" 
                data-order-id="<?= $order['OrderID'] ?>" 
                data-new-status="Pending">Unpaid</button>
    <?php elseif ($order['PaymentStatus'] === 'Pending'): ?>
        <button class="btn btn-sm btn-warning" disabled>Pending</button>
    <?php else: ?>
        <button class="btn btn-sm btn-success" disabled>Paid</button>
    <?php endif; ?>
</td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="12" class="text-center">No orders found</td>
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
    function toggleItems(orderID) {
        const extraItemsDiv = document.getElementById(`extra-items-${orderID}`);
        extraItemsDiv.style.display = extraItemsDiv.style.display === 'none' ? 'block' : 'none';
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const buttons = document.querySelectorAll('.update-status');
        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const orderId = this.getAttribute('data-order-id');
                const newStatus = this.getAttribute('data-new-status');

                fetch('update_payment_status.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ order_id: orderId, status: newStatus })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.className = 'btn btn-sm btn-warning';
                        this.innerText = newStatus;
                        this.disabled = true;
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the status.');
                });
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