<?php
include '../connection.php';

// Set timezone
date_default_timezone_set('Africa/Dar_es_Salaam');

// Function to fetch sales report data
function fetchSalesReport($conn, $period, $startDate = null, $endDate = null, $orderNo = null) {
    $whereClause = "WHERE o.Status = 'Approved' ";
    $params = [];
    $types = '';
    
    // Handle date range
    if ($period === 'custom' && $startDate && $endDate) {
        $whereClause .= "AND o.AddedDate BETWEEN ? AND ? ";
        $params[] = $startDate . ' 00:00:00';
        $params[] = $endDate . ' 23:59:59';
        $types .= 'ss';
    } else {
        $interval = match($period) {
            'Daily' => '1 DAY',
            'Weekly' => '1 WEEK',
            'Monthly' => '1 MONTH',
            'Annual' => '1 YEAR',
            default => '1 MONTH',
        };
        $whereClause .= "AND o.AddedDate >= NOW() - INTERVAL $interval ";
    }

    // Prepare the SQL statement
    $sql = "
        SELECT 
            o.ID AS OrderNo,
            o.UserID, 
            p.ProductName,  
            oi.Price AS ProductCost, 
            o.Status, 
            SUM(oi.Quantity) AS QuantitySold,
            SUM(oi.Price * oi.Quantity) AS TotalRevenue
        FROM orders o
        JOIN order_items oi ON o.ID = oi.OrderID
        JOIN products p ON oi.ProductID = p.ID  
        WHERE o.Status = 'Approved' AND o.AddedDate >= NOW() - INTERVAL $interval
    ";

    // Add search condition for Order No if provided
    if ($orderNo) {
        $sql .= " AND o.ID = ?";
    }

    $sql .= " GROUP BY p.ProductName, o.ID, o.UserID, o.Status
              ORDER BY TotalRevenue DESC;";

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);

    if ($orderNo) {
        $stmt->bind_param('i', $orderNo); // Bind the parameter for Order No
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// Get report parameters from the URL
$period = $_GET['period'] ?? 'Monthly';
$startDate = $_GET['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
$endDate = $_GET['end_date'] ?? date('Y-m-d');
$orderNo = $_GET['order_no'] ?? null;
$reportType = $_GET['report_type'] ?? 'sales'; // sales, inventory, returns, new_stock
$exportType = $_GET['export'] ?? null; // pdf, excel, csv

// Fetch data based on report type
$reportData = [];
$summaryData = [];

switch ($reportType) {
    case 'inventory':
        // Out of stock and low stock items
        $sql = "SELECT ID, ProductName, Quantity, Price, 
                       CASE 
                           WHEN Quantity = 0 THEN 'Out of Stock' 
                           WHEN Quantity <= 5 THEN 'Low Stock' 
                           ELSE 'In Stock' 
                       END as StockStatus
                FROM products 
                ORDER BY Quantity ASC, ProductName";
        $reportData = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
        break;
        
    case 'new_stock':
        // Recently added products (last 30 days)
        $sql = "SELECT ID, ProductName, Quantity, Price, AddedDate 
                FROM products 
                WHERE AddedDate >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                ORDER BY AddedDate DESC";
        $reportData = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
        break;
        
    case 'returns':
        // Returned products
        $sql = "SELECT r.ReturnID, o.ID as OrderID, p.ProductName, r.Quantity, r.Reason, r.ReturnDate, r.Status
                FROM returns r
                JOIN orders o ON r.OrderID = o.ID
                JOIN products p ON r.ProductID = p.ID
                ORDER BY r.ReturnDate DESC";
        $reportData = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
        break;
        
    case 'sales':
    default:
        // Sales report (default)
        $reportData = fetchSalesReport($conn, $period, $startDate, $endDate, $orderNo);
        
        // Calculate summary data
        $totalSales = 0;
        $productSales = [];
        
        foreach ($reportData as $row) {
            $totalSales += $row['TotalRevenue'];
            if (!isset($productSales[$row['ProductName']])) {
                $productSales[$row['ProductName']] = [
                    'count' => $row['QuantitySold'],
                    'revenue' => $row['TotalRevenue']
                ];
            } else {
                $productSales[$row['ProductName']]['count'] += $row['QuantitySold'];
                $productSales[$row['ProductName']]['revenue'] += $row['TotalRevenue'];
            }
        }
        
        // Get most sold product
        $mostSoldProduct = '';
        $mostSoldCount = 0;
        foreach ($productSales as $product => $data) {
            if ($data['count'] > $mostSoldCount) {
                $mostSoldCount = $data['count'];
                $mostSoldProduct = $product;
            }
        }
        
        $summaryData = [
            'total_sales' => $totalSales,
            'total_orders' => count(array_unique(array_column($reportData, 'OrderNo'))),
            'most_sold_product' => $mostSoldProduct ?: 'No products sold',
            'most_sold_count' => $mostSoldCount
        ];
        break;
}

// Handle exports
if ($exportType) {
    switch ($exportType) {
        case 'pdf':
            // Use existing PDF export
            break;
            
        case 'excel':
        case 'csv':
            $filename = $reportType . '_report_' . date('Y-m-d') . ($exportType === 'excel' ? '.xlsx' : '.csv');
            $delimiter = $exportType === 'excel' ? "\t" : ",";
            
            header('Content-Type: text/' . ($exportType === 'excel' ? 'vnd.ms-excel' : 'csv'));
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            $output = fopen('php://output', 'w');
            
            // Output headers
            if (!empty($reportData)) {
                fputcsv($output, array_keys($reportData[0]), $delimiter);
                
                // Output data
                foreach ($reportData as $row) {
                    fputcsv($output, $row, $delimiter);
                }
            }
            
            fclose($output);
            exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php echo ucfirst($reportType); ?> Report - <?php echo htmlspecialchars($period); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .report-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            font-size: 16px;
            color: #555;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .total {
            font-weight: bold;
        }
        .most-sold {
            background-color: #eee;
            padding: 10px;
            font-weight: bold;
        }
        .btn-download {
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 10px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin: 10px 0;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }
        .btn-download:hover {
            background-color: #45a049; /* Darker green */
        }
        .medium-input {
            width: 50%; /* Adjust the width for medium size */
            padding: 5px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="h4 mb-0">
                        <i class="fas fa-chart-line me-2"></i>
                        <?php echo ucfirst($reportType); ?> Report
                    </h2>
                    <div>
                        <a href="?report_type=<?php echo $reportType; ?>&export=pdf" class="btn btn-sm btn-light me-2">
                            <i class="fas fa-file-pdf me-1"></i> PDF
                        </a>
                        <a href="?report_type=<?php echo $reportType; ?>&export=excel" class="btn btn-sm btn-light me-2">
                            <i class="fas fa-file-excel me-1"></i> Excel
                        </a>
                        <a href="?report_type=<?php echo $reportType; ?>&export=csv" class="btn btn-sm btn-light">
                            <i class="fas fa-file-csv me-1"></i> CSV
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <!-- Report Filters -->
                <form method="GET" action="" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Report Type</label>
                            <select name="report_type" class="form-select" onchange="this.form.submit()">
                                <option value="sales" <?php echo $reportType === 'sales' ? 'selected' : ''; ?>>Sales Report</option>
                                <option value="inventory" <?php echo $reportType === 'inventory' ? 'selected' : ''; ?>>Inventory Status</option>
                                <option value="new_stock" <?php echo $reportType === 'new_stock' ? 'selected' : ''; ?>>New Stock</option>
                                <option value="returns" <?php echo $reportType === 'returns' ? 'selected' : ''; ?>>Returns</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3">
                            <label class="form-label">Time Period</label>
                            <select name="period" class="form-select" id="periodSelect">
                                <option value="Daily" <?php echo $period === 'Daily' ? 'selected' : ''; ?>>Today</option>
                                <option value="Weekly" <?php echo $period === 'Weekly' ? 'selected' : ''; ?>>This Week</option>
                                <option value="Monthly" <?php echo $period === 'Monthly' ? 'selected' : ''; ?>>This Month</option>
                                <option value="Annual" <?php echo $period === 'Annual' ? 'selected' : ''; ?>>This Year</option>
                                <option value="custom" <?php echo $period === 'custom' ? 'selected' : ''; ?>>Custom Range</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6" id="dateRangeContainer" style="display: <?php echo $period === 'custom' ? 'block' : 'none'; ?>">
                            <div class="row">
                                <div class="col">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" name="start_date" class="form-control" value="<?php echo $startDate; ?>">
                                </div>
                                <div class="col">
                                    <label class="form-label">End Date</label>
                                    <input type="date" name="end_date" class="form-control" value="<?php echo $endDate; ?>">
                                </div>
                            </div>
                        </div>
                        
                        <?php if ($reportType === 'sales'): ?>
                        <div class="col-md-3">
                            <label class="form-label">Order Number</label>
                            <input type="text" name="order_no" class="form-control" placeholder="Search by Order No" value="<?php echo htmlspecialchars($orderNo); ?>">
                        </div>
                        <?php endif; ?>
                        
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-filter me-1"></i> Apply Filters
                            </button>
                            <a href="?report_type=<?php echo $reportType; ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-sync-alt me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
                
                <!-- Report Summary Cards -->
                <?php if ($reportType === 'sales' && !empty($summaryData)): ?>
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Total Sales</h6>
                                <h3 class="mb-0">TZS <?php echo number_format($summaryData['total_sales'], 2); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Total Orders</h6>
                                <h3 class="mb-0"><?php echo $summaryData['total_orders']; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Most Sold Product</h6>
                                <h5 class="mb-0"><?php echo htmlspecialchars($summaryData['most_sold_product']); ?></h5>
                                <small>Qty: <?php echo $summaryData['most_sold_count']; ?></small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
        <!-- Report Content -->
                <div class="table-responsive">
                    <?php if ($reportType === 'sales'): ?>
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Order No</th>
                                <th>Date</th>
                                <th>Product</th>
                                <th class="text-end">Qty</th>
                                <th class="text-end">Price (TZS)</th>
                                <th class="text-end">Total (TZS)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($reportData)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4">No sales data found for the selected period.</td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($reportData as $data): ?>
                                <tr>
                                    <td>#<?php echo htmlspecialchars($data['OrderNo']); ?></td>
                                    <td><?php 
                                        $dateField = $data['OrderDate'] ?? ($data['AddedDate'] ?? null);
                                        echo $dateField ? date('M d, Y', strtotime($dateField)) : 'N/A'; 
                                    ?></td>
                                    <td><?php echo htmlspecialchars($data['ProductName']); ?></td>
                                    <td class="text-end"><?php echo number_format($data['QuantitySold']); ?></td>
                                    <td class="text-end"><?php echo number_format($data['ProductCost'], 2); ?></td>
                                    <td class="text-end fw-bold"><?php echo number_format($data['TotalRevenue'], 2); ?></td>
                                    <td>
                                        <span class="badge bg-<?php 
                                            echo match($data['Status']) {
                                                'Approved' => 'success',
                                                'Pending' => 'warning',
                                                'Cancelled' => 'danger',
                                                default => 'secondary'
                                            };
                                        ?>">
                                            <?php echo htmlspecialchars($data['Status']); ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    
                    <?php elseif ($reportType === 'inventory'): ?>
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th class="text-end">In Stock</th>
                                <th class="text-end">Price (TZS)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($reportData)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4">No inventory data found.</td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($reportData as $item): ?>
                                <tr>
                                    <td>#<?php echo $item['ID']; ?></td>
                                    <td><?php echo htmlspecialchars($item['ProductName']); ?></td>
                                    <td class="text-end"><?php echo number_format($item['Quantity']); ?></td>
                                    <td class="text-end"><?php echo number_format($item['Price'], 2); ?></td>
                                    <td>
                                        <span class="badge bg-<?php 
                                            echo match($item['StockStatus']) {
                                                'Out of Stock' => 'danger',
                                                'Low Stock' => 'warning',
                                                default => 'success'
                                            };
                                        ?>">
                                            <?php echo $item['StockStatus']; ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    
                    <?php elseif ($reportType === 'new_stock'): ?>
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th class="text-end">Quantity</th>
                                <th class="text-end">Price (TZS)</th>
                                <th>Date Added</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($reportData)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4">No new stock added recently.</td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($reportData as $item): ?>
                                <tr>
                                    <td>#<?php echo $item['ID']; ?></td>
                                    <td><?php echo htmlspecialchars($item['ProductName']); ?></td>
                                    <td class="text-end"><?php echo number_format($item['Quantity']); ?></td>
                                    <td class="text-end"><?php echo number_format($item['Price'], 2); ?></td>
                                    <td><?php echo !empty($item['AddedDate']) ? date('M d, Y', strtotime($item['AddedDate'])) : 'N/A'; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    
                    <?php elseif ($reportType === 'returns'): ?>
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Return ID</th>
                                <th>Order #</th>
                                <th>Product</th>
                                <th class="text-end">Qty</th>
                                <th>Reason</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($reportData)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4">No return records found.</td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($reportData as $return): ?>
                                <tr>
                                    <td>#<?php echo $return['ReturnID']; ?></td>
                                    <td>#<?php echo $return['OrderID']; ?></td>
                                    <td><?php echo htmlspecialchars($return['ProductName']); ?></td>
                                    <td class="text-end"><?php echo $return['Quantity']; ?></td>
                                    <td><?php echo htmlspecialchars($return['Reason']); ?></td>
                                    <td><?php echo !empty($return['ReturnDate']) ? date('M d, Y', strtotime($return['ReturnDate'])) : 'N/A'; ?></td>
                                    <td>
                                        <span class="badge bg-<?php 
                                            echo match($return['Status']) {
                                                'Processed' => 'success',
                                                'Pending' => 'warning',
                                                'Rejected' => 'danger',
                                                default => 'secondary'
                                            };
                                        ?>">
                                            <?php echo $return['Status']; ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="card-footer text-muted">
                <small>Report generated on <?php echo date('F j, Y, g:i a'); ?></small>
                <div class="float-end">
                    <button class="btn btn-sm btn-outline-secondary me-2" onclick="window.print()">
                        <i class="fas fa-print me-1"></i> Print
                    </button>
                    <a href="?report_type=<?php echo $reportType; ?>&export=pdf" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-file-pdf me-1"></i> Save as PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Toggle date range fields based on period selection
        document.getElementById('periodSelect').addEventListener('change', function() {
            const dateRangeContainer = document.getElementById('dateRangeContainer');
            dateRangeContainer.style.display = this.value === 'custom' ? 'block' : 'none';
        });
        
        // Initialize Select2 for better dropdowns
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        });
        
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
