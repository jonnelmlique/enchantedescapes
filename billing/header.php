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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
  </head>
  <body>
  <div class="grid-container">

<!-- Header -->
<header class="header">
  <div class="menu-icon" onclick="openSidebar()">
    <span class="material-icons-outlined">menu</span>
  </div>
<div class="header-left">
  <span class="material-icons-outlined">access_time</span>
  <span id="current-time"><?php
    date_default_timezone_set('Asia/Manila'); // Set timezone to Asia/Manila
    echo date('Y-m-d h:i:s A'); // Display initial timestamp in standard time format
  ?></span>
  </div>
  <div class="header-right">
  <a href="#" onclick="confirmLogout()">
  <span class="material-icons-outlined">exit_to_app</span>
</a>
  </div>

  
  
</header>
<!-- End Header -->
<script>
function updateTime() {
    // Get the current time in the Asia/Manila timezone
    let now = new Date(new Date().toLocaleString("en-US", { timeZone: "Asia/Manila" }));
    
    // Format the date and time
    let formattedTime = now.getFullYear() + '-' +
      ('0' + (now.getMonth() + 1)).slice(-2) + '-' +
      ('0' + now.getDate()).slice(-2) + ' ' +
      ('0' + now.getHours()).slice(-2) + ':' +
      ('0' + now.getMinutes()).slice(-2) + ':' +
      ('0' + now.getSeconds()).slice(-2) + ' ' +
      (now.getHours() >= 12 ? 'PM' : 'AM');

    // Update the HTML content
    document.getElementById('current-time').textContent = formattedTime;
  }

  // Initial update
  updateTime();
  // Update the time every second
  setInterval(updateTime, 1000);
</script>
<script>
  function confirmLogout() {
    Swal.fire({
      title: 'Are you sure you want to logout?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, logout',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#28a745', // Green color for confirm button
      cancelButtonColor: '#dc3545' // Red color for cancel button
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = 'FrontDeskLogin.php';
      }
    });
  }
</script>

  <!-- Scripts -->
    <!-- ApexCharts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </body>
</html>