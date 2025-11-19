<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once '../connection.php';

// CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$return = isset($_GET['return']) ? preg_replace('/[^a-zA-Z0-9_\-]/','', $_GET['return']) : 'users';

// Load user
$user = null;
if ($id > 0) {
    $stmt = $conn->prepare("SELECT id, username, email, role FROM users WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
    $stmt->close();
}

if (!$user) {
    http_response_code(404);
    echo "User not found";
    exit;
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
        die('Invalid CSRF token');
    }
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? $user['role'];

    if ($username === '' || $email === '') {
        $error = 'Username and Email are required.';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email.';
    } else {
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
        $stmt->bind_param('sssi', $username, $email, $role, $id);
        if ($stmt->execute()) {
            $dest = $return === 'Manageadmin' ? 'Manageadmin.php' : 'users.php';
            header("Location: {$dest}?updated=1");
            exit;
        } else {
            $error = 'Update failed: ' . htmlspecialchars($stmt->error);
        }
        $stmt->close();
    }
}

// Basic roles
$roles = ['Admin','User'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/white.png">
  <title>Edit User</title>
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/theme.css" />
</head>
<body class="bg-gray-100">
  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h6 class="mb-0">Edit User #<?php echo htmlspecialchars($user['id']); ?></h6>
          </div>
          <div class="card-body">
            <?php if (!empty($error)): ?>
              <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST">
              <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
              <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select">
                  <?php foreach ($roles as $r): ?>
                    <option value="<?php echo $r; ?>" <?php echo $user['role']===$r?'selected':''; ?>><?php echo $r; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="d-flex justify-content-between">
                <a href="<?php echo $return === 'Manageadmin' ? 'Manageadmin.php' : 'users.php'; ?>" class="btn btn-secondary">Cancel</a>
                <button type="submit" name="update_user" class="btn btn-primary">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
