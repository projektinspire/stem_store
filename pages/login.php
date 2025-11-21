<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>STEM STORE - Login</title>
  <link rel="icon" type="image/png" href="../assets/img/white.png" />

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

  <style>
    /* VARIABLES (User's Purple Background + STEM Blue Theme) */
    :root {
      --primary-color: #007bff; /* A strong, clear blue for branding and buttons */
      --primary-hover: #007bff;
      --background-color: #6f42c1; /* User-specified purple background */
      --card-bg: #ffffff;
      --text-color: #343a40; /* Dark gray for body text */
      --input-border: #ced4da;
      --logo-text: #ffffff; /* White text for logo title (since it's on a blue background now) */
      --footer-color: #cccccc; /* Lighter gray for footer text on dark background */
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--background-color);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
      color: var(--text-color);
      /* Ensure text is visible on the dark purple background */
      /* Note: login-container and footer are the main concern here */
    }

    .login-container {
      width: 100%;
      max-width: 400px;
      padding: 20px;
      text-align: center;
    }

    /* .logo-header section has been removed and its content moved into .card-header */

    .login-card {
      background: var(--card-bg);
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      margin-bottom: 20px;
    }

    .card-header {
      background-color: #ffffff
      color: black;
      padding: 0px 0 0px 0; /* Adjusted padding to fit all elements */
      border-top-left-radius: 12px;
      border-top-right-radius: 12px;
    }

    .card-header .logo-img { /* Style the moved image */
      width: 200px;
      height: 100px;
      margin-bottom: 1px;
    }

    .card-header h1 {
      font-size: 1.8rem;
      color: #fffff;
      font-weight: 700;
      margin: 0 0 5px 0; /* Add slight separation from the h3 subtitle */
    }

    .card-header h3 {
      margin: 0;
      font-weight: 500; /* Slightly less bold for subtitle */
      font-size: 1.2rem; /* Subtitle size */
    }

    .card-body {
      padding: 10px;
    }

    .input-group {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      border: 1px solid var(--input-border);
      border-radius: 8px;
      overflow: hidden;
      background-color: #fff;
    }

    .input-group-text {
      /* Changed from var(--background-color) to a lighter gray for better card integration */
      background-color: #f8f9fa; 
      color: var(--primary-color); /* Primary color for icon */
      padding: 12px 15px;
      font-size: 1rem;
      border: none;
      border-right: 1px solid var(--input-border);
    }

    .form-control {
      flex-grow: 1;
      border: none;
      padding: 12px 15px;
      font-size: 1rem;
      outline: none;
      color: var(--text-color);
    }

    .form-control:focus {
      box-shadow: none;
    }

    .d-flex {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px !important;
    }

    .form-check {
      display: flex;
      align-items: center;
    }

    .form-check-input {
      margin-right: 8px;
      width: 16px;
      height: 16px;
      accent-color: var(--primary-color);
    }

    .form-check-label {
      font-size: 0.9rem;
      cursor: pointer;
    }

    .forgot-password {
      color: var(--primary-color);
      text-decoration: none;
      font-size: 0.9rem;
    }

    .forgot-password:hover {
      text-decoration: underline;
    }

    .btn-login {
      width: 100%;
      padding: 10px;
      background-color: var(--primary-color);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .btn-login:hover {
      background-color: var(--primary-hover);
    }

    .btn-login i {
      margin-right: 8px;
    }

    .login-footer {
      color: var(--footer-color);
      font-size: 0.85rem;
      margin-top: 15px;
    }
  </style>
</head>

<body>
  <div class="login-container">
    
    <div class="login-card">
      <div class="card-header">
        <img src="../assets/img/logo-ct-dark.png" class="logo-img" alt="STEM STORE Logo">
        <h1>STEM STORE</h1>
        <h3>User Login</h3>
      </div>
      <div class="card-body">
        <form action="check_login.php" method="POST">
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
            <input type="text" name="username" class="form-control" placeholder="Username" required>
          </div>

          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
          </div>

          <div class="d-flex">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="rememberMe">
              <label class="form-check-label" for="rememberMe">Remember me</label>
            </div>
            <a href="#" class="forgot-password">Forgot password?</a>
          </div>

          <button type="submit" class="btn-login">
            <i class="fas fa-sign-in-alt"></i> Sign In
          </button>
        </form>
      </div>
    </div>

    <div class="login-footer">
      © <script>document.write(new Date().getFullYear())</script> Projekt Inspire
    </div>
  </div>
</body>
</html>