<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>
<?php
include '../src/config/config.php';

$room_data = [];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['infoid'])) {
    $roominfo_id = $_GET['infoid'];

    $_SESSION['roominfo_id'] = $roominfo_id;


    try {
        $sql = "SELECT * FROM roominfo WHERE roominfoid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $roominfo_id);
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
        if (isset($_POST["roominfoid"])) {
            $roominfo_id = $_POST["roominfoid"];

            $room_type = isset($_POST["edit-room-type"]) ? $_POST["edit-room-type"] : $room_data['roomtype'];
            $room_number = isset($_POST["edit-room-number"]) ? $_POST["edit-room-number"] : $room_data['roomnumber'];
            $room_floor = isset($_POST["edit-room-floor"]) ? $_POST["edit-room-floor"] : $room_data['roomfloor'];

            $sql_update = "UPDATE roominfo SET roomtype=?, roomnumber=?, roomfloor=? WHERE roominfoid=?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ssii", $room_type, $room_number, $room_floor, $roominfo_id);
            if ($stmt_update->execute()) {
                $message = "Room updated successfully";
            } else {
                throw new Exception("Error updating room: " . $conn->error);
            }
            $stmt_update->close();
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
                <h4 class="fw-bold text-uppercase">&gt; EDIT Room Info</h4>
                <hr>
                <br />

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                    <input type="hidden" name="roominfoid"
                        value="<?php echo isset($_SESSION['roominfo_id']) ? htmlspecialchars($_SESSION['roominfo_id']) : ''; ?>">


                    <div align="right">
                        <div class="row mt-1">
                            <div class="col-4" align="right">
                                <p class="mt-2">Room Type</p>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control" name="edit-room-type" style="border-radius: 8px"
                                    placeholder="Room Type"
                                    value="<?php echo isset($room_data['roomtype']) ? htmlspecialchars($room_data['roomtype']) : ''; ?>"
                                    required />

                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-4" align="right">
                                <p class="mt-2">Room Number</p>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control" name="edit-room-number"
                                    style="border-radius: 8px" placeholder="Room Number"
                                    value="<?php echo isset($room_data['roomnumber']) ? htmlspecialchars($room_data['roomnumber']) : ''; ?>"
                                    required />


                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-4" align="right">
                                <p class="mt-2">Room Floor</p>
                            </div>
                            <div class="col-8">

                                <input type="number" class="form-control" name="edit-room-floor"
                                    style="border-radius: 8px" placeholder="Room Floor"
                                    value="<?php echo isset($room_data['roomfloor']) ? htmlspecialchars($room_data['roomfloor']) : ''; ?>"
                                    required />


                            </div>
                        </div>

                        <div class="buttonf">
                            <a href="./addroominfo.php" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn continue-btn" id="save-room-btn">Save</button>
                        </div>
                    </div>
                </form>
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

    <?php
    if (isset($message)) {
        if (strpos($message, 'successfully') !== false) {
            echo '<script>
            Swal.fire({
                icon: "success",
                title: "Success",
                text: "' . $message . '",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../admin/addroominfo.php";
                }
            });
        </script>';
        } else {
            echo '<script>
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "' . $message . '"
            });
            document.querySelector("input[name=\'roominfoid\']").style.display = "none";
        </script>';
        }
    }
    ?>



</body>

</html>