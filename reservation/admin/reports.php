<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Hotel Reservation System | Reports</title>

    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="../styles/bootstrap.min.css" rel="stylesheet" />
    <link href="../styles/booking.css" rel="stylesheet" />
    <link href="../styles/scrollbar.css" rel="stylesheet" />
    <link href="../styles/admin/reports.css" rel="stylesheet" />

</head>

<body>
    <?php include ("components/header.php"); ?>

    <div class="row w-100">
        <div class="col-lg-1">
            <?php include ("components/sidebar.php"); ?>
        </div>

        <div class="col-lg-8 bg-white shadow-lg">
            <div class="px-4">
                <h4 class="fw-bold text-uppercase">&gt; Reports</h4>
                <hr>
                <br />

                <div align="right">
                    <input type="search" class="form-control w-100px" name="search" placeholder="Search"
                        style="border-radius: 8px" id="searchInput" />
                </div>
                <br />

                <label class="filter">Filter Reports:</label>
                <div class="calendar">
                    <label class="filter">Start Date:</label>

                    <input type="date" id="startdate" name="startdate" required>
                </div>
                <div class="calendar">
                    <label class="filters">End Date:</label>

                    <input type="date" id="enddate" name="enddate" required>

                </div>
                <br>
                <div class="print">
                    <button class="printdaily">Print Daily
                    </button>
                    <button class="printweekly">Print Weekly </button>

                    <button class="printmonthly">Print Monthly </button>

                    <button class="printannual">Print Anual </button>

                </div>
                <br>
                <table class="table table-hover table-stripped border border-dark" style="border-radius: 8px"
                    id="roomreservation">
                    <thead>
                        <tr>
                            <td class="bg-dark text-white">#</td>
                            <td class="bg-dark text-white">Guest Details</td>
                            <td class="bg-dark text-white">Room Details</td>
                            <td class="bg-dark text-white">Booking Details</td>
                            <td class="bg-dark text-white">Payment Details</td>
                            <td class="bg-dark text-white">Status</td>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        include '../src/config/config.php';

                     $sql = "SELECT rp.*, r.roomtype, rp.roomnumber AS roomno, rp.roomfloor 
        FROM reservationprocess rp 
        INNER JOIN room r ON rp.roomid = r.roomid
        WHERE rp.status = 'Accepted' OR rp.status = 'Check-In' OR rp.status = 'Check-Out'
        ORDER BY rp.reservationcompleted DESC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>";
                                echo "" . $row["recervationprocessid"] . "<br />";
                                echo "</td>";
                                echo "<td>";
                                echo "<b>Name</b>: " . $row["firstname"] . " " . $row["lastname"] . "<br />";
                                echo "<b>Phone No</b>: " . $row["mobilenumber"] . "<br />";

                                echo "</td>";
                                echo "<td>";
                                echo "<b>Room Type</b>: " . $row["roomtype"] . "<br />";
                                echo "<b>Room No</b>: " . $row["roomno"] . "<br />";
                                echo "<b>Room Floor</b>: " . $row["roomfloor"] . "<br />";
                                echo "</td>";
                                echo "<td>";
                                echo "<b>Check-In</b>: " . $row["checkindate"] . " " . date("h:i A", strtotime($row["checkintime"])) . "<br />";
                                echo "<b>Check-Out</b>: " . $row["checkoutdate"] . " " . date("h:i A", strtotime($row["checkouttime"])) . "<br />";
                                echo "<b>Adults</b>: " . $row["adults"] . "<br />";
                                echo "<b>Children</b>: " . $row["children"] . "<br />";
                                echo "</td>";
                                echo "<td>";
                                echo "<b>Payment</b>: " . $row["paymentmethod"] . "<br />";
                                echo "<b>Transaction id</b>: " . $row["transactionid"] . "<br />";
                                echo "<b>Completed</b>: " . date("Y-m-d", strtotime($row["reservationcompleted"])) . "<br />";
                                echo "<b>Paid</b>: ₱" . number_format($row["totalafterpromo"], 2) . "<br />";

                                echo "</td>";

                                echo "<td>";
                                switch ($row["status"]) {
                                    case "Pending":
                                        echo "<button class='btn btn-info w-100' style='border-radius: 8px'>Pending</button>";
                                        break;
                                 case "Accepted":
        echo "<button class='btn btn-success w-100' style='border-radius: 8px'>Accepted</button>";
        break;
    case "Check-In":
        echo "<button class='btn btn-primary w-100' style='border-radius: 8px'>Check-In</button>";
        break;
    case "Check-Out":
        echo "<button class='btn btn-warning w-100' style='border-radius: 8px'>Check-Out</button>";
        break;                                        break;
                                    case "Cancelled":
                                        echo "<button class='btn btn-danger w-100' style='border-radius: 8px'>Cancelled</button>";
                                        break;
                                    case "Payment Failed":
                                        echo "<button class='btn btn-warning w-100' style='border-radius: 8px'>Payment Failed</button>";
                                        break;
                                    default:
                                        echo "<button class='btn btn-secondary w-100' style='border-radius: 8px'>Unknown</button>";
                                        break;
                                }
                                echo "</td>";

                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No reservations found</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>

            <br /><br />
        </div>
    </div>
    <script src="../scripts/jquery.min.js"></script>
    <script src="../scripts/bootstrap.bundle.min.js"></script>

    <script>
    $(function() {
        $("#start_date, #end_date").datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
            var searchText = $(this).val().trim();
            if (searchText !== '') {
                $.ajax({
                    url: 'searchrepors.php',
                    type: 'post',
                    data: {
                        search: searchText
                    },
                    success: function(response) {
                        $('#roomreservation tbody').html(response);
                    }
                });
            }
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $('#startdate, #enddate').change(function() {
            var startDate = $('#startdate').val();
            var endDate = $('#enddate').val();
            if (startDate && endDate) {
                $.ajax({
                    url: 'filter.php',
                    method: 'POST',
                    data: {
                        startDate: startDate,
                        endDate: endDate
                    },
                    success: function(response) {
                        $('#roomreservation tbody').html(response);
                    }
                });
            }
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $(".printdaily").click(function(e) {
            e.preventDefault();
            window.open('printdailyreports.php', '_blank', 'width=800,height=600');
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $(".printweekly").click(function(e) {
            e.preventDefault();
            window.open('printweeklyreports.php', '_blank', 'width=800,height=600');
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $(".printmonthly").click(function(e) {
            e.preventDefault();
            window.open('printmonthlyreports.php', '_blank', 'width=800,height=600');
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $(".printannual").click(function(e) {
            e.preventDefault();
            window.open('printannualreports.php', '_blank', 'width=800,height=600');
        });
    });
    </script>
</body>

</html>