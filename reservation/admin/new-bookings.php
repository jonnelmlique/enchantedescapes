<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: ../auth/login.php");
    exit(); 
}
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Hotel Reservation System | New Bookings</title>

    <link href="../styles/bootstrap.min.css" rel="stylesheet" />
    <link href="../styles/booking.css" rel="stylesheet" />
    <link href="../styles/scrollbar.css" rel="stylesheet" />
    <link href="../styles/admin/newbookings.css" rel="stylesheet" />

</head>

<body>
    <?php include ("components/header.php"); ?>

    <div class="row w-100">
        <div class="col-lg-1">
            <?php include ("components/sidebar.php"); ?>
        </div>

        <div class="col-lg-8 bg-white shadow-lg">
            <div class="px-4">
                <h4 class="fw-bold text-uppercase">&gt; New Bookings</h4>
                <hr>
                <br />

                <div align="right">
                    <input type="search" class="form-control w-100px" name="search" placeholder="Search"
                        style="border-radius: 8px" id="searchInput" />
                </div>
                <br />

                <table class="table table-hover table-stripped border border-dark" style="border-radius: 8px"
                    id="roomreservation">
                    <thead>
                        <tr>
                            <td class="bg-dark text-white">Guest Details</td>
                            <td class="bg-dark text-white">Room Details</td>
                            <td class="bg-dark text-white">Booking Details</td>
                            <td class="bg-dark text-white">Payment Details</td>
                            <td class="bg-dark text-white">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <td>1</td>
                            <td>
                                <p>
                                    <b>Booking ID</b>: 123456<br />
                                    <b>Name</b>: John Doe<br />
                                    <b>Phone No.</b>: 123456
                                </p>
                            </td>
                            <td>
                                <p>
                                    <b>Room Type</b>: Deluxe<br />
                                    <b>Room No.</b>: DR101<br />
                                    <b>Price</b>: Php10,000
                                </p>
                            </td>
                            <td>
                                <p>
                                    <b>Check-In</b>: 01-22-24<br />
                                    <b>Check-Out</b>: 01-26-24<br />
                                    <b>Paid</b>: Php2,000<br />
                                    <b>Date</b>: 01-26-24
                                </p>
                            </td>
                            <td>
                                <button class="btn btn-success w-100" style="border-radius: 8px" data-bs-toggle="modal"
                                    data-bs-target="#confirmModal">Confirm</button><br />
                                <button class="btn btn-danger w-100 mt-2" style="border-radius: 8px"
                                    data-bs-toggle="modal" data-bs-target="#cancelModal">Cancel</button>
                            </td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr> -->
                        <?php
                        include '../src/config/config.php';

                        $sql = "SELECT rp.*, r.roomtype, rp.roomnumber AS roomno, rp.roomfloor 
                        FROM reservationprocess rp 
                        INNER JOIN room r ON rp.roomid = r.roomid
                        WHERE rp.status = 'Pending'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
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
                                echo "<b>Paid</b>: ₱" . number_format($row["totalafterpromo"], 2) . "<br />";

                                echo "</td>";
                                echo "<td>";
                                echo "<button class='btn btn-success w-100 confirmBtn' data-id='" . $row["recervationprocessid"] . "' style='border-radius: 8px'>Confirm</button><br />";
                                echo "<button class='btn btn-danger w-100 mt-2 cancelBtn' data-id='" . $row["recervationprocessid"] . "' style='border-radius: 8px'>Cancel</button>";
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
    function confirmReservation(id) {
        swal({
                title: "Are you sure?",
                text: "Are you sure you want to confirm this reservation?",
                icon: "warning",
                buttons: true,
                dangerMode: false,
            })
            .then((confirm) => {
                if (confirm) {

                    $.ajax({
                        type: 'POST',
                        url: 'update_reservation_status.php',
                        data: {
                            id: id,
                            status: 'Accepted'
                        },
                        success: function(response) {
                            swal("Reservation confirmed!", {
                                icon: "success",
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            swal("Error", "Failed to update reservation status", "error");
                        }
                    });
                }
            });
    }

    function cancelReservation(id) {
        swal({
                title: "Are you sure?",
                text: "Are you sure you want to cancel this reservation?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((cancel) => {
                if (cancel) {
                    $.ajax({
                        type: 'POST',
                        url: 'update_reservation_status.php',
                        data: {
                            id: id,
                            status: 'Cancelled'
                        },
                        success: function(response) {
                            swal("Reservation cancelled!", {
                                icon: "success",
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            swal("Error", "Failed to update reservation status", "error");
                        }
                    });
                }
            });
    }

    $(document).ready(function() {
        $('.confirmBtn').click(function() {
            var id = $(this).data('id');
            confirmReservation(id);
        });

        $('.cancelBtn').click(function() {
            var id = $(this).data('id');
            cancelReservation(id);
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
            var searchText = $(this).val().trim();
            if (searchText !== '') {
                $.ajax({
                    url: 'search.php',
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

    </html>