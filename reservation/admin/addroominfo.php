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
                <h4 class="fw-bold text-uppercase">&gt; Room Info</h4>
                <hr>
                <br />

                <div align="right">

                    <button class="btn btn-primary text-uppercase px-4" data-bs-toggle="modal"
                        data-bs-target="#addModal">Add</button>
                </div>
                <br />
                <table class="table table-hover table-stripped border border-dark"
                    style="border-radius: 8px; table-layout: fixed">
                    <thead>
                        <tr>
                            <td class="bg-dark text-white">Room Type</td>
                            <td class="bg-dark text-white">Room Number</td>
                            <td class="bg-dark text-white">Room Floor</td>
                            <td class="bg-dark text-white">Action</td>


                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include '../src/config/config.php';
                        $query = "SELECT * FROM roominfo";
                        $result = $conn->query($query);

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['roomtype'] . "</td>";
                                echo "<td>" . $row['roomnumber'] . "</td>";
                                echo "<td>" . $row['roomfloor'] . "</td>";
                                echo "<td><a href='./editroominfo.php?infoid=" . $row["roominfoid"] . "' class='btn btn-success w-100 px-2 edit-room-btn'>Edit</td>";


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

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: #FAEBD7">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Add Room Info</h5>

                </div>
                <div class="modal-body" align="center">
                    <form method="post" action="addroomi.php" enctype="multipart/form-data" class="needs-validation">
                        <div class="row">

                            <div class="row mt-1">
                                <div class="col-4" align="right">
                                    <p class="mt-2">Room Type</p>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="add-room-type"
                                        style="border-radius: 8px" placeholder="Room Type" required />
                                </div>
                            </div>


                            <div class="row mt-1">
                                <div class="col-4" align="right">
                                    <p class="mt-2">Room Number</p>
                                </div>
                                <div class="col-8"><input type="text" class="form-control" name="add-room-number"
                                        style="border-radius: 8px" placeholder="Room Number" required /></div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-4" align="right">
                                    <p class="mt-2">Room Floor</p>
                                </div>
                                <div class="col-8"><input type="number" class="form-control" name="add-room-floor"
                                        style="border-radius: 8px" placeholder="Room Floor" required /></div>
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
                    url: "addroomi.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log("Response:", response);

                        try {
                            if (response.message === "success") {
                                Swal.fire({
                                    title: 'Room Info Added Successfully!',
                                    text: 'You have successfully added the Room Info.',
                                    icon: 'success',
                                    showCancelButton: true,
                                    confirmButtonText: 'OK',
                                    cancelButtonText: 'View Room Info'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    } else if (result.dismiss === Swal.DismissReason
                                        .cancel) {
                                        window.location.href =
                                            '../admin/addroominfo.php';
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: response.message,
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




</body>

</html>