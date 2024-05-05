<?php
session_start();

include './src/config/config.php';
if (!isset($_SESSION['data_inserted'])) {
    $sql = "INSERT INTO guestusers () VALUES ()";
    if ($conn->query($sql) === TRUE) {
        $sql_select = "SELECT guestuserid FROM guestusers ORDER BY timestamp_column DESC LIMIT 1";
        $result = $conn->query($sql_select);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $guestuserid = $row['guestuserid'];
            $_SESSION['guestuserid'] = $guestuserid;
            $_SESSION['data_inserted'] = true;
        } else {
        }
    } else {
    }
}
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Book Now</title>

    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="styles/booking.css" rel="stylesheet" />
    <link href="styles/bootstrap.min.css" rel="stylesheet" />
    <link href="styles/dashboard.css" rel="stylesheet" />
    <link href="styles/scrollbar.css" rel="stylesheet" />

</head>

<div><?php include ("componentshome/navbar.php"); ?>

    <div class="bg-white">
        <br /><br />
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <?php

                    if (isset($_SESSION['guestuserid'])) {
                        $guestUserId = $_SESSION['guestuserid'];


                        $sql = "SELECT adults, children, checkindate, checkoutdate FROM reservationsummary WHERE guestuserid = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $guestUserId);
                        $stmt->execute();
                        $stmt->bind_result($adults, $children, $checkInDate, $checkOutDate);
                        $stmt->fetch();
                        $stmt->close();

                        if (empty($adults)) {
                            $adults = 0;
                        }
                        if (empty($children)) {
                            $children = 0;
                        }

                        ?>
                    <div class="card card-body bg-primary p-4" style="border-radius: 12px">
                        <div class="row pt-2 px-2">
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-3">
                                        <i class="lni lni-users display-5"></i>
                                    </div>
                                    <div class="col-9">
                                        <div class="px-2">
                                            <p class="p-0 pt-2 text-white">Guest<br /><?php echo $adults; ?> Adult(s),
                                                <?php echo $children; ?> Children
                                            </p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-3">
                                        <i class="lni lni-calendar display-5"></i>
                                    </div>
                                    <div class="col-9">
                                        <div class="px-2">
                                            <p class="p-0 pt-2 text-white">
                                                Check-in<br /><?php echo !empty($checkInDate) ? date('D F j, Y', strtotime($checkInDate)) : "No date"; ?>
                                            </p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-3">
                                        <i class="lni lni-calendar display-5"></i>
                                    </div>
                                    <div class="col-9">
                                        <div class="px-2">
                                            <p class="p-0 pt-2 text-white">
                                                Check-out<br /><?php echo !empty($checkOutDate) ? date('D F j, Y', strtotime($checkOutDate)) : "No date"; ?>
                                            </p>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    } else {
                        echo "Guest user ID not found in session.";
                    }
                    ?>
                    <br />

                    <h3 class="fw-bold">Select a Room</h3>
                    <img src="assets/step-1.png" width="100%" />

                    <div class="row mt-4">


                        <!-- <div class="col-6">
                            <div class="border border-2 border-primary p-2" style="border-radius: 8px; width: auto">
                                <b class="px-1">Room Type</b><br />
                                <select name="room" class="border-0 w-100">

                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="border border-2 border-primary p-2" style="border-radius: 8px; width: auto">
                                <b class="px-1">Sort By</b><br />
                                <select name="price" class="border-0 w-100">
                                    <option value="lowest">Lowest Price</option>
                                    <option value="lowest">Highest Price</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br /> -->
                        <?php
                        $sqlRoomTypes = "SELECT DISTINCT roomtype FROM room";
                        $resultRoomTypes = $conn->query($sqlRoomTypes);

                        $selectedRoomType = isset($_POST['room']) ? $_POST['room'] : '';
                        $sortByPrice = isset($_POST['price']) ? $_POST['price'] : '';

                        $sql = "SELECT * FROM room";
                        if (!empty($selectedRoomType)) {
                            $sql .= " WHERE roomtype = '$selectedRoomType'";
                        }

                        if (!empty($sortByPrice)) {
                            if ($sortByPrice == 'lowest') {
                                $sql .= " ORDER BY price ASC";
                            } elseif ($sortByPrice == 'highest') {
                                $sql .= " ORDER BY price DESC";
                            }
                        }

                        $result = $conn->query($sql);

                        if ($result) {
                            if ($result->num_rows > 0) {
                                echo '<div class="col-6">';
                                echo '<div class="border border-2 border-primary p-2" style="border-radius: 8px; width: auto">';
                                echo '<b class="px-1">Room Type</b><br />';
                                echo '<select name="room" class="border-0 w-100" onchange="filterRooms()">';
                                echo '<option value="">All</option>';
                                while ($rowRoomType = $resultRoomTypes->fetch_assoc()) {
                                    $selected = ($selectedRoomType == $rowRoomType['roomtype']) ? 'selected' : '';
                                    echo '<option value="' . $rowRoomType['roomtype'] . '" ' . $selected . '>' . $rowRoomType['roomtype'] . '</option>';
                                }
                                echo '</select>';
                                echo '</div>';
                                echo '</div>';

                                echo '<div class="col-6">';
                                echo '<div class="border border-2 border-primary p-2" style="border-radius: 8px; width: auto">';
                                echo '<b class="px-1">Sort By</b><br />';
                                echo '<select name="price" class="border-0 w-100" onchange="filterRooms()">';
                                echo '<option value="lowest" ' . ($sortByPrice == 'lowest' ? 'selected' : '') . '>Lowest Price</option>';
                                echo '<option value="highest" ' . ($sortByPrice == 'highest' ? 'selected' : '') . '>Highest Price</option>';
                                echo '</select>';
                                echo '</div>';
                                echo '</div>';

                                echo '</div><br /><br />';

                                echo '<div id="roomList">';
                                while ($row = $result->fetch_assoc()) {
                                }
                                echo '</div>';
                            } else {
                                echo "No rooms available.";
                            }
                        } else {
                            echo "Error fetching rooms: " . $conn->error;
                        }
                        ?>
                        <?php

                        $sql = "SELECT * FROM room WHERE status = 'Available'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                        <a href="roomdetails.php?roomid=<?php echo $row['roomid']; ?>"
                            style="text-decoration: none; color: inherit;">

                            <div class="border border-primary w-100 p-2"
                                style="border-radius: 12px; transition: background-color 0.3s ease;"
                                onmouseover="this.style.backgroundColor='#f0f0f0';"
                                onmouseout="this.style.backgroundColor='';">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="./rooms/<?php echo $row["image"]; ?>" alt="Rooms Image" class="w-100"
                                            style="border-radius: 8px" />

                                    </div>

                                    <div class="col-4">
                                        <h4 class="fw-bold mt-2"><?php echo $row['roomtype']; ?></h4>
                                        <p>
                                            <i class="lni lni-home"></i> Beds:
                                            <?php echo $row['bedsavailable']; ?><br />
                                            <i class="lni lni-layers"></i> Included:
                                            <?php echo $row['roominclusion']; ?><br />
                                            <i class="lni lni-user"></i> Ocuppancy: <?php echo $row['maxoccupancy']; ?>

                                        </p>
                                    </div>

                                    <div class="col-3">
                                        <h4 class="fw-bold mt-2">
                                            ₱<?php echo number_format($row['price'], 2, '.', ','); ?></h4>
                                        <small>Per Night</small> <br><br />
                                        <h4 class="fw-bold mt-2">
                                            ₱<?php echo number_format($row['reservationprice'], 2, '.', ','); ?>
                                        </h4>Reservation

                                        <br /><br />
                                        <button class="btn btn-primary w-100 reserve-btn" style="border-radius: 8px">
                                            Reserve
                                            Now </button>
                                        <!-- <button class="btn btn-primary w-100 reserve-btn" style="border-radius: 8px"
                                        data-roomid="<?php echo $row['roomid']; ?>"
                                        data-roomtype="<?php echo $row['roomtype']; ?>"
                                        data-maxoccupancy="<?php echo $row['maxoccupancy']; ?>"
                                        data-price="<?php echo $row['price']; ?>"
                                        data-reservationprice="<?php echo $row['reservationprice']; ?>"
                                        data-bs-toggle="modal" data-bs-target="#reserveModal">
                                        Reserve Now
                                    </button> -->

                                    </div>
                                </div>
                            </div>
                        </a>
                        <br />
                        <?php
                            }
                        } else {
                            echo "No rooms available.";
                        }
                        ?>

                    </div>

                    <?php
                    if (isset($_SESSION['guestuserid'])) {
                        $guestuserid = $_SESSION['guestuserid'];

                        $sql = "SELECT bc.*, r.roomtype 
            FROM reservationsummary bc 
            INNER JOIN room r ON bc.roomid = r.roomid 
            WHERE bc.guestuserid = '$guestuserid'";
                        $result = $conn->query($sql);
                        $totalReservationPrice = 0;

                        echo "<div class='col-4'>
            <div class='p-2 w-100 border border-primary border-2' style='border-radius: 8px'>
                <h4 class='fw-bold text-uppercase mt-2' align='center'>Your Booking Summary</h4>
                <hr class='mt-2 mx-3' />";

                        if ($result->num_rows > 0) {

                            while ($row = $result->fetch_assoc()) {
                                $checkinDate = $row['checkindate'];
                                $checkinTime = date("h:i A", strtotime($row['checkintime']));
                                $checkinDay = date("l", strtotime($checkinDate));
                                $checkoutDate = $row['checkoutdate'];
                                $checkoutTime = date("h:i A", strtotime($row['checkouttime']));
                                $checkoutDay = date("l", strtotime($checkoutDate));
                                $roomtype = $row['roomtype'];
                                $roomfloor = $row['roomfloor'];
                                $roomnumber = $row['roomnumber'];

                                $reservationPrice = $row['reservationprice'];
                                $totalReservationPrice += $reservationPrice;
                                echo "<div class='row mx-2 pt-2'>
                    <div class='col-6' align='center'>
                        <b class='text-uppercase'>Check-in</b><br />
                        <small>$checkinDay, $checkinDate $checkinTime</small>
                    </div>
                    <div class='col-6' align='center'>
                        <b class='text-uppercase'>Check-out</b><br />
                        <small>$checkoutDay, $checkoutDate $checkoutTime</small>
                    </div>
                </div>
                <div class='row pt-4' align='center'>
                <div class='col-6'>
                <label>Room Floor:</label>
                    <small class='text-primary'>$roomfloor</small>
                </div>
                <div class='col-6'>
                <label>Room Number:</label>
                <small class='text-primary'>$roomnumber</small>
                </div>
            </div>
                <div class='row pt-4' align='center'>
                    <div class='col-6'>
                        <small class='text-primary'>$roomtype</small>
                    </div>
                    <div class='col-6'>
                    <small>₱" . number_format($reservationPrice, 2) . "</small>
                    </div>
                </div>
               
                <div align='center'>
                    <div class='row w-75 pt-4'>
                    
                        <div class='col-12'>
                        <small><i class='lni lni-trash-can' onclick='confirmDelete(" . $row['reservationsumid'] . ")'></i> Remove</small>
                        </div>
                    </div>
                <hr class='mt-2 mx-3' />";
                            }
                            echo "<div class='row mx-2 pt-2'>
                        <div class='col-6'><b>Total</b></div>
                        <div class='col-6' align='right'>₱" . number_format($totalReservationPrice, 2) . "</div>
                      </div>";

                            echo "</div></div>";

                            echo "<a href='guest-details.php' class='btn continue-btn w-100 text-uppercase' style='border-radius: 8px; margin-top: 15px; background-color: #D4AF37; color: #fff; border-color: #D4AF37; transition: background-color 0.3s;' onmouseover=\"this.style.backgroundColor='#6e5b1d'; this.style.borderColor='#6e5b1d';\" onmouseout=\"this.style.backgroundColor='#D4AF37'; this.style.borderColor='#D4AF37';\">Continue</a>";

                            echo "</div>";
                        } else {
                            echo "<div align='center'>No bookings found.</div>";
                        }


                    } else {
                        echo "Guest user ID not found in session.";
                    }
                    ?>


                </div>
            </div>
        </div>
        <br /><br />
    </div>


    <script src="scripts/jquery.min.js"></script>
    <script src="scripts/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function filterRooms() {
        var roomType = document.querySelector('select[name="room"]').value;
        var price = document.querySelector('select[name="price"]').value;

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("roomList").innerHTML = this.responseText;
            }
        };
        xhttp.onerror = function() {
            console.error("Request failed");
        };
        xhttp.open("POST", "filter_rooms.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("room=" + roomType + "&price=" + price);
    }
    </script>

    <script>
    function confirmDelete(reservationId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete this reservation.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteReservation(reservationId);
            }
        });
    }

    function deleteReservation(reservationId) {
        $.ajax({
            url: 'delete_reservation.php',
            method: 'POST',
            data: {
                reservationId: reservationId
            },
            success: function(response) {
                Swal.fire({
                    title: 'Deleted!',
                    text: 'Your reservation has been deleted.',
                    icon: 'success',
                    showConfirmButton: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();

                    }
                });

            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'An error occurred while deleting the reservation.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    }
    </script>

    <?php include ("components/footer.php"); ?>
    </body>

    </html>