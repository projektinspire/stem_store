<?php
include '../connection.php';

session_start(); // Start the session if not already started

// Ensure that the user is logged in and has a valid user ID
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$userID = $_SESSION['user_id']; // Get the user ID from session

// Fetch user details
$user = null;
if ($userId) {
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Update user details in the database
    $updateQuery = "UPDATE users SET username = ?, email = ?, password = ?, role = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password
    $updateStmt->bind_param("ssssi", $username, $email, $hashedPassword, $role, $userId);

    if ($updateStmt->execute()) {
        echo "Profile updated successfully!";
        // Optionally, redirect or refresh page
        header("Location: profile.php");
        exit();
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>