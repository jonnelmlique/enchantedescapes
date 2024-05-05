<?php
include './src/config/config.php';

if (isset($_POST['checkin_date']) && isset($_POST['checkout_date'])) {
    $checkin_date = $_POST['checkin_date'];
    $checkout_date = $_POST['checkout_date'];

    $sql = "SELECT checkindate, checkoutdate FROM reservationprocess WHERE status IN ('Pending', 'Accepted') AND ((checkindate <= ? AND checkoutdate >= ?) OR (checkindate >= ? AND checkindate <= ?) OR (checkoutdate >= ? AND checkoutdate <= ?))";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $checkin_date, $checkin_date, $checkin_date, $checkout_date, $checkin_date, $checkout_date);

    $stmt->execute();

    $stmt->store_result();

    $stmt->bind_result($existing_checkin_date, $existing_checkout_date);

    $reserved_dates = array();

    while ($stmt->fetch()) {
        $reserved_dates[] = array('checkin_date' => $existing_checkin_date, 'checkout_date' => $existing_checkout_date);
    }

    $stmt->close();

    echo json_encode($reserved_dates);
} else {
    echo json_encode(array('error' => 'Check-in date and checkout date not provided'));
}
$conn->close();
?>