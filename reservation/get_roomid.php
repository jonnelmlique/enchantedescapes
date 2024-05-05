<?php
session_start();

if (isset($_SESSION['guestuserid'])) {
    $guestuserid = $_SESSION['guestuserid'];

    include './src/config/config.php';

    $sql = "SELECT roomid, roomfloor, roomnumber, adults, children, checkindate, checkintime, checkoutdate, checkouttime, price, reservationprice FROM reservationsummary WHERE guestuserid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $guestuserid);
    $stmt->execute();
    $result = $stmt->get_result();

    $bookingCartData = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $bookingCartData[] = $row;
        }
    }

    $stmt->close();
    $conn->close();

    echo json_encode($bookingCartData);
} else {
    echo "Guest user ID not found in session.";
}
?>