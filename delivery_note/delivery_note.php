<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Note</title>
    <style>
        .delivery-note {
            max-width: 800px;
            margin: auto;
            padding: 10px;
            border: 2px solid #000;
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            text-decoration: underline;
        }

        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }

        .details-table, .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .details-table td, .items-table td, .items-table th {
            padding: 10px;
            border: 1px solid #000;
            text-align: left;
        }

        .items-table th {
            background-color: #eee;
            font-weight: bold;
        }

        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .signature div {
            text-align: center;
        }

        .stamp {
            margin-top: 10px;
        }

        .download-button {
            text-align: center;
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            background-color: #320f44;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #320f44;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
</head>
<body>
<?php
    include '../connection.php'; // Database connection

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch order data using order_id from the query string
    $orderId = $_GET['order_id'];

    // Query to fetch order and item details
    $query = "SELECT orders.id, orders.AddedDate, customers.CustomerName, orders.LPO,orders.Address, products.ProductName, products.ID AS ProductID, order_items.Quantity
              FROM orders
              JOIN order_items ON orders.ID = order_items.OrderID
              JOIN products ON order_items.ProductID = products.ID
              JOIN customers ON orders.CustomerID = customers.CustomerID
              WHERE orders.ID = ?";
              
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize order data
    $orderData = $result->fetch_assoc();
    $customerName = $orderData['CustomerName'];
    $orderDate = $orderData['AddedDate'];
    $LPO = $orderData['LPO'];  // LPO number
    $address = $orderData['Address'];  // Customer address
?>

    <div id="delivery-note-content" class="delivery-note">
        <div class="header">
            <img src="../assets/img/logo-ct-dark.png" alt="Company Logo" style="width: 100px;"><br>
            <!-- <h2>Mannya Company Limited</h2>
            <p>Tabata Dampo, Mandera Street<br>
            P.O. Box 32055, Dar es Salaam, Tanzania<br>
            Tel: +255 759 222 122 / +255 717 637 204<br>
            Email: mannyacompany60@gmail.com</p> -->
        </div>

        <h1>Store Note</h1>

        <table class="details-table">
            <tr>
                <td><strong>No:</strong> <?php echo $orderId; ?></td>
                <td><strong>Date:</strong> <?php echo date('d/m/Y', strtotime($orderDate)); ?></td>
            </tr>
            <tr>
                <td><strong>M/S:</strong> <?php echo $customerName; ?></td>
                <!-- <td><strong>LPO:</strong> <?php echo $LPO; ?></td>  Echo LPO number  -->
            </tr>
            <tr>
                <td><strong>Address:</strong> <?php echo $address; ?></td> <!-- Display Address -->
                <td><strong>Please receive the following goods</strong></td>
            </tr>
        </table>
        <table class="items-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Product Code</th>
                    <th>Particulars</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Reset the result pointer and fetch all items
                $result->data_seek(0);
                $counter = 1; // Initialize counter for No column
                while ($item = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $counter++ . "</td>";  // Display item number
                    echo "<td>PIP" . $item['ProductID'] . "</td>"; // Display Product Code as MNY<product_id>
                    echo "<td>" . $item['ProductName'] . "</td>"; // Particulars
                    echo "<td>" . $item['Quantity'] . " pcs</td>";  // Quantity
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="signature">
            <div>
                <p>Received the above goods in good order and condition.</p>
                <p>Comment: _______________________________</p>
                <p>Name: _____________________________</p>
                <p>Sign: ______________________________</p>
            </div>
            <!-- <div class="stamp">
                <strong>MANNYA COMPANY LIMITED</strong><br>
                <p>P.O. Box 32055<br>Dar es Salaam</p>
                <p>Date: <?php echo date('d/m/Y', strtotime($orderDate)); ?></p>
            </div> -->
        </div>
    </div>

    <div class="download-button">
        <button id="download-btn">Download Delivery Note</button>
    </div>

    <script>
        document.getElementById('download-btn').addEventListener('click', function () {
            var deliveryNote = document.getElementById('delivery-note-content');
            html2pdf().from(deliveryNote).save('delivery_note_<?php echo $orderId; ?>.pdf');
        });
    </script>

    <?php
        // Close the database connection
        $stmt->close();
        $conn->close();
    ?>
</body>
</html>
