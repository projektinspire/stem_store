<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>STEM STORE - Login</title>
  <link rel="icon" type="image/png" href="../assets/img/white.png" />

  <!-- Google Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

  <style>
    * {
      box-sizing: border-box;
    }

    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #4f46e5, #0ea5e9);
      color: white;
    }

    .login-container {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
      padding: 20px;
    }

    .logo-header {
      text-align: center;
      margin-bottom: 20px;
    }

    .logo-img {
      height: 60px;
      filter: brightness(0) invert(1);
    }

    .login-card {
      background: white;
      color: #2c003e;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
      width: 100%;
      max-width: 400px;
      overflow: hidden;
    }

    .card-header {
      background: #4f46e5;
      color: white;
      padding: 25px 20px;
      text-align: center;
    }

    .card-header h3 {
      margin: 0;
      font-size: 1.6rem;
      font-weight: 600;
    }

    .card-body {
      padding: 25px 20px;
    }

    .input-group {
      display: flex;
      align-items: center;
      border: 1px solid #ddd;
      border-radius: 8px;
      margin-bottom: 15px;
      overflow: hidden;
    }

    .input-group-text {
      padding: 10px;
      background: #f1f5f9;
      color: #4f46e5;
    }

    .form-control {
      flex: 1;
      padding: 12px;
      border: none;
      outline: none;
      font-size: 1rem;
    }

    .form-control:focus {
      background-color: #fdfdfd;
    }

    .form-check {
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .form-check-label {
      color: #555;
    }

    .btn-login {
      background: #0ea5e9;
      color: white;
      border: none;
      border-radius: 8px;
      padding: 12px;
      width: 100%;
      font-weight: 600;
      transition: background 0.3s ease, transform 0.2s ease;
      cursor: pointer;
    }

    .btn-login:hover {
      background: #0284c7;
      transform: translateY(-2px);
    }

    .login-footer {
      margin-top: 20px;
      text-align: center;
      font-size: 0.9rem;
      color: rgba(255, 255, 255, 0.8);
    }

    .forgot-password {
      font-size: 0.85rem;
      color: #0ea5e9;
      text-decoration: none;
    }

    .forgot-password:hover {
      text-decoration: underline;
    }

    @media (max-width: 576px) {
      .login-card {
        margin: 0 10px;
      }

      .logo-img {
        height: 50px;
      }
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="logo-header">
      <img src="../assets/img/logo-ct-dark.png" class="logo-img" alt="STEM STORE Logo">
    </div>

    <div class="login-card">
      <div class="card-header">
        <h3>STEM STORE Login</h3>
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

          <div class="d-flex justify-content-between align-items-center mb-3" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="rememberMe">
              <label class="form-check-label" for="rememberMe">Remember me</label>
            </div>
            <a href="#" class="forgot-password">Forgot password?</a>
          </div>

          <button type="submit" class="btn-login">
            <i class="fas fa-sign-in-alt"></i> Login
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
