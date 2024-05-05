<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Room Details</title>

    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="styles/roomdetails.css" rel="stylesheet" />
    <link href="styles/bootstrap.min.css" rel="stylesheet" />
    <link href="styles/scrollbar.css" rel="stylesheet" />
</head>

<body>
    <?php include ("componentshome/navbar.php"); ?>
    <form method="post" action="reservation_handler.php" id="reservationForm">

        <div class="container product-details">
            <div class="row">
                <?php
                include './src/config/config.php';

                if (isset($_GET['roomid'])) {
                    $roomid = $_GET['roomid'];

                    $sql = "SELECT * FROM room WHERE roomid = $roomid";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $roomtype = $row['roomtype'];
                        echo '<div class="col-md-6 product-details-img">';
                        echo '<img src="./rooms/' . $row['image'] . '" alt="Room Image">';
                        echo '</div>';

                        echo '<div class="col-md-6">';
                        echo '<h2 class="product-details-title">' . $row['roomtype'] . '</h2>';
                        echo '<hr><p class="product-details-reservationprice">Reservation: ₱' . number_format($row['reservationprice'], 2) . '</p>';
                        echo '<p class="product-details-description">Max Occupancy: ' . $row['maxoccupancy'] . '</p>';

                        echo '<p class="product-details-description">Included: ' . $row['roominclusion'] . '</p>';

                        echo '<p class="product-details-description">Beds Available: ' . $row['bedsavailable'] . '</p><hr>';

                        echo '<div class="row">';
                        echo '<div class="col-4"><p class="product-details-description">Adults:</p></div>';
                        echo '<div class="col-8"><input type="number" class="form-control" name="add-adults" value="0" id="addAdults" style="border-radius: 8px" placeholder="Adults" required min="0" step="1" max=""></div>';
                        echo '</div>';
                        echo '<div class="row">';
                        echo '<div class="col-4"><p class="product-details-description">Children:</p></div>';
                        echo '<div class="col-8"><input type="number" value="0" class="form-control" name="add-children" id="addChildren" style="border-radius: 8px" placeholder="Children" required min="0" step="1"></div>';
                        echo '</div>';
                        echo '<label class="checkin" for="checkInDate">Check-in Date & Time:</label>';
                        echo '<input type="date" id="checkInDate" name="checkInDate" required>';
                        echo '<input type="time" id="checkInTime" name="checkInTime" required>';

                        echo '<label class="checkout" for="checkOutDate">Check-out Date & Time:</label>';
                        echo '<input type="date" id="checkOutDate" name="checkOutDate" required>';
                        echo '<input type="time" id="checkOutTime" name="checkOutTime" required>';

                        echo '<div class="row mt-1">';
                        echo '<div class="col-4"><p class="product-details-description">Floor Select:</p></div>';
                        echo '<div class="col-8">';
                        echo '<select class="form-select mt-1" id="floorSelect" name="floorSelect" style="border-radius: 8px" required>';

                        $sql_roominfo_floors = "SELECT DISTINCT roomfloor FROM roominfo WHERE roomtype = '$roomtype'";
                        $result_roominfo_floors = $conn->query($sql_roominfo_floors);

                        if ($result_roominfo_floors->num_rows > 0) {
                            echo '<option selected disabled>Select Room Floor</option>';
                            while ($row_roominfo_floors = $result_roominfo_floors->fetch_assoc()) {
                                echo '<option value="' . $row_roominfo_floors['roomfloor'] . '">' . $row_roominfo_floors['roomfloor'] . '</option>';
                            }
                        } else {
                            echo '<option selected disabled>No floors found for the specified room type</option>';
                        }

                        echo '</select>';
                        echo '</div>';
                        echo '</div>';

                        echo '<div class="row mt-1">';
                        echo '<div class="col-4"><p class="product-details-description">Room Number:</p></div>';
                        echo '<div class="col-8">';
                        echo '<select class="form-select mt-1" id="roomNumberSelect" name="roomNumberSelect" style="border-radius: 8px" required>';
                        echo '<option selected disabled>Select Room Number</option>';
                        echo '</select>';
                        echo '</div>';
                        echo '</div>';

                        echo '<div class="form-group">';
                        echo '<button type="submit" class="btn btn-primary" id="reserveNowBtn" style="border-radius: 8px; padding: 10px 20px;">Reserve Now</button>';
                        echo '</div>';

                        echo '</div>';
                    } else {
                        echo "Room not found.";
                    }
                } else {
                    echo "Room ID not provided.";
                }
                ?>
            </div>
        </div>
        <input type="hidden" name="roomid" value="<?php echo $_GET['roomid']; ?>">

    </form>

    <script src="scripts/jquery.min.js"></script>
    <script src="scripts/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const floorSelect = document.getElementById('floorSelect');
        const roomNumberSelect = document.getElementById('roomNumberSelect');
        const checkInDateInput = document.getElementById('checkInDate');

        floorSelect.addEventListener('change', function() {
            const selectedFloor = floorSelect.value;
            const selectedCheckInDate = checkInDateInput.value;
            roomNumberSelect.innerHTML = '<option selected disabled>Loading...</option>';
            fetchRooms(selectedFloor, selectedCheckInDate);
        });

        checkInDateInput.addEventListener('change', function() {
            const selectedFloor = floorSelect.value;
            const selectedCheckInDate = checkInDateInput.value;
            roomNumberSelect.innerHTML = '<option selected disabled>Loading...</option>';
            fetchRooms(selectedFloor, selectedCheckInDate);
        });

        function fetchRooms(floor, checkInDate) {
            fetch('fetch_available_rooms.php?floor=' + floor + '&checkin_date=' + checkInDate)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (!Array.isArray(data)) {
                        throw new Error('Response data is not an array');
                    }
                    roomNumberSelect.innerHTML =
                        '<option selected disabled>Select Room Number</option>';
                    data.forEach(room => {
                        const option = document.createElement('option');
                        option.value = room.roomnumber;
                        option.textContent = room.roomnumber;
                        roomNumberSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching room numbers:', error);
                    roomNumberSelect.innerHTML =
                        '<option selected disabled>Error fetching room numbers</option>';
                });
        }

    });
    </script>

    <script>
    $(document).ready(function() {
        $('#reservationForm').submit(function(e) {
            e.preventDefault();
            var adults = parseInt($('#addAdults').val());
            var children = parseInt($('#addChildren').val());
            var maxOccupancy = parseInt('<?php echo $row['maxoccupancy']; ?>');
            var totalGuests = adults + children;
            if (totalGuests > maxOccupancy) {
                Swal.fire({
                    title: 'Error',
                    text: 'The total number of guests exceeds the maximum occupancy for this room.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else {
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json', // Specify JSON data type
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Reservation Added!',
                                text: 'Your reservation has been successfully added.',
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "./book-now.php";
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response.error ||
                                    'An error occurred while processing the reservation. Please try again later.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'An error occurred while processing the reservation. Please try again later.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });
    </script>

    <script>
    document.getElementById('checkInDate').addEventListener('change', function() {
        var checkInDate = new Date(this.value);
        var checkOutDateInput = document.getElementById('checkOutDate');
        var checkOutDate = new Date(checkOutDateInput.value);

        if (checkInDate > checkOutDate) {
            checkOutDateInput.value = this.value;
        }
        checkOutDateInput.min = this.value;
    });
    </script>
    <script>
    var currentDate = new Date().toISOString().split('T')[0];
    document.getElementById('checkInDate').setAttribute('min', currentDate);
    document.getElementById('checkOutDate').setAttribute('min', currentDate);
    </script>



    <?php include ("components/footer.php"); ?>
</body>

</html>