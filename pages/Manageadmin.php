<?php
ob_start(); // Start output buffering
session_start();

// Include database connection
require_once '../connection.php';
?>
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
.center-button {
    display: flex;
    justify-content: center; /* Center horizontally */
    align-items: center; /* Center vertically if needed */
    margin-top: 1rem; /* Add space above */
}
/* Make top header background span full width on this page */
.main-content { border-top-left-radius: 0 !important; border-top-right-radius: 0 !important; }
  </style>

</head>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute top-0 start-0 end-0 w-100"></div>
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
          <a class="nav-link" href="addproducts.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-plus-square text-success text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Add Products</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link active" href="Manageadmin.php">
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
          <a class="nav-link" href="register.php">
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
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <?php

// Include the database connection file
include '../connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Generate a CSRF token to prevent form resubmission
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle POST request for saving privileges
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    // CSRF token validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Invalid CSRF token');
    }

    if (isset($_POST['user']) && is_array($_POST['user'])) {
        foreach ($_POST['user'] as $user_id => $privileges) {
            $can_manage_admins = isset($privileges['can_manage_admins']) ? 1 : 0;
            $can_manage_users = isset($privileges['can_manage_users']) ? 1 : 0;
            $can_view_reports = isset($privileges['can_view_reports']) ? 1 : 0;

            $update_sql = "UPDATE users SET can_manage_admins = ?, can_manage_users = ?, can_view_reports = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("iiii", $can_manage_admins, $can_manage_users, $can_view_reports, $user_id);
            $update_stmt->execute();
            $update_stmt->close();
        }

        // Reset CSRF token
        unset($_SESSION['csrf_token']);
        header("Location: Manageadmin.php?success=1");
        exit();
    }
}

// Handle DELETE request for deleting a user/admin
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    // CSRF token validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
        die('Invalid CSRF token');
    }
    $admin_id = (int)($_POST['admin_id'] ?? 0);

    // OPTIONAL: prevent deleting yourself (security best practice)
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $admin_id) {
        header("Location: Manageadmin.php?error=cannot_delete_self");
        exit();
    }

    // Delete the user/admin regardless of role (no Director anymore)
    $delete_sql = "DELETE FROM users WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $admin_id);
    $delete_stmt->execute();
    $delete_stmt->close();

    header("Location: Manageadmin.php?deleted=1");
    exit();
}

// Fetch admins only
$sql = "SELECT id, username, email, password, role, can_manage_admins, can_manage_users, can_view_reports FROM users WHERE role = 'Admin'";
$result = $conn->query($sql);
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
                <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Admin List</h6>
                        <form method="GET" action="" class="form-inline d-flex admins-search-form">
                            <input id="adminsSearchInput" type="text" name="search" placeholder="Search Admin" aria-label="Search Admin"
                                   value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" class="form-control me-2" autocomplete="off">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <?php if (!empty($_GET['search'])): ?>
                              <a href="?" class="btn btn-secondary ms-2">Clear</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <?php
                    if (isset($_GET['success'])) {
                        echo "<div class='alert alert-success'>User privileges updated successfully!</div>";
                    }
                    if (isset($_GET['deleted'])) {
                        echo "<div class='alert alert-success'>User deleted successfully!</div>";
                    }
                    if (isset($_GET['error'])) {
                        if ($_GET['error'] == 'cannot_delete_self') {
                            echo "<div class='alert alert-danger'>You cannot delete yourself!</div>";
                        }
                    }
                    ?>
                    <form method="POST" action="">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Manage Admins</th>
                                        <th>Manage Users</th>
                                        <th>View Reports</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="adminsTableBody">
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["role"]) . "</td>";

                                            echo "<td class='text-center'><input type='checkbox' name='user[" . $row["id"] . "][can_manage_admins]' " . ($row["can_manage_admins"] ? "checked" : "") . "></td>";
                                            echo "<td class='text-center'><input type='checkbox' name='user[" . $row["id"] . "][can_manage_users]' " . ($row["can_manage_users"] ? "checked" : "") . "></td>";
                                            echo "<td class='text-center'><input type='checkbox' name='user[" . $row["id"] . "][can_view_reports]' " . ($row["can_view_reports"] ? "checked" : "") . "></td>";

                                            // Delete button: disable if user is current logged-in user
                                            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['id']) {
                                                echo "<td>
                                                    <a href='edit_user.php?id=" . $row['id'] . "&return=Manageadmin' class='btn btn-warning btn-sm me-1'>Edit</a>
                                                    <button class='btn btn-secondary btn-sm' disabled>Cannot Delete Self</button>
                                                </td>";
                                            } else {
                                                echo "<td>
                                                    <a href='edit_user.php?id=" . $row['id'] . "&return=Manageadmin' class='btn btn-warning btn-sm me-1'>Edit</a>
                                                    <button type='button' class='btn btn-danger btn-sm' onclick='return confirmDeleteAdmin(" . $row['id'] . ")'>Delete</button>
                                                </td>";
                                            }

                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='9'>No users found</td></tr>";
                                    }
                                    ?>
                                    <tr id="adminsNoRows" style="display:none;">
                                        <td colspan="9" class="text-center py-4">
                                            <div class="text-muted"><i class="fas fa-inbox fa-2x mb-2 d-block"></i>No matching admins</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="center-button mt-3">
                            <button type="submit" name="save" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                    <!-- Hidden delete form (separate from privileges form to avoid nesting) -->
                    <form id="adminDeleteForm" method="POST" style="display:none;">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                        <input type="hidden" name="admin_id" id="adminDeleteId" value="">
                        <input type="hidden" name="delete" value="1">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$conn->close();
ob_end_flush();
?>


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
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const form = document.querySelector('.admins-search-form');
      const input = document.getElementById('adminsSearchInput');
      const tbody = document.getElementById('adminsTableBody');
      const noRow = document.getElementById('adminsNoRows');
      if (!form || !input || !tbody) return;
      function applyFilter() {
        const q = (input.value || '').trim().toLowerCase();
        const rows = Array.from(tbody.querySelectorAll('tr')).filter(r => r !== noRow);
        let visible = 0;
        if (q.length < 2) {
          rows.forEach(r => r.style.display = '');
          if (noRow) noRow.style.display = 'none';
          return;
        }
        rows.forEach(row => {
          const text = row.innerText.toLowerCase();
          const show = text.includes(q);
          row.style.display = show ? '' : 'none';
          if (show) visible++;
        });
        if (noRow) noRow.style.display = visible === 0 ? '' : 'none';
      }
      input.addEventListener('input', applyFilter);
      form.addEventListener('submit', function (e) { e.preventDefault(); applyFilter(); });
      applyFilter();
      // Delete helper
      window.confirmDeleteAdmin = function(id) {
        if (confirm('Are you sure you want to delete this user?')) {
          document.getElementById('adminDeleteId').value = id;
          document.getElementById('adminDeleteForm').submit();
          return true;
        }
        return false;
      };
    });
  </script>
</body>

</html>