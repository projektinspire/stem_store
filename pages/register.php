<?php
// WARNING: Storing plaintext passwords is NOT secure. This modification is made
// strictly by user request and is highly discouraged.

require_once '../connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- PHP Functions ---

/**
 * Validates email format.
 */
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Checks if a username already exists.
 */
function check_username_exists($conn, $username) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();
    return $exists;
}

/**
 * Fetches the allowed ENUM values for the 'role' column from the 'users' table.
 */
function get_role_enum_values($conn) {
    // Query the database schema to get the definition of the 'role' column
    $sql = "SHOW COLUMNS FROM users WHERE Field = 'role'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // The Type string will look like: ENUM('Admin','User')
        $type = $row['Type'];

        // Extract the values within the parentheses
        preg_match('/enum\((.*)\)/i', $type, $matches);

        if (isset($matches[1])) {
            // Remove the single quotes and split into an array
            $values = str_getcsv($matches[1], ',', "'");
            return $values;
        }
    }
    // Fallback roles if fetching fails - based on your image
    return ['Admin', 'User']; 
}

$message = '';
$allowed_roles = get_role_enum_values($conn); // Fetch roles for the form

// --- Form Submission Handling ---

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get and sanitize form inputs
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? ''; // Plaintext password
    $role     = $_POST['role'] ?? '';

    // 1. Basic input validation
    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        $message = '<div class="alert alert-danger text-white">All fields are required.</div>';
    }
    // 2. Validate email format
    elseif (!validate_email($email)) {
        $message = '<div class="alert alert-danger text-white">Invalid email format.</div>';
    }
    // 3. Check username availability
    elseif (check_username_exists($conn, $username)) {
        $message = '<div class="alert alert-danger text-white">Username already exists. Please choose another.</div>';
    }
    // 4. Validate selected role against allowed ENUM values
    elseif (!in_array($role, $allowed_roles)) {
        $message = '<div class="alert alert-danger text-white">Invalid role selected.</div>';
    }
    else {
        // !!! IMPORTANT CHANGE: Using PLAINTEXT password for insertion
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, role, created_at) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)");
        
        // Pass the raw $password variable to the binding
        $stmt->bind_param("ssss", $username, $password, $email, $role);

        if ($stmt->execute()) {
            // Success -> redirect
            header("Location: users.php");
            exit();
        } else {
            // Capture and display the database error
            $message = '<div class="alert alert-danger text-white">Error: ' . htmlspecialchars($stmt->error) . '</div>';
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/white.png">
  <title>STEM STORE - Register</title>

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
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
        <li class="nav-item"><a class="nav-link" href="../index2.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-tachometer-alt text-primary text-sm opacity-10"></i></div><span class="nav-link-text ms-1">Dashboard</span></a></li>
        <li class="nav-item"><a class="nav-link" href="sales.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-hand-holding-usd text-warning text-sm opacity-10"></i></div><span class="nav-link-text ms-1">Return Products</span></a></li>
        <li class="nav-item"><a class="nav-link" href="products.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-boxes text-danger text-sm opacity-10"></i></div><span class="nav-link-text ms-1">Manage Products</span></a></li>
        <li class="nav-item"><a class="nav-link" href="addproducts.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-plus-square text-success text-sm opacity-10"></i></div><span class="nav-link-text ms-1">Add Products</span></a></li>
        <li class="nav-item"><a class="nav-link" href="Manageadmin.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-user-shield text-info text-sm opacity-10"></i></div><span class="nav-link-text ms-1">Manage Admin</span></a></li>
        <li class="nav-item"><a class="nav-link" href="users.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-users text-info text-sm opacity-10"></i></div><span class="nav-link-text ms-1">Manage Users</span></a></li>
        <li class="nav-item"><a class="nav-link" href="customers.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-user-friends text-primary text-sm opacity-10"></i></div><span class="nav-link-text ms-1">manage Store Keepers</span></a></li>
        
        <li class="nav-item">
          <a class="nav-link active" href="register.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-user-plus text-success text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Register</span>
          </a>
        </li>

        <li class="nav-item"><a class="nav-link" href="customer_report.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-chart-bar text-primary text-sm opacity-10"></i></div><span class="nav-link-text ms-1">Users Report</span></a></li>
        <li class="nav-item"><a class="nav-link" href="report.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-chart-line text-success text-sm opacity-10"></i></div><span class="nav-link-text ms-1">Reports</span></a></li>
        <li class="nav-item"><a class="nav-link" href="profile.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-user text-dark text-sm opacity-10"></i></div><span class="nav-link-text ms-1">Profile</span></a></li>
        <li class="nav-item"><a class="nav-link" href="login.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-sign-out-alt text-danger text-sm opacity-10"></i></div><span class="nav-link-text ms-1">Logout</span></a></li>
      </ul>
    </div>
  </aside>

  <main class="main-content position-relative border-radius-lg">
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
      <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
        <ul class="navbar-nav justify-content-end ms-auto">
          <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
              <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line bg-white"></i>
                <i class="sidenav-toggler-line bg-white"></i>
                <i class="sidenav-toggler-line bg-white"></i>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="container-fluid py-4 d-flex justify-content-center align-items-center min-vh-100">
      <div class="row w-100">
        <div class="col-lg-6 col-md-8 col-sm-10 mx-auto">
          <div class="card">
            <div class="card-header">
              <h6>Admin Registration Form</h6>
            </div>
            <div class="card-body">

              <?php if ($message): ?>
                <?= $message ?>
              <?php endif; ?>

              <form method="POST" action="">
                <div class="mb-3">
                  <input type="text" name="username" class="form-control" placeholder="User Name" required>
                </div>
                <div class="mb-3">
                  <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3">
                  <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <div class="mb-3">
                  <select name="role" class="form-control" required>
                    <option value="" disabled selected>Select Role</option>
                    <?php
                    // Loop through the roles fetched from the database
                    foreach ($allowed_roles as $role_option) {
                        // The value and the displayed text are both the role name (e.g., 'Admin' or 'User')
                        echo '<option value="' . htmlspecialchars($role_option) . '">' . htmlspecialchars($role_option) . '</option>';
                    }
                    ?>
                  </select>
                </div>

                <div class="text-center">
                  <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Register</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <footer class="footer pt-3">
      <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="copyright text-center text-sm text-muted text-lg-start">
              © <script>document.write(new Date().getFullYear())</script> 
              <i class="fa fa-heart"></i>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </main>

  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = { damping: '0.5' }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>
</html>

<?php 
$conn->close(); 
?>