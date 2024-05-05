<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: ../auth/login.php");
    exit(); 
}
?>
<?php
    include '../src/config/config.php';

    $room_data = [];

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
        $room_id = $_GET['id'];

        try {
            $sql = "SELECT * FROM room WHERE roomid = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $room_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $room_data = $result->fetch_assoc();
            } else {
                header("Location: room.php");
                exit;
            }

            $stmt->close();
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            header("Location: error.php");
            exit;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            if (isset($_POST["roomid"])) {
                $room_id = $_POST["roomid"];

                $sql = "SELECT * FROM room WHERE roomid = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $room_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    $room_data = $result->fetch_assoc();

                    $room_type = isset($_POST["edit-room-type"]) ? $_POST["edit-room-type"] : $room_data['roomtype'];
                    $room_inclusion = isset($_POST["edit-room-inc"]) ? $_POST["edit-room-inc"] : $room_data['roominclusion'];
                    $beds_available = isset($_POST["edit-room-beds"]) ? $_POST["edit-room-beds"] : $room_data['bedsavailable'];
                    $max_occupancy = isset($_POST["edit-room-maxoccupancy"]) ? $_POST["edit-room-maxoccupancy"] : $room_data['maxoccupancy'];
                    $price = isset($_POST["edit-price"]) ? $_POST["edit-price"] : $room_data['price'];
                    $reservation_price = isset($_POST["edit-rprice"]) ? $_POST["edit-rprice"] : $room_data['reservationprice'];
                    $status = isset($_POST["edit-status"]) ? $_POST["edit-status"] : $room_data['status'];
              
                    if (isset($_FILES['edit-image']) && $_FILES['edit-image']['error'] === UPLOAD_ERR_OK) {
                        $image_name = $_FILES['edit-image']['name'];
                        $image_tmp_name = $_FILES['edit-image']['tmp_name'];
                        $image_destination = '../rooms/' . $image_name; 
                        move_uploaded_file($image_tmp_name, $image_destination);

                        $sql_update_image = "UPDATE room SET image = ? WHERE roomid = ?";
                        $stmt_update_image = $conn->prepare($sql_update_image);
                        $stmt_update_image->bind_param("si", $image_name, $room_id);
                        $stmt_update_image->execute();
                        $stmt_update_image->close();
                    }

                    $sql_update = "UPDATE room SET roomtype=?, roominclusion=?, bedsavailable=?, maxoccupancy=?, price=?, reservationprice=?, status=? WHERE roomid=?";
                    $stmt_update = $conn->prepare($sql_update);
                    $stmt_update->bind_param("sssiddsi", $room_type, $room_inclusion, $beds_available, $max_occupancy, $price, $reservation_price, $status, $room_id);
                    if ($stmt_update->execute()) {
                        $message = "Room updated successfully";
                    } else {
                        throw new Exception("Error updating room: " . $conn->error);
                    }
                    $stmt_update->close();
                } else {
                    throw new Exception("Room not found");
                }
            } else {
                throw new Exception("Room ID not provided");
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
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
                <h4 class="fw-bold text-uppercase">&gt; EDIT Room</h4>
                <hr>
                <br />

                <div align="right">
                    <div class="row mt-1">

                        <div class="col-4" align="right">
                            <p class="mt-2">Room Type</p>
                        </div>
                        <div class="col-8">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                                enctype="multipart/form-data">
                                <input type="hidden" name="roomid"
                                    value="<?php echo htmlspecialchars($room_data['roomid']); ?>">

                                <select class="form-control" id="edit-room-type" name="edit-room-type"
                                    style="border-radius: 8px" required>
                                    <option value="" disabled>Select Room Type</option>
                                    <?php
                                        $sql = "SELECT DISTINCT roomtype FROM roominfo";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $selected = ($row['roomtype'] == $room_data['roomtype']) ? 'selected' : '';
                                                echo "<option value='" . $row['roomtype'] . "' $selected>" . $row['roomtype'] . "</option>";
                                            }
                                        }
                                        ?>
                                </select>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-4" align="right">
                            <p class="mt-2">Room Inclusion</p>
                        </div>
                        <div class="col-8"><input type="text" class="form-control" name="edit-room-inc"
                                style="border-radius: 8px" placeholder="Room Inclusion"
                                value="<?php echo htmlspecialchars($room_data['roominclusion']); ?>" required />
                        </div>

                    </div>
                    <div class="row mt-1">
                        <div class="col-4" align="right">
                            <p class="mt-2">Beds Available</p>
                        </div>
                        <div class="col-8"> <input type="text" class="form-control" name="edit-room-beds"
                                style="border-radius: 8px" placeholder="Beds Available"
                                value="<?php echo htmlspecialchars($room_data['bedsavailable']); ?>" required />
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4" align="right">
                            <p class="mt-2">Max Occupancy</p>
                        </div>
                        <div class="col-8"> <input type="number" class="form-control" name="edit-room-maxoccupancy"
                                style="border-radius: 8px" placeholder="Max Occupancy"
                                value="<?php echo htmlspecialchars($room_data['maxoccupancy']); ?>" required />
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-4" align="right">
                            <p class="mt-2">Price</p>
                        </div>
                        <div class="col-8"> <input type="number" class="form-control" name="edit-price"
                                style="border-radius: 8px" placeholder="Price"
                                value="<?php echo htmlspecialchars($room_data['price']); ?>" required />
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4" align="right">
                            <p class="mt-2">Reservation Price</p>
                        </div>
                        <div class="col-8"> <input type="number" class="form-control" name="edit-rprice"
                                style="border-radius: 8px" placeholder="Reservation Price"
                                value="<?php echo htmlspecialchars($room_data['reservationprice']); ?>" required />
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-4" align="right">
                            <p class="mt-2">Status</p>
                        </div>
                        <div class="col-8">
                            <select class="form-control" name="edit-status" style="border-radius: 8px" required>
                                <option value="Available" <?php if ($room_data['status'] == 'Available')
                                        echo 'selected'; ?>>Available</option>
                                <option value="Booked" <?php if ($room_data['status'] == 'Booked')
                                        echo 'selected'; ?>>
                                    Booked</option>
                            </select>
                        </div>
                    </div>


                    <div class="row mt-1">
                        <div class="col-4" align="right">
                            <p class="mt-2">Image</p>
                        </div>
                        <div class="col-8"> <input type="file" class="form-control" name="edit-image"
                                style="border-radius: 8px" />

                        </div>
                    </div>
                    <div class="buttonf">

                        <a href="./rooms.php" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn continue-btn" id="save-room-btn">Save</button><br>
                        </form>
                    </div>
                </div>
                <br>

            </div>
        </div>

        <br /><br />
    </div>
    </div>




    <script src="../scripts/jquery.min.js"></script>
    <script src="../scripts/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        <?php
                if (isset($message)) {
                    if (strpos($message, 'successfully') !== false) {
                        echo "Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: '$message',
                            confirmButtonText: 'OK',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '../admin/rooms.php';
                            } 
                        });";
                    } else {
                        echo "Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: '$message',
                        });";
                    }
                }
                ?>
    });
    </script>



</body>

</html>