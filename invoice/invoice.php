<?php 
include '../connection.php';

// Check if tax is included in the total (passed from previous page)
$includeTax = isset($_GET['includeTax']) && $_GET['includeTax'] == '1';
$taxRate = 0.18;

// Check if the OrderID is provided via URL
if (!isset($_GET['OrderID'])) {
    echo "No order ID specified.";
    exit;
}

$orderID = intval($_GET['OrderID']); // Sanitize input to prevent SQL injection

// SQL query to fetch specific order details including the order date and customer address
$sql = "
    SELECT 
        o.ID AS OrderID, 
        o.UserID, 
        o.CustomerID, 
        c.CustomerName, 
        c.TINNumber, 
        c.VRN, 
        o.LPO, 
        o.Address,           -- Fetch customer address
        o.TotalPrice, 
        o.Status, 
        o.PaymentMode, 
        o.AddedDate AS OrderDate, 
        p.ID AS ProductID,
        p.ProductName, 
        oi.Quantity, 
        oi.Price
    FROM orders o
    JOIN order_items oi ON o.ID = oi.OrderID
    JOIN customers c ON o.CustomerID = c.CustomerID
    JOIN products p ON oi.ProductID = p.ID
    WHERE o.ID = $orderID
    ORDER BY o.ID DESC
";

// Execute query
$result = $conn->query($sql);

$orderDetails = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Build order details array for this specific order
        if (!isset($orderDetails[$orderID])) {
            $orderDetails[$orderID] = [
                'customerName' => $row['CustomerName'],
                'TINNumber' => $row['TINNumber'],
                'VRN' => $row['VRN'],
                'LPO' => $row['LPO'],
                'address' => $row['Address'], // Capture the customer address
                'TotalPrice' => $row['TotalPrice'],
                'PaymentMode' => $row['PaymentMode'],
                'orderDate' => $row['OrderDate'],
                'products' => []
            ];
        }

        // Generate Code Number (e.g., MNY12345 without padding zeros)
        $codeNumber = 'MNY' . $row['ProductID'];

        // Add product information to the specific order
        $orderDetails[$orderID]['products'][] = [
            'ProductName' => $row['ProductName'],
            'Quantity' => $row['Quantity'],
            'Price' => $row['Price'],
            'CodeNumber' => $codeNumber  // Add Code Number to product
        ];
    }
} else {
    echo "Order not found.";
    exit;
}

function numberToWords($number) {
    // Function remains unchanged
    $words = [
        0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five', 
        6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten', 
        11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen', 
        15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty', 
        50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
    ];

    if ($number < 21) return $words[$number];
    if ($number < 100) return $words[floor($number / 10) * 10] . ' ' . $words[$number % 10];
    if ($number < 1000) return $words[floor($number / 100)] . ' Hundred ' . numberToWords($number % 100);
    if ($number < 1000000) return numberToWords(floor($number / 1000)) . ' Thousand ' . numberToWords($number % 1000);
    return numberToWords(floor($number / 1000000)) . ' Million ' . numberToWords($number % 1000000);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Invoice</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
    }

    .invoice-container {
        max-width: 800px;
        margin: auto;
        border: 2px solid black;
        padding: 20px;
    }

    .header {
        text-align: center;
    }

    .header img {
        width: 100px;
        margin-bottom: 10px;
    }

    .header h1 {
        margin: 0;
        font-size: 24px;
        text-transform: uppercase;
    }

    .company-customer-info {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        flex-wrap: wrap; /* Allow content to wrap on small screens */
    }

    .customer-details, .invoice-details {
        width: 48%;
        text-align: center;
        margin-bottom: 10px; /* Add space between sections on small screens */
    }

    .customer-details p, .invoice-details p {
        margin: 4px 0;
    }

    .details-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .details-table th, .details-table td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    .details-table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .totals {
        margin-top: 20px;
    }

    .totals div {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
    }

    .signatures {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
        flex-wrap: wrap; /* Allow signatures to wrap on smaller screens */
    }

    .signatures div {
        text-align: center;
        width: 30%;
        margin-bottom: 10px; /* Add space between signatures on small screens */
    }

    .signature-line {
        margin-top: 40px;
        border-top: 1px solid black;
        width: 100%;
    }

    .bank-info {
        margin-top: 30px;
    }

    .bank-info div {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
    }

    .stamp {
        margin-top: 10px;
        text-align: center;
    }

    .download-button {
        display: flex;
        justify-content: center;
        margin: 20px 0;
    }

    button {
        padding: 10px 20px;
        background-color: #28a745;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background-color: #320f44;
    }

    /* Mobile-friendly adjustments */
    @media (max-width: 768px) {
        .header h1 {
            font-size: 20px; /* Reduce the size of the title */
        }

        .company-customer-info {
            flex-direction: column; /* Stack customer and invoice details vertically */
            align-items: center; /* Center align the content */
        }

        .customer-details, .invoice-details {
            width: 100%; /* Make them full width on small screens */
            text-align: left; /* Align text to the left */
        }

        .signatures div {
            width: 100%; /* Make signatures take full width */
            margin-bottom: 20px; /* Add space between signature blocks */
        }

        .details-table th, .details-table td {
            font-size: 14px; /* Reduce font size of table text */
            padding: 6px; /* Reduce padding for smaller screens */
        }
    }

    @media (max-width: 480px) {
        .header img {
            width: 80px; /* Make logo smaller */
        }

        .header h1 {
            font-size: 18px; /* Further reduce title size */
        }

        button {
            font-size: 14px; /* Reduce button font size */
            padding: 8px 16px; /* Reduce button size */
        }
    }
    
