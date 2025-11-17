<?php
include '../connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture login form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists and credentials match
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $username, $password, $role);
        $stmt->fetch();

        // Only "Admin" role is admin, everything else is user
        $userRole = ($role === "Admin") ? "Admin" : "User";

        // Store user details in session variables
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $userRole;

        // Redirect based on role
        if ($userRole === "Admin") {
            header("Location: ../index2.php");  // Admin dashboard path
        } else {
            header("Location: ../user/dashboard.php");   // User dashboard path
        }
        exit();
    } else {
        echo '
        <div style="
            max-width: 300px;
            margin: 20px auto;
            padding: 20px;
            background-color: #035407;
            border: 1px solid #035407;
            border-radius: 8px;
            text-align: center;
            color: #ff2b2b;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        ">
            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
            <dotlottie-player src="https://lottie.host/9934cce6-6525-4232-95d3-923e01e3c6b4/WB0pAkWUo5.json" 
                background="transparent" 
                speed="1" 
                style="width: 300px; height: 300px; transform: translateX(10px);" 
                loop 
                autoplay>
            </dotlottie-player>
            <h2 style="margin-top: 20px;">Invalid username or password</h2>
            <p>Please check your credentials and try again.</p>
        </div>';

        // Redirect back after 5 seconds
        echo '
        <script>
            setTimeout(function() {
                window.history.back();
            }, 5000);
        </script>';
    }

    $stmt->close();
    $conn->close();
}
?>
