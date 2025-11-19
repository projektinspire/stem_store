<!DOCTYPE html>
<html lang="en">
<?php $pageTitle = 'STEM STORE'; include '../includes/head.php'; ?>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
<?php include '../includes/sidebar.php'; ?>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <?php include '../includes/navbar.php'; ?>
    <?php
include '../connection.php'; // Ensure this file contains your database connection setup

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize search query
$searchTerm = '';
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    // Search query with LIKE for partial matching
    $sql = "SELECT CustomerID, CustomerName, TINNumber, VRN, LPO, AddedDate FROM customers WHERE CustomerName LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTermWildcard = "%" . $searchTerm . "%";
    $stmt->bind_param("s", $searchTermWildcard);
} else {
    // Default query to fetch all customers
    $sql = "SELECT CustomerID, CustomerName, TINNumber, VRN, LPO, AddedDate FROM customers";
    $stmt = $conn->prepare($sql);
}

// Execute the query and check for errors
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!-- Search Form and Display Table -->
<div class="container-fluid py-4"> 
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6>Store Keeper List</h6>
          <!-- Search Form -->
          <form method="get" action="" class="d-flex mb-3">
              <input type="text" name="search" class="form-control" placeholder="Search by customer name" value="<?php echo htmlspecialchars($searchTerm); ?>">
              <button type="submit" class="btn btn-primary ms-2">Search</button>
          </form>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer ID</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer Name</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">TIN Number</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">VRN</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">LPO</th> <!-- Added LPO Column -->
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date Added</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($result->num_rows > 0) {
                  // Output each row
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><p class='text-xs font-weight-bold mb-0'>" . htmlspecialchars($row['CustomerID']) . "</p></td>";
                    echo "<td><p class='text-xs font-weight-bold mb-0'>" . htmlspecialchars($row['CustomerName']) . "</p></td>";
                    echo "<td><p class='text-xs font-weight-bold mb-0'>" . htmlspecialchars($row['TINNumber']) . "</p></td>";
                    echo "<td><p class='text-xs font-weight-bold mb-0'>" . htmlspecialchars($row['VRN']) . "</p></td>";
                    echo "<td><p class='text-xs font-weight-bold mb-0'>" . htmlspecialchars($row['LPO']) . "</p></td>"; // Display LPO
                    echo "<td><p class='text-xs font-weight-bold mb-0'>" . htmlspecialchars($row['AddedDate']) . "</p></td>";
                    echo "<td class='align-middle'>
                            <a href='edit_customer.php?id=" . htmlspecialchars($row['CustomerID']) . "' class='btn btn-xs btn-warning'>Edit</a>
                            <a href='delete_customer.php?id=" . htmlspecialchars($row['CustomerID']) . "' class='btn btn-xs btn-danger' onclick='return confirm(\"Are you sure you want to delete this customer?\");'>Delete</a>
                          </td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='7' class='text-center'>No customers found</td></tr>"; // Updated colspan
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
// Close the prepared statement and connection
$stmt->close();
$conn->close();
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
</body>

</html>