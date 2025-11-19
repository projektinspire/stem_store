 
<!DOCTYPE html>
<html lang="en">

<?php $pageTitle = 'STEM STORE'; include '../includes/head.php'; ?>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
<?php include '../includes/sidebar_user.php'; ?>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <?php include '../includes/navbar.php'; ?>
    <!-- End Navbar -->
<?php
include '../connection.php';

// Get filters
$searchKeyword = $_GET['search'] ?? '';
$categoryFilter = $_GET['category'] ?? '';

// Build query
$sql = "SELECT ID, ProductName, Image, prod_price, Quantity, Description, prod_cat, location, AddedDate 
        FROM products 
        WHERE ProductName LIKE ?";

if (!empty($categoryFilter)) {
    $sql .= " AND prod_cat = ?";
}

$sql .= " ORDER BY AddedDate DESC";

$stmt = $conn->prepare($sql);
$searchParam = "%$searchKeyword%";

if (!empty($categoryFilter)) {
    $stmt->bind_param("ss", $searchParam, $categoryFilter);
} else {
    $stmt->bind_param("s", $searchParam);
}

$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

// Fetch categories
$categoryQuery = $conn->query("SELECT DISTINCT prod_cat FROM products WHERE prod_cat IS NOT NULL AND prod_cat != ''");

$stmt->close();
$conn->close();
?>



<div class="container-fluid py-3">
    <div class="row mb-3">
        <div class="col-md-8">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Search Product"
                       value="<?php echo htmlspecialchars($searchKeyword); ?>">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    <?php while ($cat = $categoryQuery->fetch_assoc()): ?>
                        <option value="<?php echo $cat['prod_cat']; ?>" <?php echo ($categoryFilter == $cat['prod_cat']) ? 'selected' : ''; ?>>
                            <?php echo $cat['prod_cat']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <button class="btn btn-theme">Filter</button>
            </form>
        </div>
        <div class="col-md-4 text-end">
            <button class="btn btn-success btn-sm" onclick="exportTableToCSV('products.csv')">Export CSV</button>
        </div>
    </div>

    <div class="card">
        <div class="card-header card-header-white">
            <h6 class="mb-0">Product List</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2 table-container">
            <table class="table table-hover mb-0 sticky-header">
                <thead>
                    <tr>
                        <th>Part Code</th>
                        <th>Product</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Description</th>
                        <th>Category</th>
                        <!-- <th>Location</th> -->
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($products): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td>PI-<?php echo $product['ID']; ?></td>
                            <td><?php echo htmlspecialchars($product['ProductName']); ?></td>
                            <td>
                                <a href="javascript:void(0);" onclick="showImageModal('<?php echo htmlspecialchars($product['Image']); ?>')">
                                    <img src="<?php echo htmlspecialchars($product['Image']); ?>" width="35" height="35" style="object-fit:cover;">
                                </a>
                            </td>
                            <td>Tsh <?php echo number_format($product['prod_price'], 2); ?></td>
                            <td>
                                <?php echo $product['Quantity']; ?>
                                <?php if ($product['Quantity'] < 5): ?>
                                    <span class="low-stock">Low stock</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo strlen($product['Description']) > 30 ? substr($product['Description'], 0, 30) . '...' : htmlspecialchars($product['Description']); ?></td>
                            <td><?php echo htmlspecialchars($product['prod_cat']); ?></td>
                            <!-- <td><?php echo htmlspecialchars($product['location']); ?></td> -->
                            <td><?php echo htmlspecialchars($product['AddedDate']); ?></td>
                            <td>
                                <a href="edit_product.php?id=<?php echo $product['ID']; ?>" class="btn btn-sm btn-info">Edit</a>
                                <a href="delete_product.php?id=<?php echo $product['ID']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="10" class="text-center">No products found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Product Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid">
            </div>
            <div class="modal-footer">
                <a id="downloadImage" href="#" download class="btn btn-primary">Download</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
// Show image modal
function showImageModal(imgUrl) {
    document.getElementById('modalImage').src = imgUrl;
    document.getElementById('downloadImage').href = imgUrl;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}

// Export table to CSV
function exportTableToCSV(filename) {
    let csv = [];
    const rows = document.querySelectorAll("table tr");

    for (let row of rows) {
        const cols = row.querySelectorAll("td, th");
        const rowData = Array.from(cols).map(col => `"${col.innerText.trim().replace(/"/g, '""')}"`);
        csv.push(rowData.join(","));
    }

    const csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
    const downloadLink = document.createElement("a");
    downloadLink.href = URL.createObjectURL(csvFile);
    downloadLink.download = filename;
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}
</script>

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