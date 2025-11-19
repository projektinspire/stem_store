<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include '../connection.php';

// Check if the product ID is set
if (isset($_GET['id'])) {
    $productID = $_GET['id'];

    // Fetch the product details from the database
    $sql = "SELECT * FROM products WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        $_SESSION['error'] = 'Product not found.';
        header("Location: products.php");
        exit();
    }
    $stmt->close();
} else {
    $_SESSION['error'] = 'No product ID provided.';
    header("Location: products.php");
    exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = mysqli_real_escape_string($conn, $_POST['productName']);
    $prod_price = mysqli_real_escape_string($conn, $_POST['prod_price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $prod_cat = mysqli_real_escape_string($conn, $_POST['prod_cat']);
    $productID = $_POST['productID'];

    // Handle the image upload if a new one is provided
    $imagePath = $product['Image']; // Default to existing image
    
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "products/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $imageName = $_FILES['productImage']['name'];
        $imageTmpName = $_FILES['productImage']['tmp_name'];
        $imageFileType = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        
        // Generate unique filename
        $uniqueImageName = time() . '_' . uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $uniqueImageName;
        
        // Validate file
        $uploadOk = 1;
        
        // Check if image file is an actual image
        $check = getimagesize($imageTmpName);
        if ($check === false) {
            $_SESSION['error'] = 'File is not an image.';
            header("Location: edit_product.php?id=$productID");
            exit();
        }

        // Check file size (max 5MB)
        if ($_FILES["productImage"]["size"] > 5000000) {
            $_SESSION['error'] = 'Sorry, your file is too large. Maximum 5MB allowed.';
            header("Location: edit_product.php?id=$productID");
            exit();
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            $_SESSION['error'] = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
            header("Location: edit_product.php?id=$productID");
            exit();
        }

        // Upload the file
        if (move_uploaded_file($imageTmpName, $target_file)) {
            // Delete old image if it exists and is different
            if (!empty($product['Image']) && file_exists($product['Image']) && $product['Image'] !== $target_file) {
                unlink($product['Image']);
            }
            $imagePath = $target_file;
        } else {
            $_SESSION['error'] = 'Sorry, there was an error uploading your file.';
            header("Location: edit_product.php?id=$productID");
            exit();
        }
    }

    // Update the product details
    $sql = "UPDATE products SET ProductName=?, Image=?, Description=?, prod_price=?, Quantity=?, prod_cat=? WHERE ID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdisi", $productName, $imagePath, $description, $prod_price, $quantity, $prod_cat, $productID);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Product updated successfully!';
        header("Location: products.php");
    } else {
        $_SESSION['error'] = 'Error updating product: ' . $conn->error;
        header("Location: edit_product.php?id=$productID");
    }
    $stmt->close();
    $conn->close();
    exit();
}
?>
<?php $pageTitle = 'STEM STORE - Edit Product'; include '../includes/head.php'; ?>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <?php include '../includes/sidebar.php'; ?>

  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <?php include '../includes/navbar.php'; ?>
    <!-- End Navbar -->
 
   <?php
include '../connection.php';

// Check if the product ID is set
if (isset($_GET['id'])) {
    $productID = $_GET['id'];

    // Fetch the product details from the database
    $sql = "SELECT * FROM products WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "<script>alert('Product not found.'); window.location.href='products.php';</script>";
        exit();
    }

    $stmt->close();
} else {
    echo "<script>alert('No product ID provided.'); window.location.href='products.php';</script>";
    exit();
}

