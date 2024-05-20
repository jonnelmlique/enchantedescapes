<?php

include('db_connection.php'); 

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the total count of reservationsumid
$sql_reservations = "SELECT COUNT(recervationprocessid) AS total_bookings FROM reservationprocess WHERE status='Accepted'";
$result_reservations = mysqli_query($conn, $sql_reservations);

if ($result_reservations && mysqli_num_rows($result_reservations) > 0) {
    $row_reservations = mysqli_fetch_assoc($result_reservations);
    $total_bookings = $row_reservations['total_bookings'];
} else {
    $total_bookings = 0; // Default value if there are no bookings
}

// Query to get the total count of rooms
$sql_rooms = "SELECT COUNT(roominfoid) AS total_rooms FROM roominfo WHERE status='Available'";
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

// Query to get the total amount of orders
$sql_total_amount = "SELECT SUM(TotalAmount) AS overall_amount FROM orders";
$result_total_amount = mysqli_query($conn, $sql_total_amount);

if ($result_total_amount && mysqli_num_rows($result_total_amount) > 0) {
    $row_total_amount = mysqli_fetch_assoc($result_total_amount);
    $overall_amount = $row_total_amount['overall_amount'];
} else {
    $overall_amount = 0; // Default value if there are no orders
}
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT 
                DATE_FORMAT(DATE_ADD('2024-01-01', INTERVAL m MONTH), '%Y-%m') AS month, 
                COALESCE(SUM(overallamount), 0) AS total_amount 
              FROM 
                (SELECT 0 AS m UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11) months
              LEFT JOIN 
                payments 
              ON 
                DATE_FORMAT(payment_date, '%Y-%m') = DATE_FORMAT(DATE_ADD('2024-01-01', INTERVAL m MONTH), '%Y-%m')
              GROUP BY 
                DATE_FORMAT(DATE_ADD('2024-01-01', INTERVAL m MONTH), '%Y-%m')";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $paymentsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convert data to JSON for JavaScript usage
    $paymentsJson = json_encode($paymentsData);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT MONTH(payment_date) AS month, SUM(ordtotalamount) AS ord_total_amount
    FROM payments
    GROUP BY MONTH(payment_date)";
    $result = $pdo->query($query);
    $data = $result->fetchAll(PDO::FETCH_ASSOC);

// Convert data to JSON format for JavaScript
$jsonData = json_encode($data);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
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
                    <p class="chart-title">Order Sales</p>
                    <canvas id="bar-chart"></canvas>
            </div>

            <div class="charts-card">
                <p class="chart-title">Enchanted Escape Monthly Sales</p>
                <canvas id="paymentChart" width="800" height="400"></canvas>
            </div>
        </div>
    </main>
    
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Parse JSON data from PHP
            var paymentsData = <?php echo $paymentsJson; ?>;

            // Extract labels (months) and data (total amounts) from JSON
            var labels = paymentsData.map(function (item) {
                return item.month;
            });
            var data = paymentsData.map(function (item) {
                return item.total_amount;
            });

            // Create the bar chart
            var ctx = document.getElementById('paymentChart').getContext('2d');
            var paymentChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Overall Amount by Month',
                        data: data,
                        backgroundColor: 'goldenrod',
                        backgroundColor: 'goldenrod',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });


        const salesData = <?php echo $jsonData; ?>;

// Extract month labels and total amounts from fetched data
const labels = salesData.map(item => item.month);
const amounts = salesData.map(item => item.ord_total_amount);

// Get the canvas element
const ctx = document.getElementById('bar-chart').getContext('2d');

// Create the bar chart
const barChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Total Amount',
            backgroundColor: 'goldenrod',
            backgroundColor: 'goldenrod',
            borderWidth: 1,
            data: amounts,
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true // Start y-axis at zero
            }
        }
    }
});
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>

    

    <script src="js/script.js"></script>
  </body>
</html>