</style>
</head>
<body>

<?php if (!empty($orderDetails)) : ?>
    <?php foreach ($orderDetails as $orderID => $order): ?>
        <div id="invoice-content-<?php echo $orderID; ?>" class="invoice-container">
            <div class="header">
                <img src="../assets/img/logo-ct-dark.png" alt="Company Logo">
                <h1>Mannya Company Limited</h1>
                <p>Tabata Old Dampo, Mandera Street<br>
                   P.O. Box 32055, Dar es Salaam, Tanzania<br>
                   Tel: +255 759 222 122 / +255 717 637 204<br>
                   Email: mannyacompany60@gmail.com<br>
                   TIN: 152-373-864<br>
                   VRN:40316264X</p>
            </div>           
            <div class="company-customer-info">
                <div class="customer-details">
                    <p><strong>Customer:</strong> <?php echo $order['customerName']; ?></p>
                    <p><strong>TIN:</strong> <?php echo $order['TINNumber']; ?></p>
                    <p><strong>VRN:</strong> <?php echo $order['VRN']; ?></p>
                </div>
                <div class="invoice-details">
    <p><strong>Tax Invoice No:</strong> MNY <?php 
        $invoiceYear = date('Y', strtotime($order['orderDate']));
        $invoiceMonth = date('m', strtotime($order['orderDate']));
        $invoiceDay = date('d', strtotime($order['orderDate']));
        $invoiceNo = $orderID;
        echo "$invoiceYear 0$invoiceNo-$invoiceMonth-$invoiceDay"; 
    ?></p>
    <p><strong>Date:</strong> <?php echo date('Y-m-d', strtotime($order['orderDate'])); ?></p>
    <p><strong>Address:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
    <p><strong>LPO:</strong> <?php echo htmlspecialchars($order['LPO']); ?></p>
</div>
            </div>
<table class="details-table">
    <thead>
        <tr>
            <th>No.</th>
            <th>Code Number</th>
            <th>Description</th>
            <th>Qty</th>
            <th>Unit Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Total invoice amount
        $totalInvoiceAmount = 0;

        // Fetch tax inclusion setting from sales page
        $isTaxInclusive = $order['isTaxInclusive'] ?? false; // Default to false if not set

        // Loop through products and calculate totals
        foreach ($order['products'] as $index => $product) {
            // Determine unit price and product total based on tax inclusion
            $unitPrice = $isTaxInclusive ? $product['Price'] / 1.18 : $product['Price'];
            $productTotal = $unitPrice * $product['Quantity'];
            $totalInvoiceAmount += $productTotal;

            // Render row
            ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo $product['CodeNumber']; ?></td> <!-- Display Code Number -->
                <td><?php echo $product['ProductName']; ?></td>
                <td><?php echo $product['Quantity']; ?></td>
                <td>Tzs <?php echo number_format($unitPrice, 2); ?></td>
                <td>Tzs <?php echo number_format($productTotal, 2); ?></td>
            </tr>
        <?php } ?>

   <!-- VAT Row -->
<tr>
    <td colspan="5" style="text-align: right;"><strong>VAT (18%)</strong></td>
    <td>
        Tzs <?php echo number_format($totalInvoiceAmount * (18 / 118), 2); ?>
    </td>
</tr>
<?php
    // Calculate the total amount including tax, ensuring consistency
    $totalAmount = $includeTax ? $order['TotalPrice'] * (1 + $taxRate) : $order['TotalPrice'];
?>
        <!-- Total Row -->
        <tr>
    <td colspan="5" style="text-align: right;"><strong>Total</strong></td>
    <td>Tsh <?= number_format($totalAmount, 2) ?></td>
</tr>
    </tbody>
</table>
<div class="bank-info">
    <p>Amount in Words: <?php echo numberToWords($totalAmount); ?></p>
    <p><strong>Bank Details:</strong></p>
        <p>Local Currency (CRDB Account): <strong>0150595789000</strong> - MANNYA COMPANY LTD</p>
        <p>US Dollar Account: <strong>0250595789000</strong> - MANNYA COMPANY LTD</p>
</div>     
            <div class="signatures">
                <div>
                    <p>MANNNYA COMPANY LIMITED</p><br>
                    <div>..................................................</div>
                    <p>(Signature, full name, stamp, date)</p>
                </div>
                <div>
                    <p>RECEIVER</p><br>
                    <div>..................................................</div>
                    <p>(Signature, full name, date)</p>
                </div>
            </div>
        </div>
        <div class="download-button">
            <button onclick="downloadInvoice('<?php echo $orderID; ?>')">Download Invoice</button>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
    function downloadInvoice(orderID) {
        const element = document.getElementById('invoice-content-' + orderID);
        
        // Define A4 dimensions in points (1 inch = 72 points, A4 is 210mm x 297mm or ~8.27in x 11.69in)
        const a4 = {
            unit: 'mm',
            format: [210, 297],
            orientation: 'portrait' // Use 'landscape' if you prefer
        };

        // Generate the PDF
        html2pdf()
            .set({
                margin: [10, 10, 10, 10], // Margins in mm
                filename: `Invoice-${orderID}.pdf`,
                html2canvas: { scale: 3 }, // Increase resolution for better quality
                jsPDF: a4
            })
            .from(element)
            .save();
    }
</script>
</body>
</html>