// Update the product in the database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = mysqli_real_escape_string($conn, $_POST['productName']);
    $prod_price = mysqli_real_escape_string($conn, $_POST['prod_price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $prod_cat = mysqli_real_escape_string($conn, $_POST['prod_cat']);
    $productID = $_POST['productID'];

    // Handle the image upload if a new one is provided
    $imagePath = $product['Image']; // Default to existing image
    
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "products/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $imageName = $_FILES['productImage']['name'];
        $imageTmpName = $_FILES['productImage']['tmp_name'];
        $imageFileType = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        
        // Generate unique filename
        $uniqueImageName = time() . '_' . uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $uniqueImageName;
        
        // Validate file
        $uploadOk = 1;
        
        // Check if image file is an actual image
        $check = getimagesize($imageTmpName);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "<script>alert('File is not an image.'); window.history.back();</script>";
            exit();
        }

        // Check file size (max 5MB)
        if ($_FILES["productImage"]["size"] > 5000000) {
            echo "<script>alert('Sorry, your file is too large. Maximum 5MB allowed.'); window.history.back();</script>";
            exit();
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.'); window.history.back();</script>";
            exit();
        }

        // Upload the file
        if ($uploadOk == 1) {
            if (move_uploaded_file($imageTmpName, $target_file)) {
                // Delete old image if it exists and is different
                if (!empty($product['Image']) && file_exists($product['Image']) && $product['Image'] !== $target_file) {
                    unlink($product['Image']);
                }
                $imagePath = $target_file;
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.'); window.history.back();</script>";
                exit();
            }
        }
    }

    // Update the product details with correct column names
    $sql = "UPDATE products SET ProductName=?, Image=?, Description=?, prod_price=?, Quantity=?, prod_cat=? WHERE ID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdisi", $productName, $imagePath, $description, $prod_price, $quantity, $prod_cat, $productID);

    if ($stmt->execute()) {
        // Redirect after successful update with success message
        $success_message = urlencode("Product updated successfully!");
        header("Location: products.php?success=1&message=$success_message");
        exit();
    } else {
        echo "<script>alert('Error updating product: " . $conn->error . "'); window.history.back();</script>";
        exit();
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>

    <style>
        .card-header {
            background-color: white;
            color: black;
            border-bottom: 1px solid #ddd;
        }
        .btn-primary {
            background-color: #00dbe5;
            border-color: #00dbe5;
            color: #320F44;
        }
        .btn-primary:hover {
            background-color: #00b8c4;
            border-color: #00b8c4;
            color: #320F44;
        }
        .current-image {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
    <!-- HTML Form for editing the product -->
    <div class="container-fluid py-4 d-flex justify-content-center align-items-center min-vh-100">
        <div class="row w-100">
            <div class="col-lg-6 col-md-8 col-sm-10 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h6>Edit Product</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="edit_product.php?id=<?php echo htmlspecialchars($product['ID']); ?>" enctype="multipart/form-data">
                            <!-- Hidden input for product ID -->
                            <input type="hidden" name="productID" value="<?php echo htmlspecialchars($product['ID']); ?>">

                            <!-- Product Name -->
                            <div class="form-group mb-3">
                                <label for="productName" class="form-label">Product Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="productName" name="productName" value="<?php echo htmlspecialchars($product['ProductName']); ?>" required>
                            </div>

                            <!-- Product Image -->
                            <div class="form-group mb-3">
                                <label for="productImage" class="form-label">Product Image</label>
                                <input type="file" class="form-control" id="productImage" name="productImage" accept="image/*">
                                <small class="text-muted">Supported formats: JPG, JPEG, PNG, GIF (Max: 5MB)</small>
                                <!-- Show current image -->
                                <?php if (!empty($product['Image'])): ?>
                                    <div class="mt-2">
                                        <label class="form-label">Current Image:</label><br>
                                        <img src="<?php echo htmlspecialchars($product['Image']); ?>" alt="Current Product Image" class="current-image">
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Product Price -->
                            <div class="form-group mb-3">
                                <label for="prod_price" class="form-label">Product Price (Tsh) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="prod_price" name="prod_price" value="<?php echo htmlspecialchars($product['prod_price']); ?>" step="0.01" min="0" required>
                            </div>

                            <!-- Product Category -->
                            <div class="form-group mb-3">
                                <label for="prod_cat" class="form-label">Product Category</label>
                                <select class="form-control" id="prod_cat" name="prod_cat">
                                    <option value="">Select category (Optional)</option>
                                    <option value="Agriculture" <?php echo (isset($product['prod_cat']) && $product['prod_cat'] == 'Agriculture') ? 'selected' : ''; ?>>Agriculture</option>
                                    <option value="Chemistry Tools" <?php echo (isset($product['prod_cat']) && $product['prod_cat'] == 'Chemistry Tools') ? 'selected' : ''; ?>>Chemistry Tools</option>
                                    <option value="Electronics" <?php echo (isset($product['prod_cat']) && $product['prod_cat'] == 'Electronics') ? 'selected' : ''; ?>>Electronics</option>
                                    <option value="Engineering Devices" <?php echo (isset($product['prod_cat']) && $product['prod_cat'] == 'Engineering Devices') ? 'selected' : ''; ?>>Engineering Devices</option>
                                    <option value="Hospital" <?php echo (isset($product['prod_cat']) && $product['prod_cat'] == 'Hospital') ? 'selected' : ''; ?>>Hospital</option>
                                    <option value="ICT" <?php echo (isset($product['prod_cat']) && $product['prod_cat'] == 'ICT') ? 'selected' : ''; ?>>ICT</option>
                                    <option value="Instruments" <?php echo (isset($product['prod_cat']) && $product['prod_cat'] == 'Instruments') ? 'selected' : ''; ?>>Instruments</option>
                                    <option value="Kitchen Equipment" <?php echo (isset($product['prod_cat']) && $product['prod_cat'] == 'Kitchen Equipment') ? 'selected' : ''; ?>>Kitchen Equipment</option>
                                    <option value="Office" <?php echo (isset($product['prod_cat']) && $product['prod_cat'] == 'Office') ? 'selected' : ''; ?>>Office</option>
                                    <option value="Protective Gears" <?php echo (isset($product['prod_cat']) && $product['prod_cat'] == 'Protective Gears') ? 'selected' : ''; ?>>Protective Gears</option>
                                    <option value="Stationery" <?php echo (isset($product['prod_cat']) && $product['prod_cat'] == 'Stationery') ? 'selected' : ''; ?>>Stationery</option>
                                </select>
                            </div>

                            <!-- Quantity -->
                            <div class="form-group mb-3">
                                <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo htmlspecialchars($product['Quantity']); ?>" min="0" required>
                            </div>

                            <!-- Description -->
                            <div class="form-group mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($product['Description']); ?></textarea>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="text-end">
                                <a href="products.php" class="btn btn-secondary me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
      <?php include '../includes/footer.php'; ?>
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