<?php
include '../connection.php';

// Check required tables
$tables = [
    'products',
    'orders',
    'order_items',
    'returns'
];

echo "<h2>Checking Database Tables</h2>";

echo "<h3>Table Status:</h3>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Table</th><th>Exists</th><th>Row Count</th></tr>";

foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    $exists = $result->num_rows > 0 ? 'Yes' : 'No';
    $count = 'N/A';
    
    if ($exists === 'Yes') {
        $countResult = $conn->query("SELECT COUNT(*) as count FROM $table");
        $count = $countResult->fetch_assoc()['count'];
    }
    
    echo "<tr>";
    echo "<td>$table</td>";
    echo "<td>$exists</td>";
    echo "<td>$count</td>";
    echo "</tr>";
}

echo "</table>";

// Check sample data
if (isset($_GET['add_sample']) && $_GET['add_sample'] === '1') {
    echo "<h3>Adding Sample Data...</h3>";
    
    // Add sample products
    $sampleProducts = [
        ["Product 1", 1000, 50],
        ["Product 2", 1500, 0],  // Out of stock
        ["Product 3", 2000, 5]   // Low stock
    ];
    
    foreach ($sampleProducts as $product) {
        $stmt = $conn->prepare("INSERT INTO products (ProductName, Price, Quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("sdi", $product[0], $product[1], $product[2]);
        $stmt->execute();
        $productId = $stmt->insert_id;
        
        echo "Added product: " . $product[0] . " (ID: $productId)<br>";
    }
    
    // Add sample orders
    $sampleOrders = [
        [1, '2025-08-25', 'Approved'],
        [1, '2025-08-26', 'Pending'],
        [2, '2025-08-27', 'Approved']
    ];
    
    foreach ($sampleOrders as $order) {
        $stmt = $conn->prepare("INSERT INTO orders (UserID, OrderDate, Status) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $order[0], $order[1], $order[2]);
        $stmt->execute();
        $orderId = $stmt->insert_id;
        
        echo "Added order: #$orderId<br>";
        
        // Add order items
        $stmt = $conn->prepare("INSERT INTO order_items (OrderID, ProductID, Quantity, Price) VALUES (?, ?, ?, ?)");
        $qty = rand(1, 5);
        $price = rand(1000, 5000);
        $stmt->bind_param("iiid", $orderId, 1, $qty, $price);
        $stmt->execute();
    }
    
    echo "<p>Sample data added. <a href='check_tables.php'>Refresh</a> to see updated counts.</p>";
} else {
    echo "<p><a href='check_tables.php?add_sample=1'>Add Sample Data</a> for testing</p>";
}

$conn->close();
?>

<style>
table { border-collapse: collapse; margin: 20px 0; }
th, td { padding: 8px 12px; text-align: left; border: 1px solid #ddd; }
th { background-color: #f2f2f2; }
</style>
