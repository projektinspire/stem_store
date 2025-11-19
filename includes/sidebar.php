<?php
  $current = basename($_SERVER['SCRIPT_NAME']);
  $isActive = function ($files) use ($current) {
    if (!is_array($files)) $files = [$files];
    foreach ($files as $f) {
      if ($current === $f) return ' active';
    }
    return '';
  };
?>
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl fixed-start ms-4" id="sidenav-main" style="height: 100vh; position: fixed; top: 0; bottom: 0; overflow: hidden;">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="../index2.php">
      <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
      <span class="ms-1 font-weight-bold">STEM STORE</span>
    </a>
  </div>
  <hr class="horizontal dark mt-0 mb-2">
  <div class="collapse navbar-collapse w-auto show" id="sidenav-collapse-main" style="overflow: hidden;">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link<?php echo $isActive(['../index2.php','index2.php']); ?>" href="../index2.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-tachometer-alt text-primary text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link<?php echo $isActive('sales.php'); ?>" href="sales.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-hand-holding-usd text-warning text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Return Products</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link<?php echo $isActive(['products.php','edit_product.php']); ?>" href="products.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-boxes text-danger text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Manage Products</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link<?php echo $isActive('addproducts.php'); ?>" href="addproducts.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-plus-square text-success text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Add Products</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link<?php echo $isActive('Manageadmin.php'); ?>" href="Manageadmin.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-user-shield text-info text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Manage Admin</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link<?php echo $isActive('users.php'); ?>" href="users.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-users text-info text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Manage Users</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link<?php echo $isActive('customers.php'); ?>" href="customers.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-user-friends text-primary text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Manage Store Keepers</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link<?php echo $isActive('register.php'); ?>" href="register.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-user-plus text-success text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Register</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link<?php echo $isActive('customer_report.php'); ?>" href="customer_report.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-chart-bar text-primary text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Users Report</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link<?php echo $isActive('report.php'); ?>" href="report.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-chart-line text-success text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Reports</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link<?php echo $isActive('profile.php'); ?>" href="profile.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-user text-dark text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Profile</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../pages/login.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-sign-out-alt text-danger text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Logout</span>
        </a>
      </li>
    </ul>
  </div>
</aside>
