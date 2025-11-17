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

  <link rel="stylesheet" href="../assets/css/theme.css" />
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
