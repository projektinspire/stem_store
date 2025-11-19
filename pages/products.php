<?php
include '../connection.php'; // Ensure this path is correct

// ===============================================
// 1. Determine if this is an AJAX request or a standard page load
// ===============================================
$is_ajax = isset($_GET['ajax']) && $_GET['ajax'] === 'true';

// Get search and filter parameters
$searchKeyword = isset($_GET['search']) ? trim($_GET['search']) : '';
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : [];
if (!is_array($categoryFilter)) $categoryFilter = [$categoryFilter];

// ===============================================
// 2. Database Query Logic (Used for both page load and AJAX)
// ===============================================
$whereConditions = [];
$params = [];
$types = '';

if (!empty($searchKeyword)) {
    // Escape for LIKE search
    $searchPattern = "%" . str_replace(['%', '_'], ['\\%', '\\_'], $searchKeyword) . "%";
    $whereConditions[] = "ProductName LIKE ?";
    $params[] = $searchPattern;
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

// Total Count Query
$countQuery = "SELECT COUNT(*) as total FROM products $whereClause";
$countStmt = $conn->prepare($countQuery);
if (!empty($params)) $countStmt->bind_param($types, ...$params);
$countStmt->execute();
$totalItems = $countStmt->get_result()->fetch_assoc()['total'];
$countStmt->close();


// Product Fetch Query
$query = "SELECT * FROM products $whereClause ORDER BY ProductName ASC";
$stmt = $conn->prepare($query);
if (!empty($params)) $stmt->bind_param($types, ...$params);
$stmt->execute();
$products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Get categories for filter dropdown (always run for the full page structure)
$categoryQuery = $conn->query("SELECT DISTINCT prod_cat FROM products WHERE prod_cat IS NOT NULL AND prod_cat != '' ORDER BY prod_cat");


// ===============================================
// 3. AJAX Response Output (Only runs if ?ajax=true is set)
// ===============================================
if ($is_ajax) {
    // 3a. Output the Filter Status HTML (Sent first)
    $filterStatusHtml = '';
    if ($searchKeyword || !empty($categoryFilter)) {
        $categoryList = implode(", ", array_map('htmlspecialchars', $categoryFilter));
        
        // Removed mt-3 here as it's better applied to the container in the main HTML
        $filterStatusHtml = "
        <div id='filterStatus' class='alert alert-info d-flex justify-content-between align-items-center'>
            <div>
                <i class='fas fa-info-circle me-2'></i>
                Found <strong>" . number_format($totalItems) . "</strong> product(s)
                " . ($searchKeyword ? "matching '<strong>" . htmlspecialchars($searchKeyword) . "</strong>'" : "") . "
                " . (!empty($categoryFilter) ? " in category(s) '<strong>" . $categoryList . "</strong>'" : "") . "
            </div>
            <a href='products.php' class='btn btn-sm btn-outline-info'>Clear Filters</a>
        </div>";
    }

    // We send a JSON object containing two parts: the status and the table HTML.
    header('Content-Type: application/json');
    echo json_encode([
        'status_html' => $filterStatusHtml,
        'table_html' => (function() use ($products, $totalItems) {
            ob_start();
            include 'product_table_template.php'; 
            return ob_get_clean();
        })()
    ]);
    
    exit; // Stop execution after sending the AJAX content
}
// ===============================================
// 4. Standard Page Load HTML Output (Runs if ?ajax=true is NOT set)
// ===============================================
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/white.png">
  <title>STEM STORE - Manage Products</title>

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/theme.css" />
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>

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

        /* Dropdown panel styling */
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
            /* Ensure the panel stays on top of the alert and table */
            z-index: 1000; 
        }
        .category-panel.show {
            display: block;
        }
        .category-panel label {
            display: block;
            padding: 4px;
            cursor: pointer;
        }
        #loadingIndicator {
            text-align: center;
            padding: 20px;
            color: #6c757d;
        }
    </style>

    <div class="container-fluid py-4">

        <div class="row mb-4">
            <div class="col-12">
                <form id="filterForm" class="row g-3 align-items-end" onsubmit="event.preventDefault(); fetchProducts();">

                    <div class="col-md-4">
                        <input type="text" name="search" id="searchInput" class="form-control" placeholder="Search product name..."
                            value="<?php echo htmlspecialchars($searchKeyword); ?>" oninput="fetchProducts();">
                    </div>

                    <div class="col-md-3">
                        <div class="category-dropdown">
                            <button type="button" class="form-control text-start" id="categoryBtn">
                                <?php 
                                    if (empty($categoryFilter)) echo "Select Categories";
                                    else echo count($categoryFilter) . " categories selected";
                                ?>
                            </button>

                            <div class="category-panel" id="categoryPanel">
                                <?php 
                                // Reset pointer for output
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
                            <!-- <button type="button" class="btn btn-primary" onclick="fetchProducts()">
                                <i class="fas fa-search me-1"></i> Search
                            </button> -->
                            <a href="?" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i> Clear All
                            </a>
                            <button type="button" class="btn btn-success" onclick="exportTableToCSV('STEM_Store_Products.csv')">
                                <i class="fas fa-file-export me-1"></i> Export CSV
                            </button>
                        </div>
                    </div>
                </form>
                
                <div id="filterStatusContainer" class="mt-4 mb-3">
                    <?php 
                    // Initial load filter status display
                    if ($searchKeyword || !empty($categoryFilter)): 
                        $categoryList = implode(", ", array_map('htmlspecialchars', $categoryFilter));
                        ?>
                        <div class="alert alert-info d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-info-circle me-2"></i>
                                Found **<?php echo number_format($totalItems); ?>** product(s)
                                <?php if ($searchKeyword): ?>
                                    matching '<strong><?php echo htmlspecialchars($searchKeyword); ?></strong>'
                                <?php endif; ?>
                                <?php if (!empty($categoryFilter)): ?>
                                    in category(s) '<strong><?php echo $categoryList; ?></strong>'
                                <?php endif; ?>
                            </div>
                            <a href="products.php" class="btn btn-sm btn-outline-info">Clear Filters</a>
                        </div>
                    <?php endif; ?>
                </div>

                <div id="productsTableContainer">
                    <?php
                    // Display initial table content using the template
                    include 'product_table_template.php'; 
                    ?>
                </div>

            </div>
        </div>
    </div>

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
        /* 🔥 UPDATED AJAX/FETCH PRODUCTS FUNCTION */
        let fetchTimer;
        
        async function fetchProducts() {
            clearTimeout(fetchTimer);
            
            // Debounce to prevent excessive requests
            fetchTimer = setTimeout(async () => {
                
                const searchInput = document.getElementById('searchInput').value;
                const categoryCheckboxes = document.querySelectorAll("input[name='category[]']:checked");
                const selectedCategories = Array.from(categoryCheckboxes).map(cb => cb.value);

                const tableContainer = document.getElementById('productsTableContainer');
                const statusContainer = document.getElementById('filterStatusContainer');

                // Build the query string for the AJAX request, including the 'ajax=true' flag
                let queryString = `ajax=true&search=${encodeURIComponent(searchInput)}`;
                selectedCategories.forEach(cat => {
                    queryString += `&category[]=${encodeURIComponent(cat)}`;
                });

                // Show loading message in the table container
                tableContainer.innerHTML = `<div id="loadingIndicator"><i class="fas fa-sync fa-spin me-2"></i> Loading products...</div>`;
                
                try {
                    // Send the request to the current file (products.php) with the AJAX flag
                    const response = await fetch(`products.php?${queryString}`);
                    
                    if (!response.ok) {
                        throw new Error('Network response was not ok.');
                    }
                    
                    // Expecting JSON response now
                    const data = await response.json();

                    // Update the filter status container
                    statusContainer.innerHTML = data.status_html;
                    
                    // Update the product table container
                    tableContainer.innerHTML = data.table_html;

                } catch (error) {
                    console.error('Error fetching products:', error);
                    statusContainer.innerHTML = ''; // Clear status if error occurs
                    tableContainer.innerHTML = `
                        <div class="alert alert-danger mt-3" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> 
                            An error occurred while loading products. Please try again.
                        </div>`;
                }
            }, 300); // 300ms debounce time
        }

        /* 🚀 LIVE CATEGORY DROPDOWN JS */
        const categoryBtn = document.getElementById("categoryBtn");
        const categoryPanel = document.getElementById("categoryPanel");
        const applyBtn = document.getElementById("applyBtn");
        const clearBtn = document.getElementById("clearCatBtn");
        const categoryCheckboxes = document.querySelectorAll("input[name='category[]']");

        // Helper function to update the button text
        function updateCategoryButtonText() {
            const checkedCount = document.querySelectorAll("input[name='category[]']:checked").length;
            categoryBtn.innerText = checkedCount === 0 
                ? "Select Categories"
                : checkedCount + " categories selected";
        }

        categoryBtn.addEventListener("click", () => {
            categoryPanel.classList.toggle("show");
        });

        // Event listener on each checkbox for instant filtering
        categoryCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                updateCategoryButtonText();
                fetchProducts(); // Trigger live search/filter
            });
        });

        // 'Apply' button now only serves to close the panel
        applyBtn.addEventListener("click", () => {
            categoryPanel.classList.remove("show");
        });

        clearBtn.addEventListener("click", () => {
            let wasChecked = false;
            categoryCheckboxes.forEach(cb => {
                if (cb.checked) {
                    cb.checked = false;
                    wasChecked = true;
                }
            });
            updateCategoryButtonText();
            categoryPanel.classList.remove("show");
            // Only fetch if something was actually unchecked
            if (wasChecked) {
                 fetchProducts(); 
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", (e) => {
            if (!categoryPanel.contains(e.target) && !categoryBtn.contains(e.target)) {
                categoryPanel.classList.remove("show");
            }
        });

        /* IMAGE MODAL */
        function showImageModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('downloadImage').href = src;
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                 new bootstrap.Modal(document.getElementById('imageModal')).show();
            }
        }

        /* CSV EXPORT */
        function exportTableToCSV(filename) {
            let csv = [];
            const table = document.querySelector("#productsTableContainer table"); 
            if (!table) {
                alert("No products table found to export.");
                return;
            }
            const rows = table.querySelectorAll("tr");
            for (let row of rows) {
                const cols = row.querySelectorAll("td, th");
                const rowData = Array.from(cols).slice(0, -1).map(col => `"${col.innerText.trim().replace(/"/g, '""')}"`);
                csv.push(rowData.join(","));
            }
            const csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
            const link = document.createElement("a");
            link.href = URL.createObjectURL(csvFile);
            link.download = filename;
            link.click();
        }
    </script>

    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
  </main>
</body>
</html>