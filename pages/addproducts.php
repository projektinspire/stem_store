<!DOCTYPE html>
<html lang="en">

<?php $pageTitle = 'STEM STORE'; include '../includes/head.php'; ?>

<body class="g-sidenav-show g-sidenav-pinned page-form bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
<?php include '../includes/sidebar.php'; ?>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <?php include '../includes/navbar.php'; ?>
    <!-- End Navbar -->
    <style>
        .card-header {
            background-color: white;
            color: black;
            border-bottom: 1px solid #ddd;
        }
        .btn-primary {
            background-color: #00dbe5;
            border-color: #00dbe5;
            color: #320F44;
        }
        .btn-primary:hover {
            background-color: #00b8c4;
            border-color: #00b8c4;
            color: #320F44;
        }
    </style>
    <style>
      /* Reduce purple header height on form pages to avoid extra scroll */
      .page-form .min-height-300 { min-height: 90px !important; }
      .page-form .container-fluid.py-4 { padding-top: 12px !important; padding-bottom: 12px !important; min-height: calc(100vh - 120px) !important; align-items: center; }
      .page-form .card { margin-bottom: 0 !important; }
      .page-form .card-header { padding: 12px 16px !important; }
      .page-form .card-body { padding: 16px 16px !important; }
      .page-form .footer { display: none !important; }
    </style>
    <div class="container-fluid py-4 d-flex justify-content-center">
        <div class="row w-100">
            <div class="col-lg-6 col-md-8 col-sm-10 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h6>Add Products Form</h6>
                    </div>
                    <div class="card-body">
                        <form action="addproduct.php" enctype="multipart/form-data" method="POST">
                            <!-- Product Name -->
                            <div class="form-group mb-3">
                                <label for="productName" class="form-label">Product Name <span class="text-danger">*</span></label>
                                <input class="form-control" id="productName" name="productName" placeholder="Enter product name" required type="text" />
                            </div>

                            <!-- Product Image -->
                            <div class="form-group mb-3">
                                <label for="productImage" class="form-label">Product Image</label>
                                <input accept="image/*" class="form-control" id="productImage" name="productImage" type="file" />
                                <small class="text-muted">Supported formats: JPG, JPEG, PNG, GIF (Max: 5MB)</small>
                            </div>

                            <!-- Product Price -->
                            <div class="form-group mb-3">
                                <label for="prod_price" class="form-label">Product Price (Tsh) <span class="text-danger">*</span></label>
                                <input class="form-control" id="prod_price" name="prod_price" placeholder="Enter product price" required type="number" step="0.01" min="0" />
                            </div>

                            <!-- Product Categories -->
                            <div class="form-group mb-3">
                                <label for="prod_cat" class="form-label">Product Category</label>
                                <select class="form-control" id="prod_cat" name="prod_cat">
                                    <option value="">Select category (Optional)</option>
                                    <option value="Agriculture">Agriculture</option>
                                    <option value="Chemistry Tools">Chemistry Tools</option>
                                    <option value="Electronics">Electronics</option>
                                    <option value="Engineering Devices">Engineering Devices</option>
                                    <option value="Hospital">Hospital</option>
                                    <option value="ICT">ICT</option>
                                    <option value="Instruments">Instruments</option>
                                    <option value="Kitchen Equipment">Kitchen Equipment</option>
                                    <option value="Office">Office</option>
                                    <option value="Protective Gears">Protective Gears</option>
                                    <option value="Stationery">Stationery</option>
                                </select>
                            </div>

                            <!-- Product Quantity -->
                            <div class="form-group mb-3">
                                <label for="quantity" class="form-label">Product Quantity <span class="text-danger">*</span></label>
                                <input class="form-control" id="quantity" name="quantity" placeholder="Enter quantity" required type="number" min="0" />
                            </div>

                            <!-- Product Description -->
                            <div class="form-group mb-3">
                                <label for="description" class="form-label">Product Description</label>
                                <textarea class="form-control" id="description" name="description" placeholder="Enter product description" rows="4"></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-end">
                                <button class="btn btn-secondary me-2" type="reset">Reset</button>
                                <button class="btn btn-primary" type="submit">Add Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript function to show the message in an alert box
        function showMessage(message) {
            if (message) {
                alert(message); // Show message in a popup
            }
            return true; // Proceed with form submission
        }

        // Check for URL parameters and show success message
        const urlParams = new URLSearchParams(window.location.search);
        const message = urlParams.get('message');
        if (message) {
            showMessage(message);
        }
    </script>
  </main>
  <?php include '../includes/footer.php'; ?>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const todoList = document.getElementById('todoList');
    const addTaskBtn = document.getElementById('addTaskBtn');
    const todoInput = document.getElementById('todoInput');

    // Load tasks on page load
    loadTasks();

    addTaskBtn.addEventListener('click', function() {
      const taskText = todoInput.value.trim();
      if (taskText) {
        const task = {
          text: taskText,
          timestamp: new Date().getTime()  // Save the current time when adding task
        };
        addTask(task);
        saveTask(task);
        todoInput.value = '';  // Clear input after adding
      }
    });

    // Function to add task to the DOM
    function addTask(task) {
      const li = document.createElement('li');
      li.innerHTML = `
        <div class="form-check form-check-primary">
          <label class="form-check-label">
            <input class="checkbox" type="checkbox"> ${task.text}
          </label>
        </div>
        <i class="remove mdi mdi-close-box"></i>
      `;
      todoList.appendChild(li);

      // Add remove functionality
      li.querySelector('.remove').addEventListener('click', function() {
        removeTask(task.text);
        li.remove();
      });
    }

    // Function to save task to localStorage
    function saveTask(task) {
      const tasks = getStoredTasks();
      tasks.push(task);
      localStorage.setItem('tasks', JSON.stringify(tasks));
    }

    // Function to remove task from localStorage
    function removeTask(taskText) {
      let tasks = getStoredTasks();
      tasks = tasks.filter(task => task.text !== taskText);
      localStorage.setItem('tasks', JSON.stringify(tasks));
    }

    // Load stored tasks and display them
    function loadTasks() {
      const tasks = getStoredTasks();
      const currentTime = new Date().getTime();

      tasks.forEach(task => {
        // Check if the task is less than 24 hours old (86400000 ms)
        if (currentTime - task.timestamp < 86400000) {
          addTask(task);  // Add valid task to the list
        }
      });

      // Remove tasks older than 24 hours from localStorage
      const recentTasks = tasks.filter(task => currentTime - task.timestamp < 86400000);
      localStorage.setItem('tasks', JSON.stringify(recentTasks));
    }

    // Get stored tasks from localStorage
    function getStoredTasks() {
      return JSON.parse(localStorage.getItem('tasks')) || [];
    }
  });
</script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>
