<?php
// Initialize variables with default values
$orderId = isset($_GET['OrderID']) ? intval($_GET['OrderID']) : 0;
$customerName = isset($_GET['customerName']) ? htmlspecialchars($_GET['customerName']) : 'N/A';
$totalCost = isset($_GET['totalCost']) ? floatval($_GET['totalCost']) : 0.0;
$paymentMethod = isset($_GET['paymentMethod']) ? htmlspecialchars($_GET['paymentMethod']) : 'N/A';
$productsJson = isset($_GET['products']) ? $_GET['products'] : '[]';

// Decode products JSON into an array
$products = json_decode($productsJson, true) ?? [];

// Calculate totals
$totalWithoutVAT = 0;
$vatRate = 0.18;

if (!empty($products) && is_array($products)) {
    foreach ($products as $product) {
        $totalWithoutVAT += $product['Quantity'] * $product['Price'];
    }
}

// Correct VAT calculation
$vatAmount = $totalWithoutVAT * (18 / 118); // VAT is calculated separately but not added to the total
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
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
            flex-wrap: wrap;
        }

        .customer-details, .invoice-details {
            width: 48%;
            text-align: center;
            margin-bottom: 10px;
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

        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }

        .signature-section div {
            width: 48%;
            text-align: center;
        }

        .download-button {
            display: flex;
            justify-content: center;
            margin-top: 20px;
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

        button:disabled {
            background-color: #6c757d;
            cursor: not-allowed;
        }

        .edit-button {
            background-color: #007bff;
            margin-left: 10px;
        }

        .edit-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="invoice-container" id="invoice-content-<?php echo $orderId; ?>">
        <div class="header">
            <img src="../assets/img/logo-ct-dark.png" alt="Company Logo">
            <h1>MANNYA COMPANY LIMITED</h1>
            <p>Tabata Old Dampo, Mandera Street, P.O. Box 32055, Dar es Salaam, Tanzania</p>
            <p>Tel: +255 759 222 122 / +255 717 637 204 | Email: mannyacompany60@gmail.com</p>
            <p>TIN: 152-373-864 | VRN: 40316264X</p>
        </div>

        <div class="company-customer-info">
            <div class="customer-details">
                <p><strong>Customer:</strong> <?php echo htmlspecialchars($customerName); ?></p>
                <p><strong>Date:</strong> <?php echo date('Y-m-d'); ?></p>
            </div>
            <div class="invoice-details">
                <p><strong>Proforma Invoice No:</strong> <?php echo htmlspecialchars($orderId); ?></p>
                <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($paymentMethod); ?></p>
            </div>
        </div>

        <table class="details-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $counter = 1;
                foreach ($products as $product) {
                    $lineTotal = $product['Quantity'] * $product['Price'];
                    echo "<tr>
                        <td>{$counter}</td>
                        <td>" . htmlspecialchars($product['ProductName']) . "</td>
                        <td>{$product['Quantity']}</td>
                        <td>Tzs " . number_format($product['Price'], 2) . "</td>
                        <td>Tzs " . number_format($lineTotal, 2) . "</td>
                    </tr>";
                    $counter++;
                }
                ?>
                <tr>
                    <td colspan="4"><strong>VAT (18%):</strong></td>
                    <td>Tzs <?php echo number_format($vatAmount, 2); ?></td>
                </tr>
                <tr>
                    <td colspan="4"><strong>Total (Excl. VAT):</strong></td>
                    <td>Tzs <?php echo number_format($totalWithoutVAT, 2); ?></td>
                </tr>
            </tbody>
        </table>

        <!-- Signature Section -->
        <div class="signature-section">
            <div>
                <p><strong>For MANNYA COMPANY LIMITED</strong></p>
                <p>______________________________</p>
                <p><strong>Authorized Signatory</strong></p>
            </div>
            <div>
                <p><strong>Receiver</strong></p>
                <p>______________________________</p>
                <p><strong>Signature</strong></p>
            </div>
        </div>
    </div>

    <div class="download-button">
        <button id="download-btn" onclick="downloadInvoice(<?php echo $orderId; ?>)">Download Invoice</button>
        <button class="edit-button" onclick="editInvoice(<?php echo $orderId; ?>)">Edit Proforma Invoice</button>
    </div>

    <!-- Include html2pdf library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <script>
        function downloadInvoice(orderID) {
            const element = document.getElementById('invoice-content-' + orderID);
            
            // Disable the button to prevent multiple clicks
            const downloadButton = document.getElementById('download-btn');
            downloadButton.disabled = true;

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
                .save()
                .then(function () {
                    // Re-enable the button after the download is complete
                    downloadButton.disabled = false;
                });
        }

        function editInvoice(orderID) {
            // Redirect to the edit page with the order ID and other necessary data
            const customerName = "<?php echo urlencode($customerName); ?>";
            const totalCost = "<?php echo $totalCost; ?>";
            const paymentMethod = "<?php echo urlencode($paymentMethod); ?>";
            const products = "<?php echo urlencode($productsJson); ?>";

            window.location.href = `edit_invoice.php?OrderID=${orderID}&customerName=${customerName}&totalCost=${totalCost}&paymentMethod=${paymentMethod}&products=${products}`;
        }
    </script>
</body>
</html>