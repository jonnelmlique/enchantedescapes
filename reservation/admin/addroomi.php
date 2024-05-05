<?php
include '../src/config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $room_type = isset($_POST["add-room-type"]) ? $_POST["add-room-type"] : "";
        $room_number = isset($_POST["add-room-number"]) ? $_POST["add-room-number"] : "";
        $room_floor = isset($_POST["add-room-floor"]) ? $_POST["add-room-floor"] : "";

        if (empty($room_type) || empty($room_number) || empty($room_floor)) {
            throw new Exception("Please fill in all required fields");
        }

        $check_query = "SELECT * FROM roominfo WHERE roomnumber = ?";
        $stmt_check = $conn->prepare($check_query);
        $stmt_check->bind_param("s", $room_number);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            throw new Exception("Room number already exists");
        }

        $insert_query = "INSERT INTO roominfo (roomtype, roomnumber, roomfloor, status) VALUES (?, ?, ?, 'Available')";
        $stmt_insert = $conn->prepare($insert_query);
        $stmt_insert->bind_param("ssi", $room_type, $room_number, $room_floor);

        if ($stmt_insert->execute()) {
            $response = array("message" => "success");
        } else {
            throw new Exception("Error adding room information: " . $conn->error);
        }

        $stmt_check->close();
        $stmt_insert->close();
        $conn->close();
    } catch (Exception $e) {
        $response = array("message" => $e->getMessage());
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>