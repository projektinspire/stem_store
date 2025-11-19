<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/white.png">
  <title>STEM STORE - Manage Products</title>

  <!-- Fonts and Icons -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

  <!-- Argon Dashboard CSS -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/theme.css" />
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>

  <!-- Sidebar -->
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main" style="height: 100vh; position: fixed; overflow: hidden;">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="../index2.php">
        <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">STEM STORE</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main" style="height: calc(100vh - 100px); overflow-y: auto;">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="../index2.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-tachometer-alt text-primary text-sm opacity-10"></i></div><span class="nav-link-text ms-1">Dashboard</span></a></li>
        <li class="nav-item"><a class="nav-link" href="sales.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-hand-holding-usd text-warning text-sm opacity-10"></i></div><span class="nav-link-text ms-1">Return Products</span></a></li>
        <li class="nav-item"><a class="nav-link active" href="products.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-boxes text-danger text-sm opacity-10"></i></div><span class="nav-link-text ms-1">Manage Products</span></a></li>
        <li class="nav-item"><a class="nav-link" href="addproducts.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-plus-square text-success text-sm opacity-10"></i></div><span class="nav-link-text ms-1">Add Products</span></a></li>
        <li class="nav-item"><a class="nav-link" href="Manageadmin.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-user-shield text-info text-sm opacity-10"></i></div><span class="nav-link-text ms-1">Manage Admin</span></a></li>
        <li class="nav-item"><a class="nav-link" href="users.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-users text-info text-sm opacity-10"></i></div><span class="nav-link-text ms-1">Manage Users</span></a></li>
        <li class="nav-item"><a class="nav-link" href="customers.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-user-friends text-primary text-sm opacity-10"></i></div><span class="nav-link-text ms-1">Manage Store keepers</span></a></li>
        <li class="nav-item"><a class="nav-link" href="register.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-user-plus text-success text-sm opacity-10"></i></div><span class="nav-link-text ms-1">Register</span></a></li>
        <li class="nav-item"><a class="nav-link" href="customer_report.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-chart-bar text-primary text-sm opacity-10"></i></div><span class="nav-link-text ms-1">Users Report</span></a></li>
        <li class="nav-item"><a class="nav-link" href="report.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-chart-line text-success text-sm opacity-10"></i></div><span class="nav-link-text ms-1">Reports</span></a></li>
        <li class="nav-item"><a class="nav-link" href="profile.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-user text-dark text-sm opacity-10"></i></div><span class="nav-link-text ms-1">Profile</span></a></li>
        <li class="nav-item"><a class="nav-link" href="../pages/login.php"><div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"><i class="fas fa-sign-out-alt text-danger text-sm opacity-10"></i></div><span class="nav-link-text ms-1">Logout</span></a></li>
      </ul>
    </div>
  </aside>

  <main class="main-content position-relative border-radius-lg">
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur">
      <div class="container-fluid py-1 px-3"></div>
    </nav>

    <?php
    include '../connection.php';

    $searchKeyword = isset($_GET['search']) ? trim($_GET['search']) : '';
    $categoryFilter = isset($_GET['category']) ? $_GET['category'] : [];
    if (!is_array($categoryFilter)) $categoryFilter = [$categoryFilter];

    $whereConditions = [];
    $params = [];
    $types = '';

    if (!empty($searchKeyword)) {
        $whereConditions[] = "ProductName LIKE ?";
        $params[] = "%$searchKeyword%";
        $types .= 's';
    }

    if (!empty($categoryFilter)) {
        $placeholders = implode(',', array_fill(0, count($categoryFilter), '?'));
        $whereConditions[] = "prod_cat IN ($placeholders)";
        foreach ($categoryFilter as $cat) {
            $params[] = $cat;
            $types .= 's';
        }
    }

    $whereClause = !empty($whereConditions)
        ? 'WHERE ' . implode(' AND ', $whereConditions)
        : '';

    $countQuery = "SELECT COUNT(*) as total FROM products $whereClause";
    $countStmt = $conn->prepare($countQuery);
    if (!empty($params)) $countStmt->bind_param($types, ...$params);
    $countStmt->execute();
    $totalItems = $countStmt->get_result()->fetch_assoc()['total'];

    $categoryQuery = $conn->query("SELECT DISTINCT prod_cat FROM products WHERE prod_cat IS NOT NULL AND prod_cat != '' ORDER BY prod_cat");

    $query = "SELECT * FROM products $whereClause ORDER BY ProductName ASC";
    $stmt = $conn->prepare($query);
    if (!empty($params)) $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    ?>

    <style>
        .card { border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); overflow: hidden; }
        .table-responsive-2d {
            max-height: 75vh;
            overflow: auto;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            position: relative;
        }
        .table-responsive-2d table {
            min-width: 1500px;
            width: 100%;
            margin-bottom: 0;
        }
        .table-responsive-2d thead th {
            position: sticky;
            top: 0;
            background: #fff;
            z-index: 10;
            border-bottom: 2px solid #dee2e6;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            font-weight: 600;
            font-size: 12.5px;
            text-transform: uppercase;
            color: #495057;
        }
        .low-stock { background:#dc3545; color:white; padding:4px 10px; border-radius:6px; font-size:11px; font-weight:bold; }
        .card-header-white { background:white !important; color:black !important; border-bottom:1px solid #ddd; }
        .table-responsive-2d::-webkit-scrollbar { width:12px; height:12px; }
        .table-responsive-2d::-webkit-scrollbar-track { background:#f1f1f1; border-radius:10px; }
        .table-responsive-2d::-webkit-scrollbar-thumb { background:#c1c1c1; border-radius:10px; }
        .table-responsive-2d::-webkit-scrollbar-thumb:hover { background:#a8a8a8; }

        /* 🔥 Dropdown panel styling */
        .category-dropdown {
            position: relative;
        }
        .category-panel {
            position: absolute;
            top: 100%;
            left: 0;
            width: 260px;
            background: white;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: none;
            z-index: 999;
        }
        .category-panel.show {
            display: block;
        }
        .category-panel label {
            display: block;
            padding: 4px;
            cursor: pointer;
        }
    </style>

    <div class="container-fluid py-4">

        <!-- Search & Filter Form -->
        <div class="row mb-4">
            <div class="col-12">
                <form method="GET" class="row g-3 align-items-end">

                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search product name..."
                            value="<?php echo htmlspecialchars($searchKeyword); ?>">
                    </div>

                    <div class="col-md-3">
                        <!-- 🔥 CUSTOM CATEGORY MULTI-SELECT DROPDOWN -->
                        <div class="category-dropdown">
                            <button type="button" class="form-control text-start" id="categoryBtn">
                                <?php 
                                    if (empty($categoryFilter)) echo "Select Categories";
                                    else echo count($categoryFilter) . " categories selected";
                                ?>
                            </button>

                            <div class="category-panel" id="categoryPanel">
                                <?php 
                                $categoryQuery->data_seek(0);
                                while ($cat = $categoryQuery->fetch_assoc()): 
                                    $value = htmlspecialchars($cat['prod_cat']);
                                    $checked = in_array($cat['prod_cat'], $categoryFilter) ? 'checked' : '';
                                ?>
                                <label>
                                    <input type="checkbox" name="category[]" value="<?php echo $value; ?>" <?php echo $checked; ?>>
                                    <?php echo $value; ?>
                                </label>
                                <?php endwhile; ?>

                                <div class="mt-2 d-flex justify-content-between">
                                    <button type="button" class="btn btn-sm btn-primary" id="applyBtn">Apply</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="clearCatBtn">Clear</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="btn-group w-100">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i> Search
                            </button>
                            <a href="?" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i> Clear
                            </a>
                            <button type="button" class="btn btn-success" onclick="exportTableToCSV('STEM_Store_Products.csv')">
                                <i class="fas fa-file-export me-1"></i> Export CSV
                            </button>
                        </div>
                    </div>
                </form>

                <?php if ($searchKeyword || !empty($categoryFilter)): ?>
                <div class="mt-3 alert alert-info d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-info-circle me-2"></i>
                        Found <strong><?php echo number_format($totalItems); ?></strong> product(s)

                        <?php if ($searchKeyword): ?>
                            matching '<strong><?php echo htmlspecialchars($searchKeyword); ?></strong>'
                        <?php endif; ?>

                        <?php if (!empty($categoryFilter)): ?>
                            in category(s) '<strong><?php echo implode(", ", array_map('htmlspecialchars', $categoryFilter)); ?></strong>'
                        <?php endif; ?>
                    </div>
                    <a href="?" class="btn btn-sm btn-outline-info">Clear Filters</a>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Products Table -->
        <div class="card">
            <div class="card-header card-header-white">
                <h6 class="mb-0">All Products (<?php echo number_format($totalItems); ?> items)</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive-2d">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Part Code</th>
                                <th>Product Name</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Date Added</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($products)): ?>
                                <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><strong>PI-<?php echo $product['ID']; ?></strong></td>
                                    <td><?php echo htmlspecialchars($product['ProductName']); ?></td>
                                    <td>
                                        <a href="javascript:void(0)" onclick="showImageModal('<?php echo htmlspecialchars($product['Image']); ?>')">
                                            <img src="<?php echo htmlspecialchars($product['Image']); ?>" width="60" height="60" style="object-fit:cover; border-radius:8px; border:2px solid #eee;">
                                        </a>
                                    </td>
                                    <td><strong>Tsh <?php echo number_format($product['prod_price'], 2); ?></strong></td>
                                    <td>
                                        <?php echo $product['Quantity']; ?>
                                        <?php if ($product['Quantity'] < 5): ?>
                                            <span class="low-stock ms-2">Low Stock</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($product['Description']); ?></td>
                                    <td><span class="badge bg-primary"><?php echo htmlspecialchars($product['prod_cat']); ?></span></td>
                                    <td><?php echo date('d M Y', strtotime($product['AddedDate'])); ?></td>
                                    <td>
                                        <a href="edit_product.php?id=<?php echo $product['ID']; ?>" class="btn btn-sm btn-info mb-1">Edit</a>
                                        <a href="delete_product.php?id=<?php echo $product['ID']; ?>" class="btn btn-sm btn-danger mb-1" 
                                           onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                                        <h5 class="text-muted">No products found</h5>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Product Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid rounded shadow" style="max-height:80vh;">
                </div>
                <div class="modal-footer">
                    <a id="downloadImage" href="#" download class="btn btn-primary">Download Image</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        /* 🔥 CATEGORY DROPDOWN JS */
        const categoryBtn = document.getElementById("categoryBtn");
        const categoryPanel = document.getElementById("categoryPanel");
        const applyBtn = document.getElementById("applyBtn");
        const clearBtn = document.getElementById("clearCatBtn");

        categoryBtn.addEventListener("click", () => {
            categoryPanel.classList.toggle("show");
        });

        applyBtn.addEventListener("click", () => {
            categoryPanel.classList.remove("show");
            const checkedCount = document.querySelectorAll("input[name='category[]']:checked").length;
            categoryBtn.innerText = checkedCount === 0 
                ? "Select Categories"
                : checkedCount + " categories selected";
        });

        clearBtn.addEventListener("click", () => {
            document.querySelectorAll("input[name='category[]']").forEach(cb => cb.checked = false);
            categoryBtn.innerText = "Select Categories";
        });

        document.addEventListener("click", (e) => {
            if (!categoryPanel.contains(e.target) && !categoryBtn.contains(e.target)) {
                categoryPanel.classList.remove("show");
            }
        });

        /* IMAGE MODAL */
        function showImageModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('downloadImage').href = src;
            new bootstrap.Modal(document.getElementById('imageModal')).show();
        }

        /* CSV EXPORT */
        function exportTableToCSV(filename) {
            let csv = [];
            const rows = document.querySelectorAll("table tr");
            for (let row of rows) {
                const cols = row.querySelectorAll("td, th");
                const rowData = Array.from(cols).map(col => `"${col.innerText.trim().replace(/"/g, '""')}"`);
                csv.push(rowData.join(","));
            }
            const csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
            const link = document.createElement("a");
            link.href = URL.createObjectURL(csvFile);
            link.download = filename;
            link.click();
        }
    </script>

    <!-- Core JS -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
  </main>
</body>
</html>
