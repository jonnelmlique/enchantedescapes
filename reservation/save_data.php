<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roomid = $_POST['roomid'];
    $roomName = $_POST['roomName'];
    $roomType = $_POST['roomType'];
    $reservationPrice = $_POST['reservationPrice'];
    $adults = $_POST['adults'];
    $children = $_POST['children'];
    $checkInDate = $_POST['checkInDate'];
    $checkInTime = $_POST['checkInTime'];
    $checkOutDate = $_POST['checkOutDate'];
    $checkOutTime = $_POST['checkOutTime'];

    $_SESSION['reservation_data'] = array(
        'roomid' => $roomid,
        'roomName' => $roomName,
        'roomType' => $roomType,
        'reservationPrice' => $reservationPrice,
        'adults' => $adults,
        'children' => $children,
        'checkInDate' => $checkInDate,
        'checkInTime' => $checkInTime,
        'checkOutDate' => $checkOutDate,
        'checkOutTime' => $checkOutTime
    );

    echo json_encode(array('success' => true));
} else {
    http_response_code(405); 
    echo json_encode(array('error' => 'Method Not Allowed'));
}
?>