<?php

include '../connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate email
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Check if username already exists
function check_username_exists($conn, $username) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form inputs
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password']; // Plaintext (not recommended)
    $role = $_POST['role'];

    // Validate email format
    if (!validate_email($email)) {
        echo "Invalid email format.";
        exit;
    }

    // Check username availability
    if (check_username_exists($conn, $username)) {
        echo "Username already exists. Please choose another.";
        exit;
    }

    // Insert user into DB
    $stmt = $conn->prepare("INSERT INTO users (username, password, email, role, created_at) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)");
    $stmt->bind_param("ssss", $username, $password, $email, $role);

    if ($stmt->execute()) {
        // Redirect to login or dashboard page after registration
        header("Location: users.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
