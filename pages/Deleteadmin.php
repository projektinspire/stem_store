<?php
// Include the database connection file
include '../connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request is POST and if the admin_id is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['admin_id'])) {
    $admin_id = intval($_POST['admin_id']); // Sanitize the admin ID

    // Fetch the admin's role from the database
    $sql = "SELECT role FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $stmt->bind_result($role);
    $stmt->fetch();
    $stmt->close();

    // Check if the admin is not a Director
    if ($role !== 'Director') {
        // Delete the admin from the database
        $delete_sql = "DELETE FROM users WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $admin_id);
        if ($delete_stmt->execute()) {
            // Redirect back to the admin management page with a success message
            header("Location: Manageadmin.php?delete_success=1");
            exit();
        } else {
            // Redirect back with an error message if deletion fails
            header("Location: Manageadmin.php?delete_error=1");
            exit();
        }
        $delete_stmt->close();
    } else {
        // Redirect with an error message if trying to delete a Director
        header("Location: Manageadmin.php?delete_director_error=1");
        exit();
    }
}

// Close the database connection
$conn->close();
?>
