<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">


    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
  </head>
  <body>

<!-- Sidebar -->
<aside id="sidebar">
        <div class="sidebar-title">
          <div class="sidebar-brand">
            <span class="material-icons-outlined">inventory</span> Enchanted Escape Hotel
          </div>
          <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
        </div>

        <ul class="sidebar-list">
          <li class="sidebar-list-item">
            <a href="Dashboard.php">
              <span class="material-icons-outlined">dashboard</span> Dashboard
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="booking.php">
              <span class="material-icons-outlined">inventory_2</span> Booking
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="checkin.php">
              <span class="material-icons-outlined">fact_check</span> Check In
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="checkout.php">
              <span class="material-icons-outlined">fact_check</span> Check Out
            </a>
          </li>
         <!-- <li class="sidebar-list-item">
            <a href="#" target="_blank">
              <span class="material-icons-outlined">poll</span> Room Category
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="#" target="_blank">
              <span class="material-icons-outlined">poll</span> Room
            </a>
          </li> -->
          <li class="sidebar-list-item">
            <a href="guest_orders.php">
              <span class="material-icons-outlined">shopping_cart</span> Additional Services
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="payment.php">
              <span class="material-icons-outlined">poll</span> Payment
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="reports.php"">
              <span class="material-icons-outlined">poll</span> Reports
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="#" target="_blank">
              <span class="material-icons-outlined">settings</span> Logout
            </a>
          </li>
        </ul>
      </aside>
      <!-- End Sidebar -->

      <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
  </body>
</html>
