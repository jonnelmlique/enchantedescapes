<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: ../auth/login.php");
    exit(); 
}
?>
<?php
include '../src/config/config.php';

// Initialize variables
$total_available_rooms = 0;
$total_pending_reservations = 0;
$total_cancelled_reservations = 0;

$total_expected_arrivals = 0;
$total_expected_departures = 0;

$current_date = date("Y-m-d");

$sql_available_rooms = "SELECT COUNT(*) AS total_rooms FROM roominfo WHERE status = 'available'";
$result_available_rooms = $conn->query($sql_available_rooms);
if ($result_available_rooms->num_rows > 0) {
    $row_available_rooms = $result_available_rooms->fetch_assoc();
    $total_available_rooms = $row_available_rooms["total_rooms"];
}

$sql_pending_reservations = "SELECT COUNT(*) AS total_pending FROM reservationprocess WHERE status = 'pending'";
$result_pending_reservations = $conn->query($sql_pending_reservations);
if ($result_pending_reservations->num_rows > 0) {
    $row_pending_reservations = $result_pending_reservations->fetch_assoc();
    $total_pending_reservations = $row_pending_reservations["total_pending"];
}

$sql_cancelled_reservations = "SELECT COUNT(*) AS total_cancelled FROM reservationprocess WHERE status = 'cancelled'";
$result_cancelled_reservations = $conn->query($sql_cancelled_reservations);
if ($result_cancelled_reservations->num_rows > 0) {
    $row_cancelled_reservations = $result_cancelled_reservations->fetch_assoc();
    $total_cancelled_reservations = $row_cancelled_reservations["total_cancelled"];
}
$sql_expected_arrivals = "SELECT COUNT(*) AS total_arrivals FROM reservationprocess WHERE checkindate = '$current_date' AND status = 'Accepted'";
$result_expected_arrivals = $conn->query($sql_expected_arrivals);
if ($result_expected_arrivals->num_rows > 0) {
    $row_expected_arrivals = $result_expected_arrivals->fetch_assoc();
    $total_expected_arrivals = $row_expected_arrivals["total_arrivals"];
}
$sql_expected_departures = "SELECT COUNT(*) AS total_departures FROM reservationprocess WHERE checkoutdate = '$current_date' AND status = 'Accepted'";
$result_expected_departures = $conn->query($sql_expected_departures);
if ($result_expected_departures->num_rows > 0) {
    $row_expected_departures = $result_expected_departures->fetch_assoc();
    $total_expected_departures = $row_expected_departures["total_departures"];
}

?>
<?php
$sqlPending = "SELECT COUNT(*) as pendingCount FROM reservationprocess WHERE status = 'Pending'";
$resultPending = $conn->query($sqlPending);
$rowPending = $resultPending->fetch_assoc();
$pendingCount = $rowPending['pendingCount'];

$sqlAccepted = "SELECT COUNT(*) as acceptedCount FROM reservationprocess WHERE status = 'Accepted'";
$resultAccepted = $conn->query($sqlAccepted);
$rowAccepted = $resultAccepted->fetch_assoc();
$acceptedCount = $rowAccepted['acceptedCount'];
$conn->close();

?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Hotel Reservation System | Admin</title>

    <link href="../styles/bootstrap.min.css" rel="stylesheet" />
    <link href="../styles/scrollbar.css" rel="stylesheet" />
    <link href="../styles/admin/dashboard.css" rel="stylesheet" />
</head>

<body>
    <?php include ("components/header.php"); ?>

    <div class="row w-100">
        <div class="col-lg-1">
            <?php include ("components/sidebar.php"); ?>
        </div>

        <div class="col-lg-8 bg-white shadow-lg">
            <div class="px-4">
                <h4 class="fw-bold text-uppercase">&gt; Dashboard</h4>
                <h5 id="manila-datetime"></h5>
                <hr>
                <br />
                <div class="cont">

                    <div class="row">
                        <div class="col-3">
                            <div class="card card-body bg-primary text-white px-4" style="border-radius: 8px"
                                align="center">
                                <h6 class="fw-bold">New Bookings</h6>
                                <h4 class="fw-bold"><?php echo $total_pending_reservations; ?></h4>
                            </div>
                            <br />

                            <div class="card card-body bg-primary text-white px-4" style="border-radius: 8px"
                                align="center">
                                <h6 class="fw-bold">Cancelled</h6>
                                <h4 class="fw-bold"><?php echo $total_cancelled_reservations; ?></h4>
                            </div>
                            <br />

                            <div class="card card-body bg-primary text-white px-4" style="border-radius: 8px"
                                align="center">
                                <h6 class="fw-bold">Rooms</h6>
                                <h4 class="fw-bold"><?php echo $total_available_rooms; ?></h4>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="card card-body bg-primary text-white px-4" style="border-radius: 8px"
                                align="center">
                                <h6 class="fw-bold">Expected Arrival</h6>
                                <h4 class="fw-bold"><?php echo $total_expected_arrivals; ?></h4>
                            </div>
                            <br />

                            <div class="card card-body bg-primary text-white px-4" style="border-radius: 8px"
                                align="center">
                                <h6 class="fw-bold">Expected Departure</h6>
                                <h4 class="fw-bold"><?php echo $total_expected_departures; ?></h4>
                            </div>
                            <br />

                            <div class="card card-body bg-primary text-white px-4" style="border-radius: 8px"
                                align="center">
                                <h6 class="fw-bold">Current In-House</h6>
                                <h4 class="fw-bold">0</h4>
                            </div>
                        </div> <br />
                        <br />
                        <br />
                        <br />


                        <div class="col-6">
                            <!-- <img src="../assets/pie-chart.png" width="100%" /> -->
                            <canvas id="reservationPieChart"></canvas>

                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>


    <script src="../scripts/jquery.min.js"></script>
    <script src="../scripts/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    function updateDateTime() {
        var now = new Date();

        var options = {
            timeZone: 'Asia/Manila',
            hour12: true,
            hour: '2-digit',
            minute: '2-digit',
            month: 'numeric',
            day: 'numeric',
            year: 'numeric'
        };
        var manilaDateTime = now.toLocaleString('en-US', options);
        document.getElementById('manila-datetime').textContent = manilaDateTime;
    }
    setInterval(updateDateTime, 1000);
    updateDateTime();
    </script>
    <script>
    var pendingCount = <?php echo $pendingCount; ?>;
    var acceptedCount = <?php echo $acceptedCount; ?>;

    var ctx = document.getElementById('reservationPieChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Pending', 'Accepted'],
            datasets: [{
                data: [pendingCount, acceptedCount],
                backgroundColor: [
                    'rgba(212, 175, 55, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                ],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    var canvas = document.getElementById('reservationPieChart');
    canvas.style.width = '300px';
    </script>

</body>

</html>