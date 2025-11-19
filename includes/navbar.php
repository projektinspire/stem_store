<?php
  if (session_status() === PHP_SESSION_NONE) { session_start(); }
  $username = isset($_SESSION['username']) ? strtoupper($_SESSION['username']) : '';
?>
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
  <div class="container-fluid py-1 px-3">
    <?php if ($username): ?>
      <p style="color:white;" class="mb-0"><i><strong><?php echo $username; ?></strong></i></p>
    <?php endif; ?>
    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
      <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
      <ul class="navbar-nav justify-content-end">
        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
          <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
            </div>
          </a>
        </li>
        <li class="nav-item px-3 d-flex align-items-center">
          <a href="javascript:;" class="nav-link text-white p-0"></a>
        </li>
      </ul>
    </div>
  </div>
  <script>
    // Toggle Argon pinned sidenav (shows text labels instead of icon-only)
    document.getElementById('iconNavbarSidenav')?.addEventListener('click', function () {
      document.body.classList.toggle('g-sidenav-pinned');
      document.body.classList.remove('sidenav-mini');
    });
  </script>
</nav>
