<?php

include './src/config/config.php';

if (isset($_GET['floor']) && isset($_GET['checkin_date'])) {
    $floor = $_GET['floor'];
    $checkinDate = $_GET['checkin_date'];

    $sql = "SELECT roomnumber FROM roominfo WHERE roomfloor = '$floor' AND roomnumber NOT IN (
                SELECT roomnumber FROM reservationprocess 
                WHERE checkindate = '$checkinDate' AND status IN ('Pending', 'Accepted')
            )";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $availableRooms = array();

        while ($row = $result->fetch_assoc()) {
            $availableRooms[] = $row;
        }

        echo json_encode($availableRooms);
    } else {
        echo json_encode(array('error' => 'No available rooms for the selected floor and check-in date'));
    }
} else {
    echo json_encode(array('error' => 'Floor and check-in date parameters are required'));
}
?>