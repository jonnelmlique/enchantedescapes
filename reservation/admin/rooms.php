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

    <title>Hotel Reservation System | Rooms</title>

    <link href="../styles/bootstrap.min.css" rel="stylesheet" />
    <link href="../styles/booking.css" rel="stylesheet" />
    <link href="../styles/scrollbar.css" rel="stylesheet" />
    <link href="../styles/admin/rooms.css" rel="stylesheet" />
</head>

<body>
    <?php include ("components/header.php"); ?>

    <div class="row w-100">
        <div class="col-lg-1">
            <?php include ("components/sidebar.php"); ?>
        </div>

        <div class="col-lg-8 bg-white shadow-lg">
            <div class="px-4">
                <h4 class="fw-bold text-uppercase">&gt; Rooms</h4>
                <hr>
                <br />

                <div align="right">
                    <input type="search" class="form-control w-auto d-inline mx-2" name="search" placeholder="Search"
                        style="border-radius: 8px" id="searchInput" />
                    <button class="btn btn-primary text-uppercase px-4" data-bs-toggle="modal"
                        data-bs-target="#addModal">Add</button>
                    <a href="addroominfo.php" class="btn btn-primary text-uppercase px-4">Add Room Info</a>
                </div>
                <br />
                <table class="table table-hover table-stripped border border-dark"
                    style="border-radius: 8px; table-layout: fixed" id="roomsearch">
                    <thead>
                        <tr>
                            <td class="bg-dark text-white">Room Type</td>
                            <td class="bg-dark text-white"></td>
                            <td class="bg-dark text-white">Room Inclusion</td>
                            <td class="bg-dark text-white">Beds</td>
                            <td class="bg-dark text-white">Max Occupancy</td>
                            <td class="bg-dark text-white">Reservation Price</td>
                            <td class="bg-dark text-white">Status</td>
                            <td class="bg-dark text-white">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include '../src/config/config.php';
                        $query = "SELECT * FROM room";
                        $result = $conn->query($query);

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['roomtype'] . "</td>";
                                echo "<td><img src='../rooms/" . $row['image'] . "' class='w-100' /></td>";

                                $room_inclusions = explode(',', $row['roominclusion']);
                                echo "<td>";
                                foreach ($room_inclusions as $inclusion) {
                                    $inclusion = trim($inclusion);
                                    echo "<div class='cloud'>" . $inclusion . "</div>";
                                }
                                echo "</td>";
                                echo "<td>";
                                $beds_available = $row['bedsavailable'];
                                $beds_array = explode(',', $beds_available); 
                                foreach ($beds_array as $bed) {
                                    echo "<div class='cloud'>" . $bed . "</div>"; 
                                }
                                echo "</td>";



                                echo "<td>" . $row['maxoccupancy'] . "</td>";
                                echo "<td>₱" . number_format($row['reservationprice'], 2, '.', ',') . "</td>";
                                echo "<td><p class='text-" . ($row['status'] == 'Booked' ? 'danger' : 'success') . " '>" . $row['status'] . "</p></td>";
                                echo "<td><a href='./editroom.php?id=" . $row["roomid"] . "' class='btn btn-success w-100 px-2 edit-room-btn'>Edit</td>";

                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No rooms found</td></tr>";
                        }
                        ?>
                    </tbody>


                </table>


            </div>

            <br /><br />
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: #FAEBD7">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Room</h5>
                </div>

                <div class="modal-body" align="center">

                    <div class="row mt-1">
                        <div class="col-4" align="right">
                            <p class="mt-2">Room Type</p>
                        </div>
                        <div class="col-8">
                            <select class="form-control" id="edit-room-type" name="edit-room-type"
                                style="border-radius: 8px" required>
                                <option value="" disabled selected>Select Room Type</option>
                                <?php
                                include "../src/config/config.php";

                                $sql = "SELECT DISTINCT roomtype FROM roominfo";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['roomtype'] . "'>" . $row['roomtype'] . "</option>";
                                    }
                                }
                                $conn->close();
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-4" align="right">
                            <p class="mt-2">Room Inclusion</p>
                        </div>
                        <div class="col-8"><input type="text" class="form-control" name="edit-room-inc"
                                style="border-radius: 8px" placeholder="Room Inclusion" required />
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4" align="right">
                            <p class="mt-2">Beds Available</p>
                        </div>
                        <div class="col-8"><input type="text" class="form-control" name="edit-room-beds"
                                style="border-radius: 8px" placeholder="Beds Available" required /></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4" align="right">
                            <p class="mt-2">Max Occupancy</p>
                        </div>
                        <div class="col-8"><input type="number" class="form-control" name="edit-room-maxoccupancy"
                                style="border-radius: 8px" placeholder="Max Occupancy" required /></div>
                    </div>




                    <div class="row mt-1">
                        <div class="col-4" align="right">
                            <p class="mt-2">Price</p>
                        </div>
                        <div class="col-8"><input type="number" class="form-control" name="edit-price"
                                style="border-radius: 8px" placeholder="Price" required /></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4" align="right">
                            <p class="mt-2">Reservation Price</p>
                        </div>
                        <div class="col-8"><input type="number" class="form-control" name="edit-rprice"
                                style="border-radius: 8px" placeholder="Reservation Price" required /></div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-4" align="right">
                            <p class="mt-2">Status</p>
                        </div>
                        <div class="col-8">
                            <select class="form-control" name="edit-status" style="border-radius: 8px" required>
                                <option value="Available">Available</option>
                                <option value="Booked">Booked</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-4" align="right">
                            <p class="mt-2">Image</p>
                        </div>
                        <div class="col-8"><input type="file" class="form-control" name="edit-image"
                                style="border-radius: 8px" required /></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn continue-btn" id="save-room-btn">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: #FAEBD7">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Add Room</h5>

                </div>
                <div class="modal-body" align="center">
                    <form method="post" action="addroom.php" enctype="multipart/form-data" class="needs-validation">
                        <div class="row">
                            <div class="row mt-1">
                                <div class="col-4" align="right">
                                    <p class="mt-2">Room Type</p>
                                </div>
                                <div class="col-8">
                                    <select class="form-control" id="add-room-type" name="add-room-type"
                                        style="border-radius: 8px" required>
                                        <option value="" disabled selected>Select Room Type</option>
                                        <?php
                                        include "../src/config/config.php";

                                        $sql = "SELECT DISTINCT roomtype FROM roominfo";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='" . $row['roomtype'] . "'>" . $row['roomtype'] . "</option>";
                                            }
                                        }
                                        $conn->close();
                                        ?>
                                    </select>
                                </div>
                            </div>


                            <div class="row mt-1">
                                <div class="col-4" align="right">
                                    <p class="mt-2">Room Inclusion</p>
                                </div>
                                <div class="col-8"><input type="text" class="form-control" name="add-room-inc"
                                        style="border-radius: 8px" placeholder="Room Inclusion" required />
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-4" align="right">
                                    <p class="mt-2">Beds Available</p>
                                </div>
                                <div class="col-8"><input type="text" class="form-control" name="add-room-beds"
                                        style="border-radius: 8px" placeholder="Beds Available" required /></div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-4" align="right">
                                    <p class="mt-2">Max Occupancy</p>
                                </div>
                                <div class="col-8"><input type="number" class="form-control"
                                        name="add-room-maxoccupancy" style="border-radius: 8px"
                                        placeholder="Max Occupancy" required /></div>
                            </div>



                            <div class="row mt-1">
                                <div class="col-4" align="right">
                                    <p class="mt-2">Price</p>
                                </div>
                                <div class="col-8"><input type="number" class="form-control" name="add-price"
                                        style="border-radius: 8px" placeholder="Price" required /></div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-4" align="right">
                                    <p class="mt-2">Reservation Price</p>
                                </div>
                                <div class="col-8"><input type="number" class="form-control" name="add-rprice"
                                        style="border-radius: 8px" placeholder="Reservation Price" required /></div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-4" align="right">
                                    <p class="mt-2">Status</p>
                                </div>
                                <div class="col-8">
                                    <select class="form-control" name="add-status" style="border-radius: 8px" required>
                                        <option value="Available">Available</option>
                                        <option value="Booked">Booked</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-4" align="right">
                                    <p class="mt-2">Image</p>
                                </div>
                                <div class="col-8"><input type="file" class="form-control" name="add-image"
                                        style="border-radius: 8px" required /></div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn continue-btn">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="../scripts/jquery.min.js"></script>
        <script src="../scripts/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script>
        $(document).ready(function() {
            $("#addModal form").submit(function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);

                $.ajax({
                    url: "addroom.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log("Response:", response);

                        try {
                            var jsonData = JSON.parse(response);
                            console.log("Parsed JSON:", jsonData);

                            if (jsonData.message === "success") {
                                Swal.fire({
                                    title: 'Rooms Added Successfully!',
                                    text: 'You have successfully added the Room.',
                                    icon: 'success',
                                    showCancelButton: true,
                                    confirmButtonText: 'OK',
                                    cancelButtonText: 'View Rooms'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();

                                    } else if (result.dismiss === Swal.DismissReason
                                        .cancel) {
                                        window.location.href =
                                            '../admin/rooms.php';
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: jsonData.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        } catch (error) {
                            console.error("Error parsing JSON:", error);
                            Swal.fire({
                                title: 'Error',
                                text: 'An unexpected error occurred.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', xhr.responseText);
                        Swal.fire({
                            title: 'Error',
                            text: 'An unexpected error occurred.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
        </script>
        <script>
        $(document).ready(function() {
            $('.edit-room-btn').click(function() {
                var roomId = $(this).data('room-id');
                $.ajax({
                    url: 'fetch_room.php',
                    type: 'post',
                    data: {
                        room_id: roomId
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#edit-room-type').val(response.roomtype);
                        $('input[name="edit-room-inc"]').val(response.roominclusion);
                        $('input[name="edit-room-beds"]').val(response.bedsavailable);
                        $('input[name="edit-room-maxoccupancy"]').val(response
                            .maxoccupancy);
                        $('select[name="edit-room-deposit"]').val(response.deposit);
                        $('input[name="edit-price"]').val(response.price);
                        $('input[name="edit-rprice"]').val(response.reservationprice);
                        $('select[name="edit-status"]').val(response.status);
                    }
                });
            });

            $('#save-room-btn').click(function() {
                var roomId = $('.edit-room-btn').data('room-id');
                var roomType = $('#edit-room-type').val();
                var roomInc = $('input[name="edit-room-inc"]').val();
                var bedsAvailable = $('input[name="edit-room-beds"]').val();
                var maxOccupancy = $('input[name="edit-room-maxoccupancy"]').val();
                var deposit = $('select[name="edit-room-deposit"]').val();
                var price = $('input[name="edit-price"]').val();
                var reservationPrice = $('input[name="edit-rprice"]').val();
                var status = $('select[name="edit-status"]').val();

                var formData = new FormData();
                formData.append('room_id', roomId);
                formData.append('room_type', roomType);
                formData.append('room_inc', roomInc);
                formData.append('beds_available', bedsAvailable);
                formData.append('max_occupancy', maxOccupancy);
                formData.append('deposit', deposit);
                formData.append('price', price);
                formData.append('reservation_price', reservationPrice);
                formData.append('status', status);
                var imageFile = $('input[name="edit-image"]').prop('files')[0];
                if (imageFile) {
                    formData.append('edit-image', imageFile);
                }

                formData.append('action', 'update');

                $.ajax({
                    url: 'fetch_room.php',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.success,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(function() {
                                location.reload();
                            });
                        } else if (response.error) {
                            Swal.fire({
                                title: 'Error',
                                text: response.error,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'No Changes Detected',
                                text: 'There are no changes in the room information.',
                                icon: 'info',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'An unexpected error occurred. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
        </script>
        <script>
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                var searchText = $(this).val().trim();
                if (searchText !== '') {
                    $.ajax({
                        url: 'searchrooms.php',
                        type: 'post',
                        data: {
                            search: searchText
                        },
                        success: function(response) {
                            $('#roomsearch tbody').html(response);
                        }
                    });
                }
            });
        });
        </script>



</body>

</html>