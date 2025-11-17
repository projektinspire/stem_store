<?php
// Include database connection file
include '../connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect form data
    $productName = mysqli_real_escape_string($conn, $_POST['productName']);
    $prod_price = mysqli_real_escape_string($conn, $_POST['prod_price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $prod_cat = mysqli_real_escape_string($conn, $_POST['prod_cat']);
    $addedDate = date("Y-m-d H:i:s");

    // Image upload handling
    $target_dir = "products/"; // Directory to store product images
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
    }
    
    $imageName = $_FILES['productImage']['name'];
    $imageTmpName = $_FILES['productImage']['tmp_name'];
    $target_file = NULL; // Default to NULL if no image
    $uploadOk = 1;

    // Check if image file is uploaded
    if (!empty($imageTmpName) && !empty($imageName)) {
        $imageFileType = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        
        // Generate unique filename to avoid conflicts
        $uniqueImageName = time() . '_' . uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $uniqueImageName;

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

        // Attempt to upload the image
        if ($uploadOk == 1) {
            if (move_uploaded_file($imageTmpName, $target_file)) {
                // Image uploaded successfully
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.'); window.history.back();</script>";
                exit();
            }
        }
    }

    // Insert data into the 'products' table matching the actual table structure
    $sql = "INSERT INTO products (ProductName, Image, Description, prod_price, Quantity, prod_cat, AddedDate) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdiss", $productName, $target_file, $description, $prod_price, $quantity, $prod_cat, $addedDate);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect after successful addition with success message
        $success_message = urlencode("Product added successfully!");
        header("Location: products.php?success=1&message=$success_message");
        exit();
    } else {
        echo "<script>alert('Error adding product: " . $conn->error . "'); window.history.back();</script>";
        exit();
    }

    // Close statement and connection
    $stmt->close();
}

$conn->close();
?>