<?php
include "../src/config/config.php";

if (isset($_POST['room_id']) && filter_var($_POST['room_id'], FILTER_VALIDATE_INT)) {
    if (isset($_POST['action']) && $_POST['action'] === 'update') {
        $room_id = $_POST['room_id'];
        $query = "SELECT * FROM room WHERE roomid = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("i", $room_id);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $existing_room = $result->fetch_assoc();

                    $room_type = $_POST['room_type'];
                    $room_inc = $_POST['room_inc'];
                    $beds_available = $_POST['beds_available'];
                    $max_occupancy = $_POST['max_occupancy'];
                    $deposit = $_POST['deposit'];
                    $price = $_POST['price'];
                    $reservation_price = $_POST['reservation_price'];
                    $status = $_POST['status'];

                    $existing_info = array(
                        'roomtype' => $existing_room['roomtype'],
                        'roominclusion' => $existing_room['roominclusion'],
                        'bedsavailable' => $existing_room['bedsavailable'],
                        'maxoccupancy' => $existing_room['maxoccupancy'],
                        'deposit' => $existing_room['deposit'],
                        'price' => $existing_room['price'],
                        'reservationprice' => $existing_room['reservationprice'],
                        'status' => $existing_room['status']
                    );

                    $new_info = array(
                        'roomtype' => $room_type,
                        'roominclusion' => $room_inc,
                        'bedsavailable' => $beds_available,
                        'maxoccupancy' => $max_occupancy,
                        'deposit' => $deposit,
                        'price' => $price,
                        'reservationprice' => $reservation_price,
                        'status' => $status
                    );

                    if ($existing_info === $new_info) {
                        echo json_encode(array('success' => 'No changes detected.'));
                        exit();
                    }

                    $query = "UPDATE room SET roomtype=?, roominclusion=?, bedsavailable=?, maxoccupancy=?, deposit=?, price=?, reservationprice=?, status=?";
                    $params = "sssiidds";
                    $param_values = array($room_type, $room_inc, $beds_available, $max_occupancy, $deposit, $price, $reservation_price, $status);

                 
                    $param_values[] = $room_id;

                    $stmt = $conn->prepare($query . " WHERE roomid=?");
                    if ($stmt) {
                        $stmt->bind_param($params . "i", ...$param_values);
                        if ($stmt->execute()) {
                            echo json_encode(array('success' => 'Room information updated successfully.'));
                        } else {
                            echo json_encode(array('error' => 'Error updating room information.'));
                        }
                        $stmt->close();
                    } else {
                        echo json_encode(array('error' => 'Error preparing the update statement.'));
                    }
                } else {
                    echo json_encode(array('error' => 'No room found with the provided ID.'));
                }
            } else {
                echo json_encode(array('error' => 'Error executing the fetch statement.'));
            }
            $stmt->close();
        } else {
            echo json_encode(array('error' => 'Error preparing the fetch statement.'));
        }
    } else {
        $room_id = $_POST['room_id'];
        $query = "SELECT * FROM room WHERE roomid = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("i", $room_id);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo json_encode($row);
                } else {
                    echo json_encode(array('error' => 'No room found with the provided ID.'));
                }
            } else {
                echo json_encode(array('error' => 'Error executing the fetch statement.'));
            }
            $stmt->close();
        } else {
            echo json_encode(array('error' => 'Error preparing the fetch statement.'));
        }
    }
} else {
    echo json_encode(array('error' => 'Invalid or missing room_id parameter.'));
}

// Close the database connection
$conn->close();
?>