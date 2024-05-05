<?php
include './src/config/config.php';

if (isset($_POST['reservationId'])) {
    $reservationId = mysqli_real_escape_string($conn, $_POST['reservationId']);

    $sql = "DELETE FROM reservationsummary WHERE reservationsumid = '$reservationId'";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Unable to delete reservation']);
    }
} else {
    echo json_encode(['error' => 'Reservation ID not provided']);
}
?>