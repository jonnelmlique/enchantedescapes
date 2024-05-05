<?php
include '../src/config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $promoId = $_POST['promoId'];
    $promoName = $_POST['promoName'];
    $percentage = $_POST['percentage'];
    $available = $_POST['available'];

    $sql = "UPDATE eespromo SET promoname = ?, percentage = ?, available = ? WHERE promoid = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("sdii", $promoName, $percentage, $available, $promoId);

    if ($stmt->execute()) {
        $message = "success";
    } else {
        $message = "error";
    }

    $stmt->close();
    $conn->close();

    echo json_encode(["message" => $message]);
}
?>