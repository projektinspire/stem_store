<?php
include '../connection.php';

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Fetch the product image path to delete the image file if needed
    $sql = "SELECT Image FROM products WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        // Path to the product image
        $imagePath = 'pages/' . $product['Image'];
        if (file_exists($imagePath)) {
            unlink($imagePath); // Delete the image file from the server
        }

        // First, delete related entries from the cart table to satisfy foreign key constraint
        $sql = "DELETE FROM cart WHERE ProductID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();

        // Now delete the product from the products table
        $sql = "DELETE FROM products WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);

        if ($stmt->execute()) {
            // Redirect after successful deletion
            header("Location: products.php?message=Product deleted successfully");
            exit();
        } else {
            echo "Error deleting product: " . $conn->error;
        }
    } else {
        echo "Product not found.";
    }
}

$conn->close();
?>
