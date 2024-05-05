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

<?php


if (isset($_GET['transactionid'])) {
    $transactionId = $_GET['transactionid'];

    $sql = "SELECT rp.*, r.roomtype, rp.roomfloor, rp.roomnumber
            FROM reservationprocess rp 
            INNER JOIN room r ON rp.roomid = r.roomid
            WHERE rp.transactionid = '$transactionId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $guestName = $row["firstname"] . " " . $row["lastname"];
        $guestContact = $row["mobilenumber"];
        $guestEmail = $row["emailaddress"];
        $roomType = $row["roomtype"];
        $roomFloor = $row["roomfloor"];
        $roomNumber = $row["roomnumber"];
        $paymentMethod = $row["paymentmethod"];
        $transactionId = $row["transactionid"];
        $status = $row["status"];

    } else {
        $guestName = "N/A";
        $guestContact = "N/A";
        $guestEmail = "N/A";
        $roomType = "N/A";
        $roomFloor = "N/A";
        $roomNumber = "N/A";
        $paymentMethod = "N/A";
        $transactionId = "N/A";
        $status = "N/A";

    }
} else {
    $guestName = "N/A";
    $guestContact = "N/A";
    $guestEmail = "N/A";
    $roomType = "N/A";
    $roomFloor = "N/A";
    $roomNumber = "N/A";
    $paymentMethod = "N/A";
    $transactionId = "N/A";
    $status = "N/A";

}

$conn->close();
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Status</title>

    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="./styles/bootstrap.min.css" rel="stylesheet" />
    <link href="./styles/dashboard.css" rel="stylesheet" />
    <link href="./styles/scrollbar.css" rel="stylesheet" />
    <link href="./styles/reservationdetailsstatus.css" rel="stylesheet" />

</head>


<div> <?php include ("componentshome/navbar.php"); ?>

    <div class="container about-us">
        <section class="about-section">
            <div class="row">
                <div class="col-md-12">
                    <div class="info">
                        <h2 class="title">Transaction Details: <?php echo $transactionId; ?></h2>
                        <hr>
                        <div class="guest">
                            <h5 class="titleguest">Guest Details</h5>
                            <div class="guestinfo">
                                <h6 id="guestName">Name: <?php echo $guestName; ?></h6>
                                <h6 id="guestContact">Contact: <?php echo $guestContact; ?></h6>
                                <h6 id="guestEmail">Email: <?php echo $guestEmail; ?></h6>
                            </div>

                        </div>
                        <div class="reserve">
                            <h5 class="titleguest">Reservation Details</h5>
                            <div class="reservationdetails">
                                <h6 id="roomType">Room Type: <?php echo $roomType; ?>
                                </h6>
                                <h6 id="roomFloor">Room Floor: <?php echo $roomFloor; ?></h6>
                                <h6 id="roomNumber">Room Number: <?php echo $roomNumber; ?></h6>
                            </div>
                        </div>
                        <div class="payment">
                            <h5 class="paymenttitle">Payment Details</h5>
                            <div class="paymentdetails">
                                <h6 id="paymentMethod">Payment Method: <?php echo $paymentMethod; ?></h6>
                                <h6 id="transactionId">Transaction Id: <?php echo $transactionId; ?></h6>
                                <h6 id="status">Status: <?php echo $status; ?></h6>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="buttons">
                        <a href="reservationstatus.php" class="btn btn-primary" id="reserveNowBtn"
                            style="border-radius: 8px; padding: 10px 20px; text-decoration: none; color: #fff;">Back
                        </a>

                    </div>
                </div>

            </div>
        </section>
    </div>

    <script src="scripts/jquery.min.js"></script>
    <script src="scripts/bootstrap.bundle.min.js"></script>


    <?php include ("components/footer.php"); ?>
    </body>

    </html>