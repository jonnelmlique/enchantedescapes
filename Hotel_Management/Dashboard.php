<?php

include('db_connection.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the total count of reservationsumid
$sql_reservations = "SELECT COUNT(recervationprocessid) AS total_bookings FROM reservationprocess";
$result_reservations = mysqli_query($conn, $sql_reservations);

if ($result_reservations && mysqli_num_rows($result_reservations) > 0) {
    $row_reservations = mysqli_fetch_assoc($result_reservations);
    $total_bookings = $row_reservations['total_bookings'];
} else {
    $total_bookings = 0; // Default value if there are no bookings
}

// Query to get the total count of rooms
$sql_rooms = "SELECT COUNT(roominfoid) AS total_rooms FROM roominfo";
$result_rooms = mysqli_query($conn, $sql_rooms);

if ($result_rooms && mysqli_num_rows($result_rooms) > 0) {
    $row_rooms = mysqli_fetch_assoc($result_rooms);
    $total_rooms = $row_rooms['total_rooms'];
} else {
    $total_rooms = 0; // Default value if there are no rooms
}

// Query to get the total count of checked records where status is 1
$sql_checked = "SELECT COUNT(*) AS total_checked FROM checked WHERE status = 1";
$result_checked = mysqli_query($conn, $sql_checked);

if ($result_checked && mysqli_num_rows($result_checked) > 0) {
    $row_checked = mysqli_fetch_assoc($result_checked);
    $total_checked = $row_checked['total_checked'];
} else {
    $total_checked = 0; // Default value if there are no checked records with status 1
}

// Query to get the total count of checked records where status is 2
$sql_checked_2 = "SELECT COUNT(*) AS total_checked_2 FROM checked WHERE status = 2";
$result_checked_2 = mysqli_query($conn, $sql_checked_2);

if ($result_checked_2 && mysqli_num_rows($result_checked_2) > 0) {
    $row_checked_2 = mysqli_fetch_assoc($result_checked_2);
    $total_checked_2 = $row_checked_2['total_checked_2'];
} else {
    $total_checked_2 = 0; // Default value if there are no checked records with status 2
}

$sql_bar_chart_data = "SELECT roomtype, COUNT(*) AS total_rooms FROM room_type GROUP BY roomtype";
$result_bar_chart_data = mysqli_query($conn, $sql_bar_chart_data);

$bar_chart_data = [];
if ($result_bar_chart_data && mysqli_num_rows($result_bar_chart_data) > 0) {
    while ($row = mysqli_fetch_assoc($result_bar_chart_data)) {
        $bar_chart_data[] = [
            'room_type' => $row['roomtype'],
            'total_rooms' => $row['total_rooms'],
        ];
    }
}

// Query to get data for the area chart (orders table)
$sql_area_chart_data = "SELECT OrderDate, COUNT(*) AS total_orders FROM orders GROUP BY OrderDate";
$result_area_chart_data = mysqli_query($conn, $sql_area_chart_data);

$area_chart_labels = [];
$area_chart_orders = [];
if ($result_area_chart_data && mysqli_num_rows($result_area_chart_data) > 0) {
    while ($row = mysqli_fetch_assoc($result_area_chart_data)) {
        $area_chart_labels[] = $row['OrderDate'];
        $area_chart_orders[] = $row['total_orders'];
    }
}

// Query to get the total amount of orders
$sql_total_amount = "SELECT SUM(TotalAmount) AS overall_amount FROM orders";
$result_total_amount = mysqli_query($conn, $sql_total_amount);

if ($result_total_amount && mysqli_num_rows($result_total_amount) > 0) {
    $row_total_amount = mysqli_fetch_assoc($result_total_amount);
    $overall_amount = $row_total_amount['overall_amount'];
} else {
    $overall_amount = 0; // Default value if there are no orders
}
?>


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

    <?php
        include ('header.php');
        include ('sidebar.php');
    ?>
  </head>
  <body>
    

      <!-- Main -->
      <main class="main-container">
        <div class="main-title">
          <p class="font-weight-bold">DASHBOARD</p>
        </div>

        <div class="main-cards">

<div class="card">
    <a href="booking.php" style="text-decoration: none;">
        <div class="card-inner">
            <p class="text-primary">BOOKING</p>
            <span class="material-symbols-outlined">library_books</span>
        </div>
        <span class="text-primary font-weight-bold"><?php echo $total_bookings; ?></span>
    </a>
</div>

<div class="card">
    <a href="checkin.php" style="text-decoration: none;">
        <div class="card-inner">
            <p class="text-primary">ROOMS</p>
        </div>
        <span class="text-primary font-weight-bold"><?php echo $total_rooms; ?></span>
    </a>
</div>

<div class="card">
    <a href="" style="text-decoration: none;">
        <div class="card-inner">
            <p class="text-primary">SALES REPORT</p>
        </div>
        <span class="text-primary font-weight-bold">₱<?php echo number_format($overall_amount, 2); ?></span>
    </a>
</div>

<div class="card">
    <a href="checkin.php" style="text-decoration: none;">
        <div class="card-inner">
            <p class="text-primary">Check In</p>
        </div>
        <span class="text-primary font-weight-bold"><?php echo $total_checked; ?></span>
    </a>
</div>

<div class="card">
    <a href="checkout.php" style="text-decoration: none;">
        <div class="card-inner">
            <p class="text-primary">Check Out</p>
        </div>
        <span class="text-primary font-weight-bold"><?php echo $total_checked_2; ?></span>
    </a>
</div>

          

        </div>

        <div class="charts">
            <div class="charts-card">
                <p class="chart-title">Top 5 Products</p>
                <canvas id="bar-chart"></canvas>
            </div>

            <div class="charts-card">
                <p class="chart-title">Purchase and Sales Orders</p>
                <canvas id="area-chart"></canvas>
            </div>
        </div>
    </main>
    
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Scripts -->
    <!-- ApexCharts -->
    <!-- Custom JS -->


    <script>
    const barChartOptions = {
            series: [{
                name: 'Total Rooms',
                data: <?php echo json_encode(array_column($bar_chart_data, 'total_rooms')); ?>,
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false,
                },
            },
            xaxis: {
                categories: <?php echo json_encode(array_column($bar_chart_data, 'roomtype')); ?>,
            },
        };

        const barChart = new ApexCharts(document.querySelector('#bar-chart'), barChartOptions);
        barChart.render();

        const areaChartOptions = {
            series: [{
                name: 'Orders',
                data: <?php echo json_encode($area_chart_orders); ?>,
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false,
                },
            },
            xaxis: {
                categories: <?php echo json_encode($area_chart_labels); ?>,
            },
        };

        const areaChart = new ApexCharts(document.querySelector('#area-chart'), areaChartOptions);
        areaChart.render();


    </script>


    <script src="js/script.js"></script>
  </body>
</html>