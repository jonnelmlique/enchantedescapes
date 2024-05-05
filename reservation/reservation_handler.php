<?php
include './src/config/config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $required_fields = ['roomid', 'floorSelect', 'roomNumberSelect', 'add-adults', 'checkInDate', 'checkInTime', 'checkOutDate', 'checkOutTime'];
    $empty_fields = [];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $empty_fields[] = $field;
        }
    }

    if (!empty($empty_fields)) {
        echo json_encode(["success" => false, "error" => "All fields are required: " . implode(', ', $empty_fields)]);
        exit();
    }
    $guestuserid = $_SESSION['guestuserid'];
    $roomid = $_POST['roomid'];
    $roomfloor = $_POST['floorSelect'];
    $roomnumber = $_POST['roomNumberSelect'];
    $adults = $_POST['add-adults'];
    $children = $_POST['add-children'];
    $checkindate = $_POST['checkInDate'];
    $checkintime = $_POST['checkInTime'];
    $checkoutdate = $_POST['checkOutDate'];
    $checkouttime = $_POST['checkOutTime'];

    $sql_price = "SELECT price, reservationprice FROM room WHERE roomid = ?";
    $stmt_price = $conn->prepare($sql_price);
    $stmt_price->bind_param("i", $roomid);
    $stmt_price->execute();
    $stmt_price->bind_result($price, $reservationprice);
    $stmt_price->fetch();
    $stmt_price->close();

    $sql = "INSERT INTO reservationsummary (guestuserid, roomid, roomfloor, roomnumber, adults, children, checkindate, checkintime, checkoutdate, checkouttime, price, reservationprice) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissiissssss", $guestuserid, $roomid, $roomfloor, $roomnumber, $adults, $children, $checkindate, $checkintime, $checkoutdate, $checkouttime, $price, $reservationprice);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        echo json_encode(["success" => true]);
        exit();
    } else {
        $error_message = "Error: " . $conn->error;
        $stmt->close();
        $conn->close();
        echo json_encode(["success" => false, "error" => $error_message]);
        exit();
    }
}
?>