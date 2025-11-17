<?php
include '../connection.php';

// Check if the admin ID is provided in the URL
if (isset($_GET['id'])) {
    $adminId = intval($_GET['id']); // Sanitize ID
    
    // Delete the admin from the database
    $delete_sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $adminId);
    
    if ($stmt->execute()) {
        // Redirect to the Manageadmin page after deletion
        header("Location: Manageadmin.php?message=AdminDeleted");
        exit();
    } else {
        echo "Error deleting admin.";
    }

    $stmt->close();
} else {
    echo "No admin ID specified.";
}

$conn->close();
?>